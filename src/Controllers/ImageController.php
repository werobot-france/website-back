<?php

namespace App\Controllers;

use App\Models\Image;
use Pagerfanta\Adapter\ArrayAdapter;
use Pagerfanta\Pagerfanta;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Http\Response;
use Validator\Validator;

class ImageController extends Controller
{
    public function getMany(ServerRequestInterface $request, Response $response)
    {
        $this->loadDatabase();
        $images = Image::query()
            ->select(['id', 'type', 'extension', 'created_at', 'caption'])
            ->orderBy('created_at', 'DESC')
            ->get()->toArray();
        $adapter = new ArrayAdapter($images);
        $pager = new Pagerfanta($adapter);

        $maxPerPage = intval(isset($request->getQueryParams()['per_page']) ? $request->getQueryParams()['per_page'] : 10);
        $pager->setMaxPerPage($maxPerPage);

        $currentPage = intval(isset($request->getQueryParams()['page']) && $request->getQueryParams()['page'] > 1 && $request->getQueryParams()['page'] <= $pager->getNbPages() ? $request->getQueryParams()['page'] : 1);
        $pager->setCurrentPage($currentPage);

        $resultCount = $pager->getNbResults();
        $currentPageResults = $pager->getCurrentPageResults();
        return $response->withJson([
            'success' => true,
            'data' => [
                'image_public_path' => $this->container->get('image_upload')['public_base_path'],
                'pagination' => [
                    'total_page' => $pager->getNbPages(),
                    'per_page' => $maxPerPage,
                    'result_count' => $resultCount,
                    'current_page' => $currentPage,
                    'next_page' => $currentPage !== $pager->getNbPages() ? $pager->getNextPage() : false,
                    'previous_page' => $currentPage !== 1 ? $pager->getPreviousPage() : false
                ],
                'images' => $currentPageResults
            ]
        ]);
    }

    public function getOne($id, Response $response)
    {
        $this->loadDatabase();
        $image = Image::query()->find($id);
        if ($image == NULL) {
            return $response->withJson(['success' => false], 404);
        }
        return $response->withJson([
            'success' => true,
            'data' => $image->toArray()
        ]);
    }

    public function display($id, ServerRequestInterface $request, Response $response)
    {
        $this->loadDatabase();
        $image = Image::query()->find($id);
        if ($image == NULL) {
            return $response->withJson(['success' => false], 404);
        }
        $destinationPath = $this->container->get('root_path') . '/' . $this->container->get('image_upload')['destination_path'];
        $path = $destinationPath . '/' . $id . '/' . 'original.' . $image['extension'];
        if (isset($request->getQueryParams()['size'])) {
            $size = 'original';
            switch ($request->getQueryParams()['size']) {
                case 25:
                    $size = 25;
                    break;
                case 50:
                    $size = 50;
                    break;
                case 75:
                    $size = 75;
                    break;
                case 'medium':
                    $size = 50;
                    break;
                case 'small':
                    $size = 25;
                    break;
                case 'large':
                    $size = 75;
            }
            $path = str_replace('original', $size, $path);
        }
        return $response
            ->withHeader('Content-Type', $image['type'])
            ->write(file_get_contents($path));
    }

    public function update($id, ServerRequestInterface $request, Response $response)
    {
        $validator = new Validator($request->getParsedBody());
        $validator->notEmpty('caption');
        if (!$validator->isValid()) {
            return $response->withJson([
                'success' => false,
                'errors' => $validator->getErrors()
            ]);
        }
        $this->loadDatabase();
        $image = Image::query()->find($id);

        if ($image == NULL) {
            return $response->withJson(['success' => false], 404);
        }

        if ($validator->getValue('caption') !== NULL) {
            $image['caption'] = $validator->getValue('caption');
            $image->save();
        }

        return $response->withJson([
            'success' => true
        ]);
    }

    public function destroy($id, Response $response)
    {
        $this->loadDatabase();
        $image = Image::query()->find($id);
        if ($image == NULL) {
            return $response->withJson(['success' => false], 404);
        }
        $destinationPath = $this->container->get('root_path') . '/' . $this->container->get('image_upload')['destination_path'];
        unlink($destinationPath . '/' . $image['id'] . '/75.' . $image['extension']);
        unlink($destinationPath . '/' . $image['id'] . '/50.' . $image['extension']);
        unlink($destinationPath . '/' . $image['id'] . '/25.' . $image['extension']);
        unlink($destinationPath . '/' . $image['id'] . '/original.' . $image['extension']);
        rmdir($destinationPath . '/' . $image['id']);
        Image::destroy($image['id']);
        return $response->withJson([
            'success' => true
        ]);
    }
}
