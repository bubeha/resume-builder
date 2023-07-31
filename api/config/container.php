<?php

declare(strict_types=1);

use DI\ContainerBuilder;

$builder = new ContainerBuilder();

if (getenv('APP_ENV') === 'prod') {
    $builder->enableDefinitionCache(__DIR__ . '/../var/cache');
}

$builder->addDefinitions(require __DIR__ . '/dependencies.php');

return $builder->build();
