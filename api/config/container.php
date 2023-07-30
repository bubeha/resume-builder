<?php

declare(strict_types=1);

use DI\ContainerBuilder;

$builder = new ContainerBuilder();

if (getenv('APP_ENV') === 'prod') {
    $builder->enableDefinitionCache(__DIR__ . '/../var/cache');
}

return $builder->build();
