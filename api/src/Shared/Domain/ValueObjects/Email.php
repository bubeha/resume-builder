<?php

declare(strict_types=1);

namespace App\Shared\Domain\ValueObjects;

use Webmozart\Assert\Assert;

final readonly class Email
{
    public function __construct(
        private string $value,
    ) {
        Assert::email($this->value);
    }

    public static function fromString(string $value): self
    {
        return new self($value);
    }

    public function __toString(): string
    {
        return $this->value;
    }
}
