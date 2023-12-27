<?php

declare(strict_types=1);

namespace App\Auth\Infrastructure\Controller;

use App\Shared\Domain\Entities\AuthenticatedUser;
use App\Shared\Domain\Entities\User;
use App\Shared\Infrastructure\Controller\AbstractAction;
use Psr\Http\Message\ResponseInterface as Response;
use Webmozart\Assert\Assert;

final class MeAction extends AbstractAction
{
    public function __construct(
        private readonly AuthenticatedUser $user,
    ) {}

    public function handle(): Response
    {
        Assert::isInstanceOf($this->user, User::class);

        return $this->json([
            'id' => (string)$this->user->getIdentifier(),
            'email' => (string)$this->user->getEmail(),
        ]);
    }
}
