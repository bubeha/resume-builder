<?php

declare(strict_types=1);

namespace App\Auth\Infrastructure\Middleware;

use App\Auth\Domain\Authenticator;
use App\Auth\Domain\Exception\UnsupportedTokenException;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

final readonly class Authenticate implements MiddlewareInterface
{
    public function __construct(
        private Authenticator $authenticator,
    ) {}

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        if (!$this->authenticator->supports($request)) {
            throw new UnsupportedTokenException();
        }

        $this->authenticator->start($request);

        return $handler->handle($request);
    }
}
