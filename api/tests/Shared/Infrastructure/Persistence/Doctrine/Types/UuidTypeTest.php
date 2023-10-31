<?php

declare(strict_types=1);

namespace Tests\Shared\Infrastructure\Persistence\Doctrine\Types;

use Doctrine\DBAL\Exception;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\ConversionException;
use Doctrine\DBAL\Types\Type;
use App\Shared\Infrastructure\Persistence\Doctrine\Types\UuidType;
use PHPUnit\Framework\TestCase;
use App\Shared\Domain\ValueObjects\Uuid;

/**
 * @internal
 */
final class UuidTypeTest extends TestCase
{
    private Type $type;
    private AbstractPlatform $platform;

    /**
     * @throws Exception
     * @throws \PHPUnit\Framework\MockObject\Exception
     */
    protected function setUp(): void
    {
        if (!Type::hasType(UuidType::NAME)) {
            Type::addType(UuidType::NAME, UuidType::class);
        }

        $this->type = Type::getType(UuidType::NAME);
        $this->platform = $this->getPlatformMock();
    }

    public function testSqlDeclarationType(): void
    {
        self::assertSame('UUID', $this->type->getSQLDeclaration([], $this->platform));
    }

    /**
     * @throws ConversionException
     */
    public function testConvertToPhpValueShouldReturnNull(): void
    {
        self::assertNull($this->type->convertToPHPValue(null, $this->platform));
    }

    /**
     * @throws ConversionException
     */
    public function testConvertToPhpValueShouldReturnSameUuid(): void
    {
        $uuid = Uuid::generate();

        self::assertSame($uuid, $this->type->convertToPHPValue($uuid, $this->platform));
    }

    /**
     * @throws ConversionException
     */
    public function testConvertToPhpValueShouldReturnUuidClass(): void
    {
        self::assertInstanceOf(Uuid::class, $this->type->convertToPHPValue((string)Uuid::generate(), $this->platform));
    }

    public function testConvertToPhpValueShouldThrowException(): void
    {
        $this->expectException(ConversionException::class);

        $this->type->convertToPHPValue('incorrect-uuid', $this->platform);
    }

    /**
     * @throws ConversionException
     */
    public function testConvertToDatabaseValueShouldReturnNull(): void
    {
        self::assertNull($this->type->convertToDatabaseValue(null, $this->platform));
    }

    /**
     * @throws ConversionException
     */
    public function testConvertToDatabaseShouldReturnUuidClass(): void
    {
        $uuid = Uuid::generate();

        self::assertSame((string)$uuid, $this->type->convertToDatabaseValue($uuid, $this->platform));
    }

    public function testConvertToDatabaseShouldThrowException(): void
    {
        $this->expectException(ConversionException::class);

        $this->type->convertToDatabaseValue((string)Uuid::generate(), $this->platform);
    }

    /**
     * @throws \PHPUnit\Framework\MockObject\Exception
     */
    private function getPlatformMock(): AbstractPlatform
    {
        $mockObject = $this->createMock(AbstractPlatform::class);

        $mockObject->method('getGuidTypeDeclarationSQL')
            ->willReturn('UUID')
        ;

        return $mockObject;
    }
}
