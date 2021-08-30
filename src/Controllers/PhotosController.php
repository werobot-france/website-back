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
        $photos = $instagram->getMedias();
//        if (!$localStorage->exist('instagram.medias')) {
//            $localStorage->set('instagram.medias', $photos);
//            $localStorage->save();
//        } else {
//            $photos = $localStorage->get('instagram.medias');
//        }
        return $response->withJson([
            'success' => true,
            'data' => [
                'photos' => array_slice($photos, 0, $limit)
            ]
        ]);
    }

    public function proxyInstagramImage(ServerRequestInterface $request, Response $response)
    {
        $validator = new Validator($request->getQueryParams());
        $validator->required('url');
        $validator->notEmpty('url');
        if (!$validator->isValid()) {
            return $response->withJson([
                'success' => false,
                'errors' => $validator->getErrors()
            ], 400);
        }
        $url = base64_decode($validator->getValue('url'));

        $fileName = hash('sha256', $url) . '.jpg';
        $rootPath = $this->container->get('root_path') . '/tmp/instagram_cache';
        $fullPath = $rootPath . '/' . $fileName;

        if (!file_exists($rootPath)) {
            mkdir($rootPath);
        }

        if (!function_exists('str_ends_with')) {
            function str_ends_with($haystack, $needle) {
                $length = strlen($needle);
                return $length > 0 ? substr($haystack, -$length) === $needle : true;
            }
        }

        if (file_exists($fullPath)) {
            $content = file_get_contents($fullPath);
        }
        else {
            $parsed = parse_url($url);
            if (!str_ends_with($parsed['host'], 'cdninstagram.com')) {
                return $response->withJson(['success' => false, 'errors' => ['Invalid host']]);
            }
            if ($parsed['scheme'] !== 'https') {
                return $response->withJson(['success' => false, 'errors' => ['Invalid scheme']]);
            }
            $content = file_get_contents($url);
            file_put_contents($fullPath, $content);
        }
    
        $response->getBody()->write($content);
        return $response
          ->withHeader('Content-Type', 'image/jpeg');
    }
}
