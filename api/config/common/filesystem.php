<?php

declare(strict_types=1);

use League\Flysystem\Filesystem;
use League\Flysystem\FilesystemAdapter;
use League\Flysystem\FilesystemReader;
use League\Flysystem\Local\LocalFilesystemAdapter;
use Psr\Container\ContainerInterface;

return [
    FilesystemAdapter::class => static fn () => new LocalFilesystemAdapter('/'),
    FilesystemReader::class => static fn (ContainerInterface $container) => new Filesystem($container->get(FilesystemAdapter::class)),
];
