<?php

declare(strict_types=1);

use Slim\App;
use UI\Http\Rest\Actions\HealthCheckAction;
use UI\Http\Rest\Actions\HomeAction;

return static function (App $app): void {
    $app->get('/', HomeAction::class);

    $app->get('/health', HealthCheckAction::class);
};
