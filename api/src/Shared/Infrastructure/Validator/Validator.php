<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Validator;

use Symfony\Component\Validator\Validator\ValidatorInterface;

final readonly class Validator
{
    public function __construct(
        private ValidatorInterface $validator,
    ) {}

    public function validate(mixed $value): void
    {
        $violations = $this->validator->validate($value);

        if ($violations->count() > 0) {
            throw new ValidationException($violations);
        }
    }
}
