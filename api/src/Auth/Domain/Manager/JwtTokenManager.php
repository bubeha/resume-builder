<?php

declare(strict_types=1);

namespace App\Auth\Domain\Manager;

use App\Shared\Domain\Entities\AuthenticatedUser;

interface JwtTokenManager
{
    public function create(AuthenticatedUser $user): string;

    /**
     * @return false|object{user_id: string}
     */
    public function decode(string $token): false|object;
}
