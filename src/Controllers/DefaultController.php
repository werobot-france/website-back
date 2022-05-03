<?php

namespace App\Controllers;

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;

class DefaultController extends Controller {

    public function home($_, ResponseInterface $response) {
        return $response
            ->withJson([
                'name' => $this->container->get('app_name'),
                'environment' => $this->container->get('app_env'),
                'message' => 'This is the main page of the application'
            ]);
    }

    public function getInfo($_, ResponseInterface $response) {
        return $response
            ->withJson([
                'success' => true,
                'authenticated' => true
            ]);
    }

    public function getPing($_, ResponseInterface $response) {
        $response->getBody()->write('pong!');

        return $response;
    }
}
