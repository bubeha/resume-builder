<?php

declare(strict_types=1);

namespace Tests\App\Domain\ValueObjects;

use App\Domain\ValueObjects\Email;
use App\Domain\ValueObjects\Uuid;
use PHPUnit\Framework\TestCase;
use Webmozart\Assert\InvalidArgumentException;

/**
 * @internal
 */
final class UuidTest extends TestCase
{
    public function testCreate(): void
    {
        $value = 'e0ea2b4f-9524-4dc8-8860-f9f484ab4392';

        self::assertEquals((string)Uuid::fromString($value), $value);
        self::assertEquals((string)new Uuid($value), $value);

        if (!\Ramsey\Uuid\Uuid::isValid(Uuid::generate())) {
            self::fail('UUid is invalid');
        }
    }

    public function testIncorrectUuid(): void
    {
        $this->expectException(InvalidArgumentException::class);

        Email::fromString('incorrect uuid');
    }
}
