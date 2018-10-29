<?php

namespace App\Controllers;

use App\Instagram;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Http\Response;
use Validator\Validator;

class PhotosController extends Controller
{
    public function photos(ServerRequestInterface $request, Response $response, Instagram $instagram)
    {
        $validator = new Validator($request->getQueryParams());
        $validator->notEmpty('limit');
        $validator->integer('limit');
        if (!$validator->isValid()) {
            return $response->withJson([
                'success' => false,
                'errors' => $validator->getErrors()
            ], 400);
        }
        $limit = $validator->getValue('limit');
        $photos = $instagram->getMedias();
        return $response->withJson([
            'success' => true,
            'data' => [
                'photos' => array_slice($photos, 0, $limit)
            ]
        ]);
    }
}