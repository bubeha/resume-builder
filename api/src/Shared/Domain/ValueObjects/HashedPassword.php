<?php

declare(strict_types=1);

namespace App\Shared\Domain\ValueObjects;

use RuntimeException;
use Webmozart\Assert\Assert;

final readonly class HashedPassword
{
    public const COST = 12;
    public const PASSWORD_MIN_LENGTH = 6;

    public function __construct(
        private string $hashedPassword,
    ) {}

    public static function encode(string $plainPassword): self
    {
        return new self(self::hash($plainPassword));
    }

    public static function fromHash(string $hashedPassword): self
    {
        return new self($hashedPassword);
    }

    private static function hash(string $plainPassword): string
    {
        Assert::minLength($plainPassword, self::PASSWORD_MIN_LENGTH, 'Min ' . self::PASSWORD_MIN_LENGTH . ' characters password');

        $hashedPassword = \password_hash($plainPassword, PASSWORD_BCRYPT, ['cost' => self::COST]);

        if (!$hashedPassword) {
            throw new RuntimeException('Server error hashing password');
        }

        return $hashedPassword;
    }

    public function match(string $plainPassword): bool
    {
        return \password_verify($plainPassword, $this->hashedPassword);
    }

    public function __toString(): string
    {
        return $this->hashedPassword;
    }
}
