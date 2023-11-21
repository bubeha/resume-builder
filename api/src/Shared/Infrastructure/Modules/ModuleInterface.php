<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Modules;

use Slim\Interfaces\RouteCollectorProxyInterface;

interface ModuleInterface
{
    public function configure(RouteCollectorProxyInterface $route): void;
}
