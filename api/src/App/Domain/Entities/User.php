<?php

declare(strict_types=1);

namespace App\Domain\Entities;

use App\Domain\ValueObjects\DateTime;
use App\Domain\ValueObjects\Email;
use App\Domain\ValueObjects\Uuid;
use App\Infrastructure\Persistence\Doctrine\Generator\UuidGenerator;
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
        private readonly Uuid $id,
        #[Column(type: 'email', unique: true)]
        private Email $email,
        #[Column(type: 'datetime')]
        private readonly DateTime $registeredAt = new DateTime(
        ),
    ) {
    }

    public function setEmail(Email $email): void
    {
        $this->email = $email;
    }

    public function getId(): Uuid
    {
        return $this->id;
    }

    public function getEmail(): Email
    {
        return $this->email;
    }

    public function getRegisteredAt(): DateTime
    {
        return $this->registeredAt;
    }
}
