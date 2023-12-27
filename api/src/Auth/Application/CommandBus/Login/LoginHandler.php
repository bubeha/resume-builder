<?php

declare(strict_types=1);

namespace App\Auth\Application\CommandBus\Login;

use App\Auth\Domain\Manager\JwtTokenManager;
use App\Auth\Domain\Repository\UserRepository;
use App\Shared\Application\CommandBus\CommandHandler;
use App\Shared\Domain\ValueObjects\Email;
use App\Shared\Infrastructure\Validator\Validator;
use LogicException;

final readonly class LoginHandler implements CommandHandler
{
    public function __construct(
        private UserRepository $userRepository,
        private Validator $validator,
        private JwtTokenManager $jwtTokenManager,
    ) {}

    public function handle(LoginCommand $command): string
    {
        $this->validator->validate($command);

        $email = Email::fromString($command->getEmail());
        $user = $this->userRepository->findByEmail($email);

        if (!$user || !$user->getPasswordHash()->match($command->getPassword())) {
            throw new LogicException('incorrect data');
        }

        return $this->jwtTokenManager->create($user);
    }
}
