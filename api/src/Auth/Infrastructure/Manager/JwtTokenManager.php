<?php

declare(strict_types=1);

namespace App\Auth\Infrastructure\Manager;

use App\Auth\Domain\Manager\JwtTokenManager as JwtTokenManagerInterface;
use App\Shared\Domain\Entities\UserInterface;
use Firebase\JWT\JWT;

final class JwtTokenManager implements JwtTokenManagerInterface
{
    public function __construct()
    {
    }

    public function create(UserInterface $user): string
    {
        $token = [
            'iss' => 'utopian',
            'iat' => new \DateTime('now'),
            'exp' => new \DateInterval('PT1H'),
            'data' => [
                'user_id' => (string)$user->getIdentifier(),
            ],
        ];

        return JWT::encode($token, 'secret-key', 'HS256');
    }
}