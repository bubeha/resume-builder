<?php

declare(strict_types=1);

use App\Shared\Infrastructure\Controller\HealthCheckAction;
use App\Shared\Infrastructure\Controller\HomeAction;
use Slim\App;

return static function (App $app): void {
    $app->get('/', HomeAction::class);

    $app->get('/health', HealthCheckAction::class);
};
