<?php
$app->options('/{routes:.+}', [\App\Controllers\CORSController::class, 'allOptions']);

$app->add(new \App\Middlewares\CORSMiddleware());

$app->get('/', [\App\Controllers\DefaultController::class, 'home']);

$app->group('/backup', function () {
    $this->get('[/]', [\App\Controllers\BackupController::class, 'getMany']);
    $this->get('/{id}[/]', [\App\Controllers\BackupController::class, 'getOne']);
    $this->post('[/]', [\App\Controllers\BackupController::class, 'create']);
})->add(new \App\Middlewares\JWTMiddleware($app->getContainer()));

$app->group('/post', function () use ($app) {
    $this->get('[/]', [\App\Controllers\PostController::class, 'getMany']);
    $this->get('/dates[/]', [\App\Controllers\PostController::class, 'getDates']);
    $this->get('/{id}[/]', [\App\Controllers\PostController::class, 'getOne']);
    $this->post('[/]', [\App\Controllers\PostController::class, 'store'])
        ->add(new \App\Middlewares\JWTMiddleware($app->getContainer()));
    $this->put('/{id}[/]', [\App\Controllers\PostController::class, 'update'])
        ->add(new \App\Middlewares\JWTMiddleware($app->getContainer()));
    $this->delete('/{id}[/]', [\App\Controllers\PostController::class, 'destroy'])
        ->add(new \App\Middlewares\JWTMiddleware($app->getContainer()));
});

$app->get('/cache/clear', [\App\Controllers\CacheController::class, 'clear'])
    ->add(new \App\Middlewares\JWTMiddleware($app->getContainer()));

$app->group('/message', function () use ($app) {
    $this->get('[/]', [\App\Controllers\MessageController::class, 'getMany']);
    $this->get('/{id}[/]', [\App\Controllers\MessageController::class, 'getOne']);
    $this->delete('/{id}[/]', [\App\Controllers\MessageController::class, 'destroy']);
})->add(new \App\Middlewares\JWTMiddleware($app->getContainer()));

$app->post('/contact', [\App\Controllers\ContactController::class, 'contact'])
    ->add(new \RKA\Middleware\IpAddress());

$app->get('/photos', [\App\Controllers\PhotosController::class, 'photos']);

//$app->group('/oauth', function () {
//    $this->get('/twitter/authorize', [TwitterController::class]);
//    $this->get('/facebook/authorize');
//    $this->post('/facebook/execute');
//    $this->post('/twitter/execute');
//})->add(new \App\Middlewares\JWTMiddleware());

$app->post('/image-upload', [\App\Controllers\ImageUpload::class, 'upload'])
    ->add(new \App\Middlewares\CORSMiddleware())
    ->add(new \App\Middlewares\JWTMiddleware($app->getContainer()));

$app->group('/auth', function () {
    $this->get('/login[/]', [\App\Controllers\STAILEUController::class, 'getLogin']);

    $this->get('/info', [\App\Controllers\STAILEUController::class, 'getInfo'])
        ->add(new \App\Middlewares\JWTMiddleware($this->getContainer()));

    $this->post('/execute[/]', [\App\Controllers\STAILEUController::class, 'execute'])
        ->add(new \RKA\Middleware\IpAddress());
});

$app->map(['GET', 'POST', 'PUT', 'DELETE', 'PATCH'], '/{routes:.+}', [\App\Controllers\CORSController::class, 'notFound']);

