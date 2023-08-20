<?php

declare(strict_types=1);

use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseFactoryInterface;
use Slim\CallableResolver;
use Slim\Interfaces\CallableResolverInterface;
use Slim\Psr7\Factory\ResponseFactory;

return [
    CallableResolverInterface::class => static fn (ContainerInterface $container) => new CallableResolver($container),
    ResponseFactoryInterface::class => static fn (ContainerInterface $container) => new ResponseFactory(),
];
