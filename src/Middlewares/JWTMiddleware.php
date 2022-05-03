<?php

namespace App\Middlewares;

use App\Auth\Session;
use Firebase\JWT\JWT;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Slim\Http\Factory\DecoratedResponseFactory;
use Slim\Http\Response;
use Slim\Psr7\Factory\ResponseFactory;
use Slim\Psr7\Factory\StreamFactory;
use Psr\Http\Message\ResponseInterface;

class JWTMiddleware
{
    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * @var Session|mixed
     */
    private $session;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
        $this->session = $container->get(Session::class);
    }

    public function __invoke(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        if (!$request->hasHeader('Authorization')) {
            $response = (new DecoratedResponseFactory(new ResponseFactory(), new StreamFactory()))->createResponse();
            return $response
                ->withStatus(401)
                ->withJson([
                    'success' => false,
                    'errors' => [
                        [
                            'message' => 'Authorization header is missing',
                            'code' => 'auth_header_missing'
                        ]
                    ]
                ]);
        }

        $token = str_replace('Bearer ', '', $request->getHeader('Authorization'))[0];
        //master api key bypass
        if ($token === $this->container->get('master_api_key')){
            $this->session->setData(['user' => ['is_admin' => true]]);

            return $handler->handle($request);
        }
        try {
            $decoded = JWT::decode($token, $this->container->get('jwt')['key'], ['HS256']);
        } catch (\Exception $e) {
            $response = (new DecoratedResponseFactory(new ResponseFactory(), new StreamFactory()))->createResponse();
            return $response
                ->withStatus(401)
                ->withJson([
                    'success' => false,
                    'errors' => [
                        [
                            'message' => 'Authorization header is invalid : invalid token',
                            'code' => 'auth_header_invalid'
                        ]
                    ]
                ]);
        }
        $this->session->setData(json_decode(json_encode($decoded), 1));
        $this->session->setToken($token);

        return $handler->handle($request);
    }
}