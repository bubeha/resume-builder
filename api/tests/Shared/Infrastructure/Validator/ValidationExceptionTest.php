<?php

declare(strict_types=1);

namespace Tests\Shared\Infrastructure\Validator;

use App\Shared\Infrastructure\Validator\ValidationException;
use PHPUnit\Framework\MockObject\Exception;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Validator\ConstraintViolationListInterface;

/**
 * @internal
 */
final class ValidationExceptionTest extends TestCase
{
    /**
     * @throws Exception
     */
    public function testException(): void
    {
        $constraintMock = $this->createMock(ConstraintViolationListInterface::class);

        self::assertSame(
            $constraintMock,
            (new ValidationException($constraintMock))->getViolations(),
        );
    }
}
