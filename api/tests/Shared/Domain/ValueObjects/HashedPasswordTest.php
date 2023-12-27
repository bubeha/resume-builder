<?php

declare(strict_types=1);

namespace Tests\Shared\Domain\ValueObjects;

use App\Shared\Domain\ValueObjects\HashedPassword;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 */
final class HashedPasswordTest extends TestCase
{
    public function testCreate(): void
    {
        $somePassword = '12345678';

        self::assertInstanceOf(HashedPassword::class, HashedPassword::encode($somePassword));
    }

    public function testCreateFromHash(): void
    {
        $someHash = '12345678';

        self::assertInstanceOf(HashedPassword::class, HashedPassword::fromHash($someHash));
    }

    public function testMatchShouldReturnFalseWithDifferentPasswords(): void
    {
        self::assertFalse(HashedPassword::encode('123456768')->match((string)HashedPassword::encode('another')));
    }

    public function testMatchShouldReturnTrueWithSamePasswords(): void
    {
        self::assertFalse(HashedPassword::encode('123456768')->match((string)HashedPassword::encode('123456768')));
    }
}
