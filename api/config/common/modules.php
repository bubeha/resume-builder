<?php

use App\Shared\Infrastructure\Modules\Module as SharedModule;
use App\Shared\Infrastructure\Modules\ModuleInterface;
use Psr\Container\ContainerInterface;

return [
    ModuleInterface::class => static function (ContainerInterface $container) {
        return [
            new SharedModule(),
        ];
    },
];