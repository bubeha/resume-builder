<?php

declare(strict_types=1);

namespace App\Shared\Domain\Entities;

use App\Shared\Domain\Exceptions\DateTimeException;
use App\Shared\Domain\ValueObjects\DateTime;
use App\Shared\Domain\ValueObjects\Email;
use App\Shared\Domain\ValueObjects\HashedPassword;
use App\Shared\Domain\ValueObjects\Uuid;
use App\Shared\Infrastructure\Persistence\Doctrine\Generator\UuidGenerator;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\CustomIdGenerator;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\Table;

#[Entity, Table(name: 'users')]
final class User
{
    public function __construct(
        #[Id, Column(type: 'uuid', unique: true), GeneratedValue(strategy: 'CUSTOM'), CustomIdGenerator(class: UuidGenerator::class)]
        private Uuid $id,
        #[Column(type: 'email', unique: true)]
        private Email $email,
        #[Column(type: 'hashed_password')]
        private HashedPassword $passwordHash,
        #[Column(type: 'datetime_immutable')]
        private DateTime $registeredAt = new DateTime(),
    )
    {
    }

    /**
     * @throws DateTimeException
     */
    public static function make(Email $email, HashedPassword $hashedPassword, DateTime $dateTime = null): self
    {
        return new self(
            Uuid::generate(),
            $email,
            $hashedPassword,
            $dateTime ?? DateTime::now(),
        );
    }

    public function getId(): Uuid
    {
        return $this->id;
    }

    public function getEmail(): Email
    {
        return $this->email;
    }

    public function setEmail(Email $email): void
    {
        $this->email = $email;
    }

    public function getPasswordHash(): HashedPassword
    {
        return $this->passwordHash;
    }

    public function changePassword(string $password): void
    {
        $this->passwordHash = HashedPassword::encode($password);
    }

    public function getRegisteredAt(): DateTime
    {
        return $this->registeredAt;
    }
}
