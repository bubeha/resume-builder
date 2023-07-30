<?php

declare(strict_types=1);

use App\UI\Http\Rest\Actions\HomeAction;
use Slim\App;

return static function (App $app): void {
    $app->get('/', HomeAction::class);
};
