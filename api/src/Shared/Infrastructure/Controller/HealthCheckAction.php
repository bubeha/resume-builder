<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Controller;

use Psr\Http\Message\ResponseInterface as Response;

final class HealthCheckAction extends AbstractAction
{
    public function handle(): Response
    {
        return $this->json('alive');
    }
}
