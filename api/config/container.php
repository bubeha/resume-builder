<?php

declare(strict_types=1);


use DI\ContainerBuilder;

$builder = new ContainerBuilder();

if ('prod' === getenv('APP_ENV')) {
$builder->enableDefinitionCache(__DIR__ . '/../var/cache');
}

return $builder->build();
