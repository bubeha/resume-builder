<?php

declare(strict_types=1);

use Rector\Config\RectorConfig;
use Rector\Php80\Rector\Class_\StringableForToStringRector;
use Rector\Set\ValueObject\LevelSetList;
use Rector\Set\ValueObject\SetList;

return static function (RectorConfig $config): void {
    $config->parallel();
    $config->paths([
        __DIR__ . '/config',
        __DIR__ . '/public',
        __DIR__ . '/src',
    ]);

    $config->cacheDirectory(__DIR__ . '/var/cache/rector');

    $config->sets([
        LevelSetList::UP_TO_PHP_82,
        SetList::DEAD_CODE,
    ]);

    $config->skip([
        StringableForToStringRector::class,
    ]);
};
