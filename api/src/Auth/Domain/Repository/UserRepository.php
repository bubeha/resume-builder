<?php

declare(strict_types=1);

namespace App\Auth\Domain\Repository;

use App\Shared\Domain\Entities\User;
use Ramsey\Uuid\UuidInterface;

interface UserRepository
{
    public function store(User $user): void;

    public function first(): ?User;
}