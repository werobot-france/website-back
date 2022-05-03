<?php

use App\App;
use App\Utils\ContainerBuilder;
use App\Utils\DotEnv;
use Slim\Factory\AppFactory;
use function App\addRoutes;

require '../vendor/autoload.php';

error_reporting(E_ALL);
ini_set('display_errors', 1);

require '../src/bootstrap/functions.php';

App::setBasePath(dirname(__DIR__));

DotEnv::load();

date_default_timezone_set('Europe/Paris');

$container = ContainerBuilder::direct();
$app = AppFactory::create(container: $container);

$app->addRoutingMiddleware();
$errorMiddleware = $app->addErrorMiddleware(true, true, true);

require '../src/routes.php';

addRoutes($app);

//WhoopsGuard::load($app, $app->getContainer());
$app->run();
