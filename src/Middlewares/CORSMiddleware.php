<?php

namespace App\Middlewares;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Slim\Http\Factory\DecoratedResponseFactory;
use Slim\Http\Response;
use Slim\Psr7\Factory\ResponseFactory;
use Slim\Psr7\Factory\StreamFactory;
use Psr\Container\ContainerInterface;

class CORSMiddleware
{
    public function __construct(
        private ContainerInterface $container
    )
    {
    }

    public function __invoke(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $allowedOrigins = [
            ...$this->container->get('cors_allowed_origins')
        ];
        if (!$request->hasHeader('Origin')) {
            // do not treat this request with CORS
            return $handler->handle($request);
        }
        $origin = $request->getHeader('Origin')[0];
        if (in_array($origin, $allowedOrigins) === false) {
            // this origin is not allowed, skip CORS
            return $handler->handle($request);
        }

        if ($request->getMethod() === 'OPTIONS') {
            $response = (new DecoratedResponseFactory(new ResponseFactory(), new StreamFactory()))->createResponse();
            return $this
                ->alterResponse($origin, $response)
                ->withJson(true);
        }

        $response = $handler->handle($request);

        return $this->alterResponse($origin, $response);
    }

    private function alterResponse(string $origin, ResponseInterface $response): ResponseInterface
    {
        return $response
            ->withHeader('Access-Control-Allow-Origin', $origin)
            ->withHeader('Access-Control-Allow-Methods', 'POST, PUT, GET, OPTIONS, DELETE')
            ->withHeader('Access-Control-Allow-Headers', 'Origin, Content-Type, Authorization');
    }
}
