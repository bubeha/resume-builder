<?php

declare(strict_types=1);

namespace App\Domain\Entities;

use App\Domain\ValueObjects\DateTime;
use App\Domain\ValueObjects\Email;
use App\Domain\ValueObjects\Uuid;

final class User
{
    public function __construct(
        private readonly Uuid $id,
        private Email $email,
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
