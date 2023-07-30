<?php

declare(strict_types=1);

namespace Tests;

use PHPUnit\Framework\TestCase as PHPUnitTestCase;
use Psr\Http\Message\ServerRequestInterface;
use Slim\App;
use Slim\Psr7\Factory\ServerRequestFactory;

abstract class WebTestCase extends PHPUnitTestCase
{
    private ?App $app = null;

    protected function tearDown(): void
    {
        $this->app = null;
        parent::tearDown();
    }

    protected static function request(string $method, string $path): ServerRequestInterface
    {
        return (new ServerRequestFactory())->createServerRequest($method, $path);
    }

    protected function getAppInstance(): App
    {
        if ($this->app) {
            return $this->app;
        }

        $container = require __DIR__ . '/../config/container.php';
        $this->app = (require __DIR__ . '/../config/app.php')($container);

        return $this->app;
    }
}
