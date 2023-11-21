<?php

declare(strict_types=1);

namespace App\Auth\Domain\Repository;

use App\Shared\Domain\Entities\User;
use App\Shared\Domain\ValueObjects\Email;

interface UserRepository
{
    public function store(User $user): void;

    public function findByEmail(Email $email): ?User;
}
