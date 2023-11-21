<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Modules;

use App\Shared\Infrastructure\Controller\HealthCheckAction;
use App\Shared\Infrastructure\Controller\HomeAction;
use Slim\Interfaces\RouteCollectorProxyInterface;

final readonly class Module implements ModuleInterface
{
    public function configure(RouteCollectorProxyInterface $route): void
    {
        $route->get('/', HomeAction::class);
        $route->get('/health', HealthCheckAction::class);
    }
}
