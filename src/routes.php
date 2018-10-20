<?php

$app->get('/', [\App\Controllers\DefaultController::class, 'home']);
$app->group('/post', function () use ($app) {
   $this->get('[/]', [\App\Controllers\Blog\PostController::class, 'getMany']);
   $this->get('/{id}[/]', [\App\Controllers\Blog\PostController::class, 'getOne']);
   $this->post('[/]', [\App\Controllers\Blog\PostController::class, 'store'])
       ->add(new \App\Middlewares\JWTMiddleware($app->getContainer()));
   $this->map(['POST', 'PUT'], '/{id}[/]', [\App\Controllers\Blog\PostController::class, 'update'])
       ->add(new \App\Middlewares\JWTMiddleware($app->getContainer()));
   $this->delete('/{id}[/]', [\App\Controllers\Blog\PostController::class, 'destroy'])
       ->add(new \App\Middlewares\JWTMiddleware($app->getContainer()));
})->add(new \App\Middlewares\CORSMiddleware());

$app->map(['POST', 'OPTIONS'], '/contact', [\App\Controllers\ContactController::class, 'contact'])
    ->add(new \RKA\Middleware\IpAddress())
    ->add(new \App\Middlewares\CORSMiddleware());

$app->group('/auth', function (){
    $this->get('/login[/]', [\App\Controllers\Account\STAILEUController::class, 'getLogin']);

    $this->map(['GET', 'OPTIONS'], 'info', [\App\Controllers\Account\STAILEUController::class, 'getInfo'])
        ->add(new \App\Middlewares\JWTMiddleware($this->getContainer()));

    $this->map(['GET', 'POST', 'OPTIONS'], '/execute[/]', [\App\Controllers\Account\STAILEUController::class, 'execute'])
        ->add(new \RKA\Middleware\IpAddress());
})->add(new \App\Middlewares\CorsMiddleware());
