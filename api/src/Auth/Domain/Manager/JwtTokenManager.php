<?php

declare(strict_types=1);

namespace App\Auth\Domain\Manager;

use App\Shared\Domain\Entities\UserInterface;

interface JwtTokenManager
{
    public function create(UserInterface $user): string;
}