<?php

declare(strict_types=1);

namespace App\Domain\Exceptions;

use Exception;
use Throwable;

final class DateTimeException extends Exception
{
    public function __construct(Throwable $exception)
    {
        parent::__construct('Date and time are malformed or invalid', 500, $exception);
    }
}
