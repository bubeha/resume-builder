<?php

declare(strict_types=1);

use Dotenv\Dotenv;

if (!class_exists(Dotenv::class)) {
    throw new RuntimeException();
}

$dotenv = Dotenv::createUnsafeImmutable(__DIR__ . '/../');
$dotenv->load();
