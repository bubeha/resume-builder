<?php

declare(strict_types=1);

namespace App\Auth\Infrastructure\Controller;

use App\Auth\Application\CommandBus\Login\LoginCommand;
use App\Auth\Application\CommandBus\Login\LoginHandler;
use App\Shared\Infrastructure\Controller\AbstractAction;
use Psr\Http\Message\ResponseInterface as Response;
use Throwable;

final class LoginAction extends AbstractAction
{
    public function __construct(
        private readonly LoginHandler $handler,
    ) {}

    public function handle(): Response
    {
        /** @var array{email: string, password: string} $result */
        $result = $this->request?->getParsedBody();

        try {
            $result = $this->handler
                ->handle(
                    new LoginCommand($result['email'] ?? '', $result['password'] ?? ''),
                )
            ;

            return $this->json([
                'token' => $result,
            ]);
        } catch (Throwable $throwable) {
            return $this->json([
                'message' => $throwable->getMessage(),
            ], 400);
        }
    }
}
