<?php

declare(strict_types=1);

namespace App\Auth\Infrastructure\Modules;

use App\Auth\Infrastructure\Controller\LoginAction;
use App\Auth\Infrastructure\Controller\MeAction;
use App\Auth\Infrastructure\Middleware\Authenticate;
use App\Shared\Infrastructure\Modules\ModuleInterface;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;
use Slim\Interfaces\RouteCollectorProxyInterface;

final class Module implements ModuleInterface
{
    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function configure(RouteCollectorProxyInterface $route, ContainerInterface $container): void
    {
        $route->post('/login', LoginAction::class);
        $route->get('/me', MeAction::class)
            ->addMiddleware($container->get(Authenticate::class))
        ;
    }
}
