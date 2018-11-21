<?php

namespace App\Controllers;

use App\Instagram;
use Lefuturiste\LocalStorage\LocalStorage;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Http\Response;
use Validator\Validator;

class PhotosController extends Controller
{
    public function photos(ServerRequestInterface $request, Response $response, Instagram $instagram, LocalStorage $localStorage)
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
        if (!$localStorage->exist('instagram.medias')) {
            $photos = $instagram->getMedias();
            $localStorage->set('instagram.medias', $photos);
            $localStorage->save();
        } else {
            $photos = $localStorage->get('instagram.medias');
        }
        return $response->withJson([
            'success' => true,
            'data' => [
                'photos' => array_slice($photos, 0, $limit)
            ]
        ]);
    }
}
