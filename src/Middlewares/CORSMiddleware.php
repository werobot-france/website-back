<?php

namespace App\Middlewares;

use Psr\Container\ContainerInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Http\Response;

class CORSMiddleware
{
    /**
     * @var ContainerInterface
     */
    private $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function __invoke(ServerRequestInterface $request, Response $response, $next)
    {
        $allowedOrigins = $this->container->get('cors_allowed_origins');
        if (!$request->hasHeader('Origin')) {
            if ($request->getRequestTarget() === '/check-origin') {
                return $response->withJson(['success' => false, 'errors' => ['No Origin header detected']], 400);
            }
            return $next($request, $response);
        }
        $origin = $request->getHeader('Origin')[0];
        if (!in_array($origin, $allowedOrigins)) {
            if ($request->getMethod() === "OPTIONS") {
                return $response->withJson(false);
            }
            if ($request->getRequestTarget() === '/check-origin') {
                return $response->withJson(['success' => true, 'is_allowed' => false]);
            }
            return $next($request, $response);
        }
        $response = $response
            ->withHeader('Access-Control-Allow-Origin', $origin)
            ->withHeader('Access-Control-Allow-Methods', 'POST, PUT, GET, OPTIONS, DELETE')
            ->withHeader('Access-Control-Allow-Headers', 'Origin, Content-Type, Authorization');
        if ($request->getMethod() == "OPTIONS") {
            return $response->withJson(true);
        }
        if ($request->getRequestTarget() === '/check-origin') {
            return $response->withJson(['success' => true, 'is_allowed' => true]);
        }

        return $next($request, $response);
    }
}
