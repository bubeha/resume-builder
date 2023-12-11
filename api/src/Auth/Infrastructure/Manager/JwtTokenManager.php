<?php

declare(strict_types=1);

namespace App\Auth\Infrastructure\Manager;

use App\Auth\Domain\Manager\JwtTokenManager as JwtTokenManagerInterface;
use App\Shared\Domain\Entities\AuthenticatedUser;
use DateInterval;
use DateTimeImmutable;
use Firebase\JWT\JWT;

final readonly class JwtTokenManager implements JwtTokenManagerInterface
{
    public function __construct(
        private string $privateKey,
        private string $algorithm,
        private string $issuer,
    ) {}

    public function create(AuthenticatedUser $user): string
    {
        $token = [
            'iss' => $this->issuer,
            'iat' => (new DateTimeImmutable('now'))->getTimestamp(),
            'exp' => (new DateTimeImmutable())->add(new DateInterval('PT1H'))->getTimestamp(),
            'data' => [
                'user_id' => (string)$user->getIdentifier(),
            ],
        ];

        return JWT::encode($token, $this->privateKey, $this->algorithm);
    }
}
