<?php

declare(strict_types=1);

namespace Tests\UI\Http\Rest\Actions;

use UI\Http\Rest\Actions\AbstractAction;
use Psr\Http\Message\ResponseInterface as Response;
use Tests\WebTestCase;

/**
 * @internal
 */
final class AbstractActionWebTest extends WebTestCase
{
    public function testTestActionResponse(): void
    {
        $app = $this->getAppInstance();

        $testAction = new class() extends AbstractAction {
            public function handle(): Response
            {
                return $this->json($this->getArg('response'), 201);
            }
        };

        $app->get('/test-action-response/{response}', $testAction);
        $request = self::request('GET', '/test-action-response/result');

        $response = $app->handle($request);

        self::assertEquals(201, $response->getStatusCode());
        self::assertEquals('"result"', (string)$response->getBody());
    }
}
