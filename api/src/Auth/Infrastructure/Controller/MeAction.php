<?php

declare(strict_types=1);

namespace App\Auth\Infrastructure\Controller;

use App\Shared\Domain\Entities\AuthenticatedUser;
use App\Shared\Infrastructure\Controller\AbstractAction;
use Psr\Http\Message\ResponseInterface as Response;

final class MeAction extends AbstractAction
{
    public function __construct(
        private readonly ?AuthenticatedUser $user,
    ) {}

    public function handle(): Response
    {
        return $this->json($this->user);
    }
}
