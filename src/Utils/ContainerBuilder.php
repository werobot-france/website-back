<?php
/** @noinspection PhpUnhandledExceptionInspection */

namespace App\Utils;

use App\App;
use Exception;
use Psr\Container\ContainerInterface;

class ContainerBuilder
{
    private static array $definitions = [
        'config',
        'database',
        'auth',
        'containers',
    ];

    public static function getContainerBuilder(\DI\ContainerBuilder $containerBuilder = null): \DI\ContainerBuilder
    {
        if ($containerBuilder == null){
            $containerBuilder = new \DI\ContainerBuilder();
        }
        foreach (self::$definitions as $def) {
            $containerBuilder->addDefinitions(App::getBasePath() . "/src/config/{$def}.php");
        }

        return $containerBuilder;
    }

    public static function getContainerFromBuilder(\DI\ContainerBuilder $containerBuilder): ContainerInterface
    {
        return $containerBuilder->build();
    }

    public static function direct(): ContainerInterface
    {
        return self::getContainerFromBuilder(self::getContainerBuilder());
    }
}
