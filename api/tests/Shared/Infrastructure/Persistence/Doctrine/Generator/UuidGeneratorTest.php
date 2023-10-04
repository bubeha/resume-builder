<?php

declare(strict_types=1);

namespace Tests\Shared\Infrastructure\Persistence\Doctrine\Generator;

use App\Shared\Domain\ValueObjects\Uuid;
use App\Shared\Infrastructure\Persistence\Doctrine\Generator\UuidGenerator;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Mapping\Entity;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 */
final class UuidGeneratorTest extends TestCase
{
    public function testUuidGeneratorGenerate(): void
    {
        /** @var \Doctrine\ORM\EntityManagerInterface $em */
        $em = self::createMock(EntityManager::class);

        $entity = new Entity();
        $generator = new UuidGenerator();

        $uuid = $generator->generate($em, $entity);

        self::assertInstanceOf(Uuid::class, $uuid);
    }
}
