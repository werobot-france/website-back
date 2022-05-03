<?php

namespace App\Controllers;

use App\Auth\Session;
use Illuminate\Database\Capsule\Manager;
use Lefuturiste\LocalStorage\LocalStorage;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;


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

    public function session(): Session
    {
        return $this->container->get(Session::class);
    }

    public function localStorage(): LocalStorage
    {
        return $this->container->get(LocalStorage::class);
    }

}
