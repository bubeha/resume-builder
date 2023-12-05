<?php

declare(strict_types=1);

use League\Flysystem\Filesystem;
use League\Flysystem\FilesystemReader;
use League\Flysystem\Local\LocalFilesystemAdapter;

return [
    FilesystemReader::class => static function () {
        $adapter = new LocalFilesystemAdapter(__DIR__ . '/../..');

        return new Filesystem($adapter);
    },
];
