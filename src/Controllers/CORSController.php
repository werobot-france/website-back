<?php

namespace App\Controllers;

use Slim\Http\Response;

class CORSController extends Controller
{
    public function allOptions(Response $response) {
        return $response->withJson(true);
    }

    public function notFound(Response $response) {
        return $response->withJson([
            'success' => false,
            'errors' => ['Page not found']
        ], 404);
    }
}