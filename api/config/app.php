<?php

declare(strict_types=1);

use App\Shared\Infrastructure\Modules\ModuleInterface;
use Psr\Container\ContainerInterface;
use Slim\Factory\AppFactory;
use Slim\Middleware\ErrorMiddleware;

return static function (ContainerInterface $container) {
    $app = AppFactory::createFromContainer($container);

    /** @var list<ModuleInterface> $modules */
    $modules = $container->get(ModuleInterface::class);

    foreach ($modules as $module) {
        $module->configure($app, $container);
    }

    $app->addBodyParsingMiddleware();
    $app->add(ErrorMiddleware::class);

    return $app;
};
