<?php

declare(strict_types=1);

namespace Tests\App\Domain\ValueObjects;

use App\Domain\ValueObjects\Email;
use PHPUnit\Framework\TestCase;
use Webmozart\Assert\InvalidArgumentException;

/**
 * @internal
 */
final class EmailTest extends TestCase
{
    public function testCreate(): void
    {
        $value = 'test@email.com';

        self::assertEquals((string)Email::fromString($value), $value);
        self::assertEquals((string)new Email($value), $value);
    }

    public function testIncorrectEmail(): void
    {
        $this->expectException(InvalidArgumentException::class);

        Email::fromString('incorrect email');
    }
}
