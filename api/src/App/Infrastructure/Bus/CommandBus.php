<?php

declare(strict_types=1);

namespace App\Infrastructure\Bus;

use App\Application\CommandBus\CommandBus as CommandBusInterface;
use InvalidArgumentException;
use Psr\Container\ContainerInterface;

final readonly class CommandBus implements CommandBusInterface
{
    public function __construct(
        private ContainerInterface $container,
    ) {
    }

    /**
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function handle(object $command): void
    {
        $handler = $this->container->get($command::class);

        if (\is_callable($handler)) {
            $handler($command);

            return;
        }

        throw new InvalidArgumentException('Incorrect Handler for the command: ' . $command::class);
    }
}
