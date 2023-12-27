<?php

declare(strict_types=1);

namespace Tests\Shared\Infrastructure\Persistence\Doctrine\Types;

use App\Shared\Domain\ValueObjects\HashedPassword;
use App\Shared\Infrastructure\Persistence\Doctrine\Types\HashedPasswordType;
use Doctrine\DBAL\Exception;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\ConversionException;
use Doctrine\DBAL\Types\Type;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 */
final class HashedPasswordTest extends TestCase
{
    private Type $type;
    private AbstractPlatform $platform;

    /**
     * @throws Exception
     * @throws \PHPUnit\Framework\MockObject\Exception
     */
    protected function setUp(): void
    {
        if (!Type::hasType(HashedPasswordType::NAME)) {
            Type::addType(HashedPasswordType::NAME, HashedPasswordType::class);
        }

        $this->type = Type::getType(HashedPasswordType::NAME);
        $this->platform = $this->getPlatformMock();
    }

    public function testSqlDeclarationType(): void
    {
        self::assertSame('string', $this->type->getSQLDeclaration([], $this->platform));
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
    public function testConvertToPhpValueShouldReturnHashedPassword(): void
    {
        self::assertInstanceOf(HashedPassword::class, $this->type->convertToPHPValue('hashed-password', $this->platform));
    }

    public function testConvertToPhpValueShouldThrowException(): void
    {
        $this->expectException(ConversionException::class);

        $this->type->convertToPHPValue(12345678, $this->platform);
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
    public function testConvertToDatabaseShouldReturnEmailClass(): void
    {
        $hashedPassword = HashedPassword::encode('12345678');

        self::assertSame((string)$hashedPassword, $this->type->convertToDatabaseValue($hashedPassword, $this->platform));
    }

    public function testConvertToDatabaseShouldThrowException(): void
    {
        $this->expectException(ConversionException::class);

        $this->type->convertToDatabaseValue(12345678, $this->platform);
    }

    /**
     * @throws \PHPUnit\Framework\MockObject\Exception
     */
    private function getPlatformMock(): AbstractPlatform
    {
        $mockObject = $this->createMock(AbstractPlatform::class);

        $mockObject->method('getStringTypeDeclarationSQL')
            ->willReturn('string')
        ;

        return $mockObject;
    }
}
