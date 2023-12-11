<?php

declare(strict_types=1);

use App\Auth\Domain\Authenticator;
use App\Auth\Domain\Manager\JwtTokenManager as JwtTokenManagerInterface;
use App\Auth\Domain\Repository\UserRepository;
use App\Auth\Infrastructure\JwtAuthenticator;
use App\Auth\Infrastructure\Manager\Algorithm;
use App\Auth\Infrastructure\Manager\JwtTokenManager;
use App\Auth\Infrastructure\Middleware\Authenticate;
use App\Shared\Domain\Entities\AuthenticatedUser;
use Firebase\JWT\Key;
use League\Flysystem\FilesystemReader;
use Psr\Container\ContainerInterface;

return [
    JwtTokenManagerInterface::class => static function (ContainerInterface $container): JwtTokenManagerInterface {
        ['privateKey' => $key, 'algorithm' => $algorithm] = $container->get('config')['auth'];

        /** @var FilesystemReader $fileReader */
        $fileReader = $container->get(FilesystemReader::class);

        return new JwtTokenManager(
            $fileReader->read($key),
            $algorithm,
            // todo move it to config
            'localhost:8080',
        );
    },
    Authenticator::class => static function (ContainerInterface $container): Authenticator {
        ['publicKey' => $key, 'algorithm' => $algorithm] = $container->get('config')['auth'];

        /** @var FilesystemReader $fileReader */
        $fileReader = $container->get(FilesystemReader::class);

        return new JwtAuthenticator(
            new Key(
                $fileReader->read($key),
                $algorithm,
            ),
            $container->get(UserRepository::class),
        );
    },
    AuthenticatedUser::class => static function (ContainerInterface $container) {
        /** @var Authenticator $authenticator */
        $authenticator = $container->get(Authenticator::class);

        return $authenticator->user();
    },
    Authenticate::class => static fn (ContainerInterface $container) => new Authenticate($container->get(Authenticator::class)),
    'config' => [
        'auth' => [
            'privateKey' => __DIR__ . '/../../var/jwt/private.pem',
            'publicKey' => __DIR__ . '/../../var/jwt/public.pem',
            'algorithm' => Algorithm::RS256,
        ],
    ],
];
