<?php

namespace App\Controllers;

use App\ImageHelper;
use App\Models\Image;
use GuzzleHttp\Client;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Http\Response;
use Slim\Http\UploadedFile;
use Validator\Validator;

class ImageUpload extends Controller
{
    public function upload(ServerRequestInterface $request, Response $response)
    {
        // TODO: check for an existing hash in the database
        $validator = new Validator($request->getUploadedFiles() == [] ? $request->getParsedBody() : $request->getUploadedFiles() );
        $validator->required('image');
        $validator->notEmpty('image');
        if (!$validator->isValid()) {
            return $response->withJson([
                'success' => false,
                'errors' => $validator->getErrors()
            ], 400);
        }
        $destinationPath = $this->container->get('root_path') . '/' . $this->container->get('image_upload')['destination_path'];
        $id = uniqid();
        if (!isset($request->getUploadedFiles()['image'])) {
            // upload file from a url
            if (is_string($validator->getValue('image')) && filter_var($validator->getValue('image'), FILTER_VALIDATE_URL)) {
                $httpResponse = (new Client())
                    ->get($validator->getValue('image'));
                $type = $httpResponse->getHeader('Content-Type')[0];
                $ext = ImageHelper::MIMETypeToExtension($type);
                if ($ext == '') {
                    return $response->withJson([
                        'success' => false,
                        'errors' => [
                            'The image field must be an valid image url'
                        ]
                    ], 400);
                }
                mkdir($destinationPath . '/' . $id);
                $hash = hash('sha256', $httpResponse->getBody()->getContents());
                file_put_contents($destinationPath . '/' . $id . '/original.' . $ext, $httpResponse->getBody()->getContents());
            } else {
                return $response->withJson([
                    'success' => false,
                    'errors' => [
                        'The image field must be an url or an image'
                    ]
                ], 400);
            }
        } else {
            /** @var $uploadedFile UploadedFile */
            $uploadedFile = $request->getUploadedFiles()['image'];
            if (explode('/', $uploadedFile->getClientMediaType())[0] != 'image') {
                return $response->withJson([
                    'success' => false,
                    'errors' => [
                        'The uploaded file must be an image'
                    ]
                ], 400);
            }
            $type = $uploadedFile->getClientMediaType();
            $ext = ImageHelper::MIMETypeToExtension($type);
            mkdir($destinationPath . '/' . $id);
            $hash = hash('sha256', $uploadedFile->getStream()->getContents());
            $uploadedFile->moveTo($destinationPath . '/' . $id . '/original.' . $ext);
        }

        $this->loadDatabase();
        $image = new Image();
        $image['id'] = $id;
        $image['extension'] = $ext;
        $image['type'] = $type;
        $image['hash'] = $hash;
        $image->save();

        ImageHelper::import($destinationPath . '/' . $id . '/original.' . $ext);
        return $response->withJson([
            'success' => true,
            'data' => [
                'id' => $id,
                'url' => $this->container->get('image_upload')['public_base_path'] . '/' . $id . '/original.' . $ext
            ]
        ]);
    }
}
