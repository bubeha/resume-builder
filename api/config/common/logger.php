<?php

declare(strict_types=1);

use Monolog\Handler\StreamHandler;
use Monolog\Level;
use Monolog\Logger;
use Psr\Container\ContainerInterface;
use Psr\Log\LoggerInterface;

return [
    LoggerInterface::class => static function (ContainerInterface $container) {
        /**
         * @var array{level: int, stream: false|string} $config
         */
        $config = $container->get('logger');

        $logger = new Logger('App');

        $logger->pushHandler(
            new StreamHandler($config['stream'] === 'file' ? __DIR__ . '/../../var/logs/app.log' : 'php://stdout', $config['level']),
        );

        return $logger;
    },
    'logger' => [
        'level' => filter_var(getenv('APP_DEBUG'), FILTER_VALIDATE_BOOL) ? Level::Debug : Level::Info,
        'stream' => getenv('LOG_STREAM'),
    ],
];
