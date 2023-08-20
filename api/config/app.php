<?php

declare(strict_types=1);

use Psr\Container\ContainerInterface;
use Slim\Factory\AppFactory;
use Slim\Middleware\ErrorMiddleware;

return static function (ContainerInterface $container) {
    $app = AppFactory::createFromContainer($container);

    (require __DIR__ . '/routes.php')($app);

    $app->add(ErrorMiddleware::class);

    return $app;
};
