<?php

declare(strict_types=1);

namespace App\Domain\ValueObjects;

use Ramsey\Uuid\Rfc4122\UuidV4;
use Webmozart\Assert\Assert;

final readonly class Uuid
{
    public function __construct(
        private string $value,
    ) {
        Assert::uuid($this->value);
    }

    public static function generate(): self
    {
        return new self(UuidV4::uuid4()->toString());
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
