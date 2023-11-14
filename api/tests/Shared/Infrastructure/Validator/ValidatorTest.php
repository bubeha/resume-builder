<?php

declare(strict_types=1);

namespace Tests\Shared\Infrastructure\Validator;

use App\Shared\Infrastructure\Validator\ValidationException;
use App\Shared\Infrastructure\Validator\Validator;
use PHPUnit\Framework\MockObject\Exception;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

final class ValidatorTest extends TestCase
{
    /**
     * @throws Exception
     */
    public function testValidationFail(): void
    {
        $this->expectException(ValidationException::class);

        $constraintMock = $this->createMock(ConstraintViolationListInterface::class);

        $constraintMock->method('count')
            ->willReturn(2);

        $validatorMock = $this->createMock(ValidatorInterface::class);

        $validatorMock->method('validate')
            ->willReturn($constraintMock);

        (new Validator($validatorMock))->validate(new \stdClass());
    }
}