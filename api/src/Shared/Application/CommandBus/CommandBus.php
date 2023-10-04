<?php

declare(strict_types=1);

namespace App\Shared\Application\CommandBus;

interface CommandBus
{
    public function handle(object $command): void;
}
