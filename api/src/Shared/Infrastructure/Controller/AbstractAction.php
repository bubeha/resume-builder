<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Controller;

use JsonException;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Exception\HttpBadRequestException;
use Webmozart\Assert\Assert;

abstract class AbstractAction
{
    protected ?Request $request = null;
    protected ?Response $response = null;

    /** @var array<string, mixed> */
    protected ?array $args = [];

    /**
     * @param array<string, mixed> $args
     */
    public function __invoke(Request $request, Response $response, array $args): Response
    {
        $this->request = $request;
        $this->response = $response;
        $this->args = $args;

        return $this->handle();
    }

    abstract public function handle(): Response;

    /**
     * @throws JsonException
     */
    final protected function json(mixed $payload = null, int $code = 200): Response
    {
        Assert::notNull($this->response);

        $this->response
            ->getBody()
            ->write(\json_encode($payload, JSON_THROW_ON_ERROR))
        ;

        $this->response->withHeader('Content-Type', 'application/json');

        return $this->response
            ->withStatus($code)
        ;
    }

    protected function getArg(string $name, mixed $default = null): mixed
    {
        Assert::notNull($this->request);

        if (!isset($this->args[$name])) {
            throw new HttpBadRequestException($this->request, "Could not resolve argument `{$name}`.");
        }

        return $this->args[$name] ?? $default;
    }
}
