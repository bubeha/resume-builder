<?php

declare(strict_types=1);

use App\Auth\Infrastructure\Console\CreateUserCommand;
use App\Auth\Infrastructure\Console\GenerateKeyPairCommand;
use Doctrine\Migrations\Tools\Console\Command\DiffCommand;
use Doctrine\Migrations\Tools\Console\Command\ExecuteCommand;
use Doctrine\Migrations\Tools\Console\Command\LatestCommand;
use Doctrine\Migrations\Tools\Console\Command\MigrateCommand;
use Doctrine\Migrations\Tools\Console\Command\StatusCommand;
use Doctrine\Migrations\Tools\Console\Command\UpToDateCommand;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Tools\Console\Command\ValidateSchemaCommand;
use Doctrine\ORM\Tools\Console\EntityManagerProvider;
use Doctrine\ORM\Tools\Console\EntityManagerProvider\SingleManagerProvider;
use League\Flysystem\Filesystem;
use League\Flysystem\Local\LocalFilesystemAdapter;
use Psr\Container\ContainerInterface;
use Symfony\Component\Console\Command\ListCommand;

return [
    EntityManagerProvider::class => static fn (ContainerInterface $container): EntityManagerProvider => new SingleManagerProvider($container->get(EntityManagerInterface::class)),
    ValidateSchemaCommand::class => static fn (ContainerInterface $container): ValidateSchemaCommand => new ValidateSchemaCommand($container->get(EntityManagerProvider::class)),
    GenerateKeyPairCommand::class => static function (ContainerInterface $container): GenerateKeyPairCommand {
        $location = $container->get('config')['auth']['keyDir'];

        $adapter = new LocalFilesystemAdapter($location);

        return new GenerateKeyPairCommand(
            new Filesystem($adapter),
        );
    },

    'config' => [
        'console' => [
            'commands' => [
                // Doctrine
                ValidateSchemaCommand::class,
                // Migrations
                ExecuteCommand::class,
                MigrateCommand::class,
                LatestCommand::class,
                ListCommand::class,
                StatusCommand::class,
                UpToDateCommand::class,
                DiffCommand::class,
                // Auth Module
                CreateUserCommand::class,
                GenerateKeyPairCommand::class,
            ],
        ],
    ],
];
