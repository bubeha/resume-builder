<?php

declare(strict_types=1);

namespace Tests\Shared\Infrastructure\Controller;

use Tests\WebTestCase;

/**
 * @internal
 */
final class HealthCheckActionTest extends WebTestCase
{
    public function testHomeResponse(): void
    {
        $app = $this->getAppInstance();

        $request = self::request('GET', '/health');

        $response = $app->handle($request);

        self::assertEquals(200, $response->getStatusCode());
        self::assertEquals('"alive"', (string)$response->getBody());
    }
}
