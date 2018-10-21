<?php
$app->options('/{routes:.+}', [\App\Controllers\CORSController::class, 'allOptions']);
//$app->map(['GET', 'POST', 'PUT', 'DELETE', 'PATCH'], '/{routes:.+}', [\App\Controllers\CORSController::class, 'allOptions']);

$app->add(new \App\Middlewares\CORSMiddleware());

$app->get('/', [\App\Controllers\DefaultController::class, 'home']);

$app->group('/post', function () use ($app) {
   $this->get('[/]', [\App\Controllers\Blog\PostController::class, 'getMany']);
   $this->get('/{id}[/]', [\App\Controllers\Blog\PostController::class, 'getOne']);
   $this->post('[/]', [\App\Controllers\Blog\PostController::class, 'store'])
       ->add(new \App\Middlewares\JWTMiddleware($app->getContainer()));
   $this->put('/{id}[/]', [\App\Controllers\Blog\PostController::class, 'update'])
       ->add(new \App\Middlewares\JWTMiddleware($app->getContainer()));
   $this->delete('/{id}[/]', [\App\Controllers\Blog\PostController::class, 'destroy'])
       ->add(new \App\Middlewares\JWTMiddleware($app->getContainer()));
});

$app->group('/message', function () use ($app) {
    $this->get('[/]', [\App\Controllers\MessageController::class, 'getMany']);
    $this->get('/{id}[/]', [\App\Controllers\MessageController::class, 'getOne']);
    $this->delete('/{id}[/]', [\App\Controllers\MessageController::class, 'destroy']);
})->add(new \App\Middlewares\JWTMiddleware($app->getContainer()));

$app->post('/contact', [\App\Controllers\ContactController::class, 'contact'])
    ->add(new \RKA\Middleware\IpAddress());

$app->group('/auth', function (){
    $this->get('/login[/]', [\App\Controllers\Account\STAILEUController::class, 'getLogin']);

    $this->get('info', [\App\Controllers\Account\STAILEUController::class, 'getInfo'])
        ->add(new \App\Middlewares\JWTMiddleware($this->getContainer()));

    $this->post('/execute[/]', [\App\Controllers\Account\STAILEUController::class, 'execute'])
        ->add(new \RKA\Middleware\IpAddress());
});
