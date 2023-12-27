<?php

declare(strict_types=1);

namespace App\Auth\Infrastructure\Repository;

use App\Auth\Domain\Repository\UserRepository;
use App\Shared\Domain\Entities\AuthenticatedUser;
use App\Shared\Domain\Entities\User;
use App\Shared\Domain\ValueObjects\Email;
use App\Shared\Domain\ValueObjects\Uuid;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\NonUniqueResultException;

final readonly class UserStore implements UserRepository
{
    public function __construct(
        private EntityManagerInterface $entityManager,
    ) {}

    public function store(User $user): void
    {
        $this->entityManager->persist($user);
        $this->entityManager->flush();
    }

    /**
     * @throws NonUniqueResultException
     */
    public function findByEmail(Email $email): ?User
    {
        // todo move logic to reader
        return $this->entityManager->getRepository(User::class)
            ->createQueryBuilder('u')
            ->where('u.email = :email')
            ->setParameter('email', $email)
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }

    public function findById(Uuid $uuid): ?AuthenticatedUser
    {
        // todo move logic to reader
        return $this->entityManager->getRepository(User::class)
            ->createQueryBuilder('u')
            ->where('u.id = :id')
            ->setParameter('id', $uuid)
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
}
