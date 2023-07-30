<?php

require __DIR__ . '/../vendor/autoload.php';

http_response_code(500);

require __DIR__ . '/../config/bootstrap.php';

$container = require __DIR__ . '/../config/container.php';
$app = (require __DIR__ . '/../config/app.php')($container);

$app->run();
