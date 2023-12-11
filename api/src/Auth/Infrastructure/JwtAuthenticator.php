<?php

declare(strict_types=1);

namespace App\Auth\Infrastructure;

use App\Auth\Domain\Authenticator;
use App\Auth\Domain\Repository\UserRepository;
use App\Shared\Domain\Entities\AuthenticatedUser;
use App\Shared\Domain\ValueObjects\Uuid;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Exception\HttpUnauthorizedException;
use Throwable;
use Webmozart\Assert\Assert;

final class JwtAuthenticator implements Authenticator
{
    private ?AuthenticatedUser $user = null;

    public function __construct(
        private readonly Key $key,
        private readonly UserRepository $userRepository,
    ) {}

    public function user(): ?AuthenticatedUser
    {
        return $this->user;
    }

    public function setUser(AuthenticatedUser $user): void
    {
        $this->user = $user;
    }

    public function start(ServerRequestInterface $request): void
    {
        $authToken = $this->getAuthorizationToken($request);

        try {
            $result = JWT::decode(\str_replace('Bearer ', '', $authToken), $this->key);

            $user = $this->userRepository->findById(Uuid::fromString($result->data->user_id));

            Assert::isInstanceOf($user, AuthenticatedUser::class);

            $this->setUser($user);
        } catch (Throwable $throwable) {
            throw new HttpUnauthorizedException($request, $throwable->getMessage());
        }
    }

    public function supports(ServerRequestInterface $request): bool
    {
        return \str_starts_with($this->getAuthorizationToken($request), 'Bearer ');
    }

    public function getAuthorizationToken(ServerRequestInterface $request): string
    {
        return $request->getHeaderLine('Authorization');
    }
}
