<?php

declare(strict_types=1);

namespace App\Auth\Domain\Manager;

use App\Shared\Domain\Entities\AuthenticatedUser;

interface JwtTokenManager
{
    public function create(AuthenticatedUser $user): string;

    // todo add decode
}
