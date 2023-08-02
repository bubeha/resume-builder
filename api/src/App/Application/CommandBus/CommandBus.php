<?php

declare(strict_types=1);

namespace App\Application\CommandBus;

interface CommandBus
{
    public function handle(object $command): void;
}
