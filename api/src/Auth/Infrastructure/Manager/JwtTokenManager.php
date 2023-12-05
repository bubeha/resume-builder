<?php

declare(strict_types=1);

namespace App\Auth\Infrastructure\Manager;

use App\Auth\Domain\Manager\JwtTokenManager as JwtTokenManagerInterface;
use App\Shared\Domain\Entities\UserInterface;
use DateInterval;
use Firebase\JWT\JWT;
use League\Flysystem\FilesystemReader;

final readonly class JwtTokenManager implements JwtTokenManagerInterface
{
    public function __construct(
        private FilesystemReader $filesystemReader,
    ) {}

    public function create(UserInterface $user): string
    {
        $token = [
            'iss' => 'utopian',
            'iat' => new \DateTimeImmutable('now'),
            'exp' => new DateInterval('PT1H'),
            'data' => [
                'user_id' => (string)$user->getIdentifier(),
            ],
        ];

        return JWT::encode($token, $this->filesystemReader->read('/var/jwt/private.pem'), 'HS256');
    }
}
