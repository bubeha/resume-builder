<?php

declare(strict_types=1);

use App\Auth\Application\CommandBus\SignUp\SignUpHandler;
use App\Auth\Domain\Repository\UserRepository;
use App\Shared\Application\CommandBus\CommandBus as CommandBusInterface;
use App\Shared\Infrastructure\Bus\CommandBus;
use App\Shared\Infrastructure\Validator\Validator;
use Psr\Container\ContainerInterface;

return [
    CommandBusInterface::class => static fn (ContainerInterface $container) => new CommandBus($container),
    SignUpHandler::class => static function (ContainerInterface $container) {
        $repository = $container->get(UserRepository::class);
        $validator = $container->get(Validator::class);

        return new SignUpHandler($repository, $validator);
    },
];
