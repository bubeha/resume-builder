<?php

declare(strict_types=1);

namespace Tests\Shared\Domain\Entities;

use App\Shared\Domain\Entities\User;
use App\Shared\Domain\ValueObjects\HashedPassword;
use PHPUnit\Framework\TestCase;
use App\Shared\Domain\ValueObjects\DateTime;
use App\Shared\Domain\ValueObjects\Email;
use App\Shared\Domain\ValueObjects\Uuid;

/**
 * @internal
 */
final class UserTest extends TestCase
{
    /**
     * @throws \App\Shared\Domain\Exceptions\DateTimeException
     */
    public function testCreate(): void
    {
        $uuid = Uuid::generate();
        $email = Email::fromString('test@email.com');
        $dateTime = DateTime::now();
        $passwordHash = HashedPassword::encode('12345678');

        $user = new User($uuid, $email, $passwordHash, $dateTime);

        self::assertEquals($uuid, $user->getId());
        self::assertEquals($email, $user->getEmail());
        self::assertEquals($dateTime, $user->getRegisteredAt());
        self::assertEquals($passwordHash, $user->getPasswordHash());
    }

    public function testCreateWithoutRegisteredAt(): void
    {
        $uuid = Uuid::generate();
        $email = Email::fromString('test@email.com');
        $passwordHash = HashedPassword::encode('12345678');

        $user = new User($uuid, $email, $passwordHash);

        self::assertEquals(
            (new DateTime('now'))->format('d/m/y'),
            $user->getRegisteredAt()->format('d/m/y'),
        );
    }

    public function testUpdate(): void
    {
        $uuid = Uuid::generate();
        $email = Email::fromString('test@email.com');
        $dateTime = DateTime::now();
        $passwordHash = HashedPassword::encode('12345678');

        $user = new User($uuid, $email, $passwordHash, $dateTime);

        $anotherEmail = Email::fromString('another@email.com');
        $user->setEmail($anotherEmail);

        self::assertEquals($anotherEmail, $user->getEmail());
    }
}
