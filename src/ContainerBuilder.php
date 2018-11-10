<?php

namespace App;

use Psr\Container\ContainerInterface;

class ContainerBuilder
{
    public static function getContainerBuilder(\DI\ContainerBuilder $containerBuilder = null): \DI\ContainerBuilder
    {
        if ($containerBuilder == null){
            $containerBuilder = new \DI\ContainerBuilder();
        }
        $containerBuilder->addDefinitions(__DIR__ . '/config/config.php');
        $containerBuilder->addDefinitions(__DIR__ . '/config/database.php');
        $containerBuilder->addDefinitions(__DIR__ . '/config/auth.php');
        $containerBuilder->addDefinitions(__DIR__ . '/config/containers.php');
        $containerBuilder->addDefinitions([
            'root_path' => dirname(__DIR__)
        ]);

        return $containerBuilder;
    }

    public static function getContainerFromBuilder(\DI\ContainerBuilder $containerBuilder): ContainerInterface
    {
        try {
            return $containerBuilder->build();
        } catch (\Exception $e) {
            return NULL;
        }
    }

    public static function direct(): ContainerInterface
    {
        return self::getContainerFromBuilder(self::getContainerBuilder());
    }
}
