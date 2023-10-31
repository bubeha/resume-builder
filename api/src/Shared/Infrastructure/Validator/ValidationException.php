<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Validator;

use LogicException;
use Symfony\Component\Validator\ConstraintViolationListInterface;

final class ValidationException extends LogicException
{
    public function __construct(
        private readonly ConstraintViolationListInterface $violations,
        string $message = 'Invalid input.',
        int $code = 0,
        \Throwable $previous = null
    ) {
        parent::__construct($message, $code, $previous);
    }

    public function getViolations(): ConstraintViolationListInterface
    {
        return $this->violations;
    }
}