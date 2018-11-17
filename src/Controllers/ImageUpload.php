<?php

namespace App\Controllers;

use GuzzleHttp\Client;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Http\Response;
use Slim\Http\UploadedFile;
use Validator\Validator;

class ImageUpload extends Controller
{
    public function upload(ServerRequestInterface $request, Response $response)
    {
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
        if (!isset($request->getUploadedFiles()['image'])) {
            if (is_string($validator->getValue('image')) && filter_var($validator->getValue('image'), FILTER_VALIDATE_URL)) {
                $httpResponse = (new Client())
                    ->get($validator->getValue('image'));
                $contentType = $httpResponse->getHeader('Content-Type')[0];
                $ext = '';
                switch ($contentType) {
                    case 'image/png':
                        $ext = 'png';
                        break;

                    case 'image/jpeg':
                        $ext = 'jpg';
                        break;

                    case 'image/gif':
                        $ext = 'gif';
                        break;
                }
                if ($ext == '') {
                    return $response->withJson([
                        'success' => false,
                        'errors' => [
                            'The image field must be an valid image url'
                        ]
                    ], 400);
                }
                $fileName = uniqid() . '.' . $ext;
                file_put_contents($destinationPath . '/' . $fileName, $httpResponse->getBody()->getContents());
                file_get_contents($validator->getValue('image'));
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
            $fileName = uniqid() . '.' . $this->MIMETypeToExtension($uploadedFile->getClientMediaType());
            $uploadedFile->moveTo(
                $destinationPath . '/' . $fileName
            );
        }

        return $response->withJson([
            'success' => true,
            'data' => [
                'url' => $this->container->get('image_upload')['public_base_path'] . '/' . $fileName
            ]
        ]);
    }

    public function MIMETypeToExtension(string $MIMEType): string
    {
        return [
            'image/jpeg' => 'jpg',
            'image/gif' => 'gif',
            'image/png' => 'png'
        ][$MIMEType];
    }
}
