<?php

declare(strict_types=1);

namespace App\Auth\Infrastructure\Generator;

final readonly class KeyPair
{
    public function __construct(
        private string $privateKey,
        private string $publicKey,
    ) {}

    public static function make(string $privateKey, string $publicKey): self
    {
        return new self($privateKey, $publicKey);
    }

    public function getPrivateKey(): string
    {
        return $this->privateKey;
    }

    public function getPublicKey(): string
    {
        return $this->publicKey;
    }
}
