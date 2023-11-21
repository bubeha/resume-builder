<?php

declare(strict_types=1);

namespace App\Auth\Application\CommandBus\Login;

use App\Auth\Domain\Repository\UserRepository;
use App\Shared\Application\CommandBus\CommandHandler;
use App\Shared\Domain\ValueObjects\Email;
use App\Shared\Infrastructure\Validator\Validator;
use Firebase\JWT\JWT;
use LogicException;

final readonly class LoginHandler implements CommandHandler
{
    public function __construct(
        private UserRepository $userRepository,
        private Validator $validator,
    ) {}

    public function handle(LoginCommand $command): string
    {
        $this->validator->validate($command);

        $email = Email::fromString($command->getEmail());
        $user = $this->userRepository->findByEmail($email);

        if (!$user || !$user->getPasswordHash()->match($command->getPassword())) {
            throw new LogicException('incorrect data');
        }

        $token = [
            'iss' => 'utopian',
            'iat' => \time(),
            'exp' => \time() + 60,
            'data' => [
                'user_id' => (string)$user->getId(),
            ],
        ];

        return JWT::encode($token, 'secret-key', 'HS256');
    }
}
