<?php

namespace App\Controllers;

use Psr\Http\Message\ServerRequestInterface;
use Slim\Http\Response;

class CORSController extends Controller
{
    public function allOptions(ServerRequestInterface $request, Response $response) {
        return $response->withJson(true);
    }

//    public function allOptions(ServerRequestInterface $request, Response $response) {
//        return $response->withJson(true);
//    }
}