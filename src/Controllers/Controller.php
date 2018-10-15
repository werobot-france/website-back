<?php

namespace App\Controllers;

use Illuminate\Database\Capsule\Manager;
use Psr\Container\ContainerInterface;

class Controller {
    /**
     * @var ContainerInterface
     */
    protected $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function loadDatabase()
    {
        $this->container->get(ContainerInterface::class)->get(Manager::class);
    }
}