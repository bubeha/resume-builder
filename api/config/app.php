<?php

declare(strict_types=1);

use Psr\Container\ContainerInterface;
use Slim\Factory\AppFactory;

return static function (ContainerInterface $container) {
    AppFactory::setContainer($container);

    $app = AppFactory::create();

    (require __DIR__ . '/routes.php')($app);

    return $app;
};
