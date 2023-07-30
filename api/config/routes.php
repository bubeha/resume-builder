<?php

use App\UI\Http\Rest\Actions\BaseAction;
use Slim\App;

return static function (App $app) {
    $app->get('/', BaseAction::class);
};
