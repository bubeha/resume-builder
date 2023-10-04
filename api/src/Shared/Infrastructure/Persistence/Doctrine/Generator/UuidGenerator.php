<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Persistence\Doctrine\Generator;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Id\AbstractIdGenerator;
use App\Shared\Domain\ValueObjects\Uuid;

final class UuidGenerator extends AbstractIdGenerator
{
    public function generate(EntityManagerInterface $em, $entity): Uuid
    {
        return Uuid::generate();
    }
}
