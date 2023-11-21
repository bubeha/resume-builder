<?php

declare(strict_types=1);

namespace App\Shared\Domain\ValueObjects;

use App\Shared\Domain\Exceptions\DateTimeException;
use DateTimeImmutable;
use Throwable;

/**
 * @psalm-seal-methods
 */
final class DateTime extends DateTimeImmutable
{
    public const FORMAT = 'Y-m-d H:i:s';

    /**
     * @throws DateTimeException
     */
    public static function now(): self
    {
        return self::create();
    }

    /**
     * @throws DateTimeException
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
