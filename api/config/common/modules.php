<?php

use App\Shared\Infrastructure\Modules\Module as SharedModule;
use App\Auth\Infrastructure\Modules\Module as AuthModule;
use App\Shared\Infrastructure\Modules\ModuleInterface;
use Psr\Container\ContainerInterface;

return [
    ModuleInterface::class => static fn(ContainerInterface $container) => [
        new SharedModule(),
        new AuthModule(),
    ],
];