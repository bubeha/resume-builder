<?php

declare(strict_types=1);

namespace App\Auth\Domain\Repository;

use App\Shared\Domain\Entities\AuthenticatedUser;
use App\Shared\Domain\Entities\User;
use App\Shared\Domain\ValueObjects\Email;
use App\Shared\Domain\ValueObjects\Uuid;

interface UserRepository
{
    public function store(User $user): void;

    public function findByEmail(Email $email): ?User;

    public function findById(Uuid $uuid): ?AuthenticatedUser;
}
