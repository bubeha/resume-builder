<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Doctrine\Generator;

use App\Domain\ValueObjects\Uuid;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Id\AbstractIdGenerator;

final class UuidGenerator extends AbstractIdGenerator
{
    public function generate(EntityManagerInterface $em, $entity): Uuid
    {
        return Uuid::generate();
    }
}