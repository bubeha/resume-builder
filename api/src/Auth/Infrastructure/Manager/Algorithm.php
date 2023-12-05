<?php

declare(strict_types=1);

namespace App\Auth\Infrastructure\Manager;

interface Algorithm
{
    public const HS256 = 'HS256';
    public const HS256_BITS = 512;
    public const HS256_TYPE = OPENSSL_KEYTYPE_DH;
}
