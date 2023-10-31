<?php

declare(strict_types=1);

namespace App\Shared\Application\CommandBus;

interface CommandHandler
{
    public function handle(Command $command): void;
}