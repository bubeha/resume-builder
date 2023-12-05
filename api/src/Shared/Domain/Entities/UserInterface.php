<?php

declare(strict_types=1);

namespace App\Shared\Domain\Entities;

interface UserInterface
{
    public function getIdentifier(): mixed;
}
