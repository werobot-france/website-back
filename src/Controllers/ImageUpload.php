<?php

namespace App\Controllers;

use App\Auth\Session;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Http\Response;
use Slim\Http\UploadedFile;
use Validator\Validator;

class ImageUpload extends Controller
{
    public function upload(ServerRequestInterface $request, Response $response, Session $session)
    {
        $validator = new Validator($request->getUploadedFiles());
        $validator->required('image');
        $validator->notEmpty('image');
        if (!$validator->isValid()) {
            return $response->withJson([
                'success' => false,
                'errors' => $validator->getErrors()
            ], 400);
        }
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
            $this->container->get('root_path') .
            '/' . $this->container->get('image_upload')['destination_path'] .
            '/' . $fileName
        );

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
