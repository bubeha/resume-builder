<?php

declare(strict_types=1);

namespace App\Auth\Domain;

use App\Shared\Domain\Entities\AuthenticatedUser;
use Psr\Http\Message\ServerRequestInterface;

interface Authenticator
{
    public function user(): ?AuthenticatedUser;

    public function setUser(AuthenticatedUser $user): void;

    public function start(ServerRequestInterface $request): void;

    public function supports(ServerRequestInterface $request): bool;
}
