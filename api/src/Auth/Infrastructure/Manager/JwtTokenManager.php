<?php

declare(strict_types=1);

namespace App\Auth\Infrastructure\Manager;

use App\Auth\Domain\Manager\JwtTokenManager as JwtTokenManagerInterface;
use App\Shared\Domain\Entities\AuthenticatedUser;
use DateInterval;
use DateTimeImmutable;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Throwable;

final readonly class JwtTokenManager implements JwtTokenManagerInterface
{
    public function __construct(
        private string $privateKey,
        private string $publicKey,
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

    public function decode(string $token): false|object
    {
        try {
            return JWT::decode($token, new Key($this->publicKey, $this->algorithm))->data;
        } catch (Throwable) {
            return false;
        }
    }
}
