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
        $allowedHosts = $this->container->get('cors_allowed_hosts');
        if (!in_array($request->getHeader('Host'), $allowedHosts)) {
            if ($request->getMethod() === "OPTIONS") {
                return $response->withJson(false);
            }
            return $next($request, $response);
        }
        $response = $response
            ->withHeader('Access-Control-Allow-Origin', $request->getHeader('Host'))
            ->withHeader('Access-Control-Allow-Methods', 'POST, PUT, GET, OPTIONS, DELETE')
            ->withHeader('Access-Control-Allow-Headers', 'Origin, Content-Type, Authorization');
        if ($request->getMethod() == "OPTIONS") {
            return $response->withJson(true);
        }
        return $next($request, $response);
    }
}
