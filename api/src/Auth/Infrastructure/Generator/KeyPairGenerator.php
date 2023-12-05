<?php

declare(strict_types=1);

namespace App\Auth\Infrastructure\Generator;

use App\Auth\Infrastructure\Manager\Algorithm;
use Webmozart\Assert\Assert;

final class KeyPairGenerator
{
    public static function generate(string $passphrase): KeyPair
    {
        // todo move it to config
        $resource = \openssl_pkey_new([
            'digest_alg' => Algorithm::HS256,
            'private_key_type' => Algorithm::HS256_TYPE,
            'private_key_bits' => Algorithm::HS256_BITS,
        ]);

        Assert::notFalse($resource, \openssl_error_string());

        $success = \openssl_pkey_export($resource, $privateKey, $passphrase);

        Assert::notEmpty($success, \openssl_error_string());

        $publicKeyData = \openssl_pkey_get_details($resource);

        Assert::notFalse($publicKeyData, \openssl_error_string());

        return KeyPair::make($privateKey, $publicKeyData['key']);
    }
}
