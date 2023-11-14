<?php

declare(strict_types=1);

namespace App\Auth\Application\CommandBus;

use App\Auth\Domain\Repository\UserRepository;
use App\Shared\Application\CommandBus\Command;
use App\Shared\Application\CommandBus\CommandHandler;
use App\Shared\Domain\Entities\User;
use App\Shared\Domain\ValueObjects\Email;
use App\Shared\Domain\ValueObjects\HashedPassword;
use App\Shared\Infrastructure\Validator\Validator;

final readonly class SignUpHandler implements CommandHandler
{
    public function __construct(private UserRepository $userRepository, private Validator $validator)
    {
    }

    public function handle(SignUpCommand|Command $command): void
    {
        /** @var SignUpCommand $command */
        $this->validator->validate($command);

        $email = Email::fromString($command->getEmail());
        $hashedPassword = HashedPassword::encode($command->getPassword());

        $this->userRepository->store(
            User::make($email, $hashedPassword)
        );
    }
}