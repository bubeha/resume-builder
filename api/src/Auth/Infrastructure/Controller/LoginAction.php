<?php

declare(strict_types=1);

namespace App\Auth\Infrastructure\Controller;

use App\Auth\Domain\Repository\UserRepository;
use App\Shared\Domain\ValueObjects\Email;
use App\Shared\Infrastructure\Controller\AbstractAction;
use Firebase\JWT\JWT;
use JsonException;
use Psr\Http\Message\ResponseInterface as Response;

final class LoginAction extends AbstractAction
{
    public function __construct(
        private readonly UserRepository $userRepository,
    ) {}

    /**
     * @throws JsonException
     */
    public function handle(): Response
    {
        /** @var array{email: string, password: string} $result */
        $result = $this->request->getParsedBody();

        $user = $this->userRepository->findByEmail(Email::fromString($result['email']));

        // todo logic
        if ($user && $user->getPasswordHash()->match($result['password'])) {
            $token = [
                'iss' => 'utopian',
                'iat' => \time(),
                'exp' => \time() + 60,
                'data' => [
                    'user_id' => (string)$user->getId(),
                ],
            ];

            return $this->json([
                'token' => JWT::encode($token, 'secret-key', 'HS256'),
            ]);
        }

        return $this->json([], 400);
    }
}
