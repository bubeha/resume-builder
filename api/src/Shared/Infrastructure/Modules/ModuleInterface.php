<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Modules;

use Psr\Container\ContainerInterface;
use Slim\Interfaces\RouteCollectorProxyInterface;

interface ModuleInterface
{
    public function configure(RouteCollectorProxyInterface $route, ContainerInterface $container): void;
}
