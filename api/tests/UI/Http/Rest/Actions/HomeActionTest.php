<?php

declare(strict_types=1);

namespace Tests\UI\Http\Rest\Actions;

use Tests\WebTestCase;

/**
 * @internal
 */
final class HomeActionTest extends WebTestCase
{
    public function testHomeResponse(): void
    {
        $app = $this->getAppInstance();

        $request = self::request('GET', '/');

        $response = $app->handle($request);

        self::assertEquals(201, $response->getStatusCode());
        self::assertEquals('"Hello World!!!"', (string)$response->getBody());
    }
}
