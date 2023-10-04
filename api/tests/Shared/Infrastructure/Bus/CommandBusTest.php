<?php

declare(strict_types=1);

namespace Tests\Shared\Infrastructure\Bus;

use App\Shared\Infrastructure\Bus\CommandBus;
use Exception;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;
use stdClass;

/**
 * @internal
 */
final class CommandBusTest extends TestCase
{
    /**
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \PHPUnit\Framework\MockObject\Exception
     */
    public function testCannotFindCommandHandler(): void
    {
        $this->expectException(NotFoundExceptionInterface::class);

        $container = $this->createMock(ContainerInterface::class);

        $container
            ->expects(self::once())
            ->method('get')
            ->willThrowException(new class() extends Exception implements NotFoundExceptionInterface {
            })
        ;

        (new CommandBus($container))->handle(new class() {
            // todo nothing
        });
    }

    /**
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     * @throws \PHPUnit\Framework\MockObject\Exception
     */
    public function testCommandExecutedSuccessfully(): void
    {
        $container = $this->createMock(ContainerInterface::class);

        $a = null;

        $container
            ->method('get')
            ->willReturn(static function () use (&$a): void {
                $a = 'Entered';
            })
        ;

        (new CommandBus($container))->handle(new stdClass());
        self::assertSame($a, 'Entered');
    }

    /**
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     * @throws \PHPUnit\Framework\MockObject\Exception
     */
    public function testExpectedIncorrectHandler(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $container = $this->createMock(ContainerInterface::class);

        $container
            ->method('get')
            ->willReturn(new stdClass())
        ;

        (new CommandBus($container))->handle(new stdClass());
    }
}
