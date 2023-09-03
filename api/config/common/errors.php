<?php

declare(strict_types=1);

use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseFactoryInterface;
use Slim\Interfaces\CallableResolverInterface;
use Slim\Middleware\ErrorMiddleware;

return [
    ErrorMiddleware::class => static function (ContainerInterface $container): ErrorMiddleware {
        $callableResolver = $container->get(CallableResolverInterface::class);
        $responseFactory = $container->get(ResponseFactoryInterface::class);

        /**
         * @var array{display_details:bool} $config
         */
        $config = $container->get('config')['errors'];

        return new ErrorMiddleware(
            $callableResolver,
            $responseFactory,
            $config['display_details'],
            $config['display_details'],
            $config['display_details'],
        );
    },
    'config' => [
        'errors' => [
            'display_details' => filter_var(getenv('APP_DEBUG'), FILTER_VALIDATE_BOOL),
        ],
    ],
];
