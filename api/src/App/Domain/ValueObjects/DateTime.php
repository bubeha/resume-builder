<?php

declare(strict_types=1);

namespace App\Domain\ValueObjects;

use App\Domain\Exceptions\DateTimeException;
use DateTimeImmutable;
use Throwable;

/**
 * @psalm-seal-methods
 */
final class DateTime extends DateTimeImmutable
{
    public const FORMAT = 'Y-m-d H:i:s';

    /**
     * @throws \App\Domain\Exceptions\DateTimeException
     */
    public static function now(): self
    {
        return self::create();
    }

    /**
     * @throws \App\Domain\Exceptions\DateTimeException
     */
    public static function create(string $value = 'now'): self
    {
        try {
            return new self($value);
        } catch (Throwable $e) {
            throw new DateTimeException($e);
        }
    }

    public function __toString(): string
    {
        return $this->format(self::FORMAT);
    }
}
