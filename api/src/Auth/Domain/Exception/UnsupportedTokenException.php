<?php

declare(strict_types=1);

namespace App\Auth\Domain\Exception;

use RuntimeException;

final class UnsupportedTokenException extends RuntimeException
{
    public function __construct()
    {
        parent::__construct('Unsupported authorization token.');
    }
}
