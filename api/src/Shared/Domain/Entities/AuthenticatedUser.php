<?php

declare(strict_types=1);

namespace App\Shared\Domain\Entities;

interface AuthenticatedUser
{
    public function getIdentifier(): mixed;
}
