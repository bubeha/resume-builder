<?php

declare(strict_types=1);

namespace App\Auth\Infrastructure\Modules;

use App\Auth\Infrastructure\Controller\LoginAction;
use App\Shared\Infrastructure\Modules\ModuleInterface;
use Slim\Interfaces\RouteCollectorProxyInterface;

final class Module implements ModuleInterface
{
    public function configure(RouteCollectorProxyInterface $route): void
    {
        $route->post('/login', LoginAction::class);
    }
}
