<?php

declare(strict_types=1);

namespace Tests\UI\Http\Rest\Actions;

use Psr\Http\Message\ResponseInterface as Response;
use Slim\Exception\HttpBadRequestException;
use Tests\WebTestCase;
use UI\Http\Rest\Actions\AbstractAction;

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

    public function testInvalidArgumentResponse(): void
    {
        $app = $this->getAppInstance();

        $testAction = new class() extends AbstractAction {
            public function handle(): Response
            {
                return $this->json($this->getArg('incorrect-argument'), 201);
            }
        };

        $app->get('/test-action-response', $testAction);
        $request = self::request('GET', '/test-action-response');

        $response = $app->handle($request);

        self::assertEquals(400, $response->getStatusCode());
    }
}
