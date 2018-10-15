<?php
namespace App;

use DI\ContainerBuilder;

class App extends \DI\Bridge\Slim\App
{
    protected function configureContainer(ContainerBuilder $builder)
    {
        \App\ContainerBuilder::getContainerBuilder($builder);
    }
}
