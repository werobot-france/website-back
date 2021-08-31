<?php

namespace App\Controllers;

use Slim\Http\Response;

class CORSController extends Controller
{
    public function allOptions(Response $response) {
        return $response->withJson(true);
    }

    public function getAllowedOrigins(Response $response) {
        $allowedOrigins = $this->container->get('cors_allowed_origins');
        return $response->withJson([
            'success' => true,
            'data' => $allowedOrigins
        ]);
    }

    public function notFound(Response $response) {
        return $response->withJson([
            'success' => false,
            'errors' => ['Page not found']
        ], 404);
    }
}