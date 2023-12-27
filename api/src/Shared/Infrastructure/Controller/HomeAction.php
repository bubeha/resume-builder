<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Controller;

use JsonException;
use Psr\Http\Message\ResponseInterface as Response;

final class HomeAction extends AbstractAction
{
    /**
     * @throws JsonException
     */
    public function handle(): Response
    {
        return $this->json('Hello World!!!', 201);
    }
}
