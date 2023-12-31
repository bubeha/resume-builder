<?php

declare(strict_types=1);

use App\Auth\Domain\Repository\UserRepository as UserRepositoryInterface;
use App\Auth\Infrastructure\Repository\UserStore;
use App\Shared\Infrastructure\Persistence\Doctrine\Types\DateTimeType;
use App\Shared\Infrastructure\Persistence\Doctrine\Types\EmailType;
use App\Shared\Infrastructure\Persistence\Doctrine\Types\HashedPasswordType;
use App\Shared\Infrastructure\Persistence\Doctrine\Types\UuidType;
use Doctrine\DBAL\DriverManager;
use Doctrine\DBAL\Types\Type;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping\UnderscoreNamingStrategy;
use Doctrine\ORM\ORMSetup;
use Psr\Container\ContainerInterface;
use Symfony\Component\Cache\Adapter\ArrayAdapter;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;

return [
    EntityManagerInterface::class => static function (ContainerInterface $container) {
        /**
         * @var array{
         *     metadataDirs: string[],
         *     devMode: bool,
         *     proxyDir: string,
         *     cacheDir: string,
         *     types: array<string, class-string<Type>>,
         *     connection:array{
         *         port: int,
         *         dbname: string,
         *         user: string,
         *         password: string,
         *         charset: string,
         *     },
         * } $settings
         */
        $settings = $container->get('config')['doctrine'];

        $config = ORMSetup::createAttributeMetadataConfiguration(
            $settings['metadataDirs'],
            $settings['devMode'],
            $settings['proxyDir'],
            $settings['cacheDir'] ? new FilesystemAdapter('', 0, $settings['cacheDir']) : new ArrayAdapter(),
        );

        $config->setNamingStrategy(new UnderscoreNamingStrategy());

        $connection = DriverManager::getConnection($settings['connection'], $config);

        foreach ($settings['types'] as $name => $class) {
            if (!Type::hasType($name)) {
                Type::addType($name, $class);
            } else {
                Type::overrideType($name, $class);
            }
        }

        return new EntityManager($connection, $config);
    },
    UserRepositoryInterface::class => static fn (ContainerInterface $container) => new UserStore($container->get(EntityManagerInterface::class)),
    'config' => [
        'doctrine' => [
            'devMode' => getenv('app_env') === 'prod',

            'cacheDir' => __DIR__ . '/../../var/doctrine/cache',
            'proxyDir' => __DIR__ . '/../../var/cache/doctrine/proxy',

            'metadataDirs' => [
                __DIR__ . '/../../src/Shared/Domain/Entities',
            ],

            'connection' => [
                'driver' => 'pdo_pgsql',
                'host' => getenv('DB_HOST'),
                'port' => getenv('DB_PORT'),
                'dbname' => getenv('DB_NAME'),
                'user' => getenv('DB_USER'),
                'password' => getenv('DB_PASSWORD'),
                'charset' => 'utf-8',
            ],

            'types' => [
                UuidType::NAME => UuidType::class,
                EmailType::NAME => EmailType::class,
                DateTimeType::NAME => DateTimeType::class,
                HashedPasswordType::NAME => HashedPasswordType::class,
            ],
        ],
    ],
];
