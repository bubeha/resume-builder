<?php

declare(strict_types=1);

use App\Auth\Domain\Manager\JwtTokenManager as JwtTokenManagerInterface;
use App\Auth\Infrastructure\Manager\JwtTokenManager;
use League\Flysystem\FilesystemReader;
use Psr\Container\ContainerInterface;

return [
    JwtTokenManagerInterface::class => static fn (ContainerInterface $container) => new JwtTokenManager($container->get(FilesystemReader::class)),
    'config' => [
        'auth' => [
            'keyDir' => __DIR__ . '/../../var/jwt',
        ],
    ],
];
