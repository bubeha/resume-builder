<?php

declare(strict_types=1);

namespace App\Auth\Application\CommandBus;

use App\Shared\Application\CommandBus\Command;
use App\Shared\Domain\ValueObjects\HashedPassword;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

final readonly class SignUpCommand implements Command
{
    public function __construct(
        #[NotBlank]
        #[Email]
        private string $email,
        #[NotBlank]
        #[Length(min: HashedPassword::PASSWORD_MIN_LENGTH)]
        private string $password,
    )
    {
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }
}