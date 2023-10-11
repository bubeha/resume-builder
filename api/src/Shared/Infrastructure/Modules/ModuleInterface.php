<?php

namespace App\Shared\Infrastructure\Modules;

use Slim\Interfaces\RouteCollectorProxyInterface;

interface ModuleInterface
{
    public function configure(RouteCollectorProxyInterface $route): void;
}