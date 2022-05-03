<?php

namespace App;

use App\Middlewares\JWTMiddleware;
use RKA\Middleware\IpAddress;
use Slim\Routing\RouteCollectorProxy;

function addRoutes(\Slim\App $app): void
{
    $container = $app->getContainer();

    $app->add(new Middlewares\CORSMiddleware($container));

    $app->get('/', [Controllers\DefaultController::class, 'home']);
    $app->get('/ping', [Controllers\DefaultController::class, 'getPing']);

    $app->group('/backup', function (RouteCollectorProxy $group) {
        $group->get('[/]', [Controllers\BackupController::class, 'getMany']);
        $group->get('/{id}[/]', [Controllers\BackupController::class, 'getOne']);
        $group->post('[/]', [Controllers\BackupController::class, 'create']);
    })->add(new JWTMiddleware($container));

    $app->get('/feed[/]', [Controllers\FeedController::class, 'getFeed']);

    $app->group('/post', function (RouteCollectorProxy $group) use ($container) {
        $group->get('[/]', [Controllers\PostController::class, 'getMany']);
        $group->get('/years[/]', [Controllers\PostController::class, 'getYears']);
        $group->get('/dates[/]', [Controllers\PostController::class, 'getDates']);
        $group->get('/{id}[/]', [Controllers\PostController::class, 'getOne']);
        $group->post('[/]', [Controllers\PostController::class, 'store'])
            ->add(new JWTMiddleware($container));
        $group->put('/{id}[/]', [Controllers\PostController::class, 'update'])
            ->add(new JWTMiddleware($container));
        $group->delete('/{id}[/]', [Controllers\PostController::class, 'destroy'])
            ->add(new JWTMiddleware($container));
    });

    $app->get('/cache/clear', [Controllers\CacheController::class, 'clear'])
        ->add(new JWTMiddleware($container));

    $app->group('/message', function (RouteCollectorProxy $group) use ($container) {
        $group->get('[/]', [Controllers\MessageController::class, 'getMany']);
        $group->get('/{id}[/]', [Controllers\MessageController::class, 'getOne']);
        $group->delete('/{id}[/]', [Controllers\MessageController::class, 'destroy']);
    })->add(new JWTMiddleware($container));

    $app->post('/contact', [Controllers\ContactController::class, 'contact'])
        ->add(new IpAddress());

    $app->get('/photos', [Controllers\PhotosController::class, 'photos']);

    $app->get('/proxy-picture', [Controllers\PhotosController::class, 'proxyInstagramImage']);

    $app->group('/image', function (RouteCollectorProxy $group) {
        $group->get('[/]', [Controllers\ImageController::class, 'getMany']);
        $group->get('/{id}[/]', [Controllers\ImageController::class, 'getOne']);
        $group->get('/{id}/display[/]', [Controllers\ImageController::class, 'display']);
        $group->put('/{id}[/]', [Controllers\ImageController::class, 'update']);
        $group->delete('/{id}[/]', [Controllers\ImageController::class, 'destroy']);
    })->add(new JWTMiddleware($container));

    //$app->group('/oauth', function () {
    //    $this->get('/twitter/authorize', [TwitterController::class]);
    //    $this->get('/facebook/authorize');
    //    $this->post('/facebook/execute');
    //    $this->post('/twitter/execute');
    //})->add(new \App\Middlewares\JWTMiddleware());

    $app->post('/image-upload', [Controllers\ImageUpload::class, 'upload'])
        ->add(new \App\Middlewares\CORSMiddleware($container))
        ->add(new JWTMiddleware($container));

    // $app->group('/google-photos', function (RouteCollectorProxy $group) {
    //     $group->get('/albums[/]', [Controllers\GoogleController::class, 'getAllAlbums']);
    //     //$this->get('/shared-albums[/]', [Controllers\GoogleController::class, 'getSharedAlbums']);
    //     $group->get('/album/{id}[/]', [Controllers\GoogleController::class, 'getAlbum']);
    // })->add(new \App\Middlewares\JWTMiddleware($container))->add(new \Slim\Middleware\Session());

     $app->group('/auth', function (RouteCollectorProxy $group) use ($container) {
         //$this->get('/login[/]', [Controllers\STAILEUController::class, 'getLogin']);

         $group->get('/info', [Controllers\DefaultController::class, 'getInfo'])
              ->add(new JWTMiddleware($container));

         // $this->post('/execute[/]', [Controllers\STAILEUController::class, 'execute'])
         //     ->add(new \RKA\Middleware\IpAddress());

         // $this->get('/google[/]', [Controllers\GoogleController::class, 'authorize'])
         //     ->add(new \App\Middlewares\JWTMiddleware($this->getContainer()));

         // $this->post('/google/execute[/]', [Controllers\GoogleController::class, 'execute'])
         //     ->add(new \App\Middlewares\JWTMiddleware($this->getContainer()));
     });

}
