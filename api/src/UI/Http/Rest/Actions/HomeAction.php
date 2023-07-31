<?php

declare(strict_types=1);

namespace UI\Http\Rest\Actions;

use Psr\Http\Message\ResponseInterface as Response;

final class HomeAction extends AbstractAction
{
    public function handle(): Response
    {
        return $this->json('Hello World!!!', 201);
    }
}
