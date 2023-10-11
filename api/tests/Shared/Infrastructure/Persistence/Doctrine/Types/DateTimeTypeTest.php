<?php

declare(strict_types=1);

namespace Tests\Shared\Infrastructure\Persistence\Doctrine\Types;

use DG\BypassFinals;
use Doctrine\DBAL\Exception;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\ConversionException;
use Doctrine\DBAL\Types\Type;
use App\Shared\Domain\Exceptions\DateTimeException;
use App\Shared\Infrastructure\Persistence\Doctrine\Types\DateTimeType;
use PHPUnit\Framework\TestCase;
use App\Shared\Domain\ValueObjects\DateTime;

/**
 * @internal
 */
final class DateTimeTypeTest extends TestCase
{
    private Type $type;
    private AbstractPlatform $platform;

    /**
     * @throws Exception
     * @throws \PHPUnit\Framework\MockObject\Exception
     */
    protected function setUp(): void
    {
        BypassFinals::enable();

        Type::overrideType(DateTimeType::NAME, DateTimeType::class);

        $this->type = Type::getType(DateTimeType::NAME);
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
     * @throws DateTimeException
     */
    public function testConvertToPhpValueShouldReturnUuidClass(): void
    {
        self::assertInstanceOf(DateTime::class, $this->type->convertToPHPValue((string)DateTime::now(), $this->platform));
    }

    public function testConvertToPhpValueShouldThrowException(): void
    {
        $this->expectException(ConversionException::class);

        $this->type->convertToPHPValue('incorrect value', $this->platform);
    }

    /**
     * @throws ConversionException
     */
    public function testConvertToDatabaseValueShouldReturnNull(): void
    {
        self::assertNull($this->type->convertToDatabaseValue(null, $this->platform));
    }

    public function testConvertToDatabaseShouldReturnDateTimeClass(): void
    {
        $dateTime = DateTime:: now();

        self::assertSame((string)$dateTime, $this->type->convertToDatabaseValue($dateTime, $this->platform));
    }

    public function testConvertToDatabaseShouldThrowException(): void
    {
        $this->expectException(ConversionException::class);

        $this->type->convertToDatabaseValue('incorrect value', $this->platform);
    }

    /**
     * @throws \PHPUnit\Framework\MockObject\Exception
     */
    private function getPlatformMock(): AbstractPlatform
    {
        $mockObject = $this->createMock(AbstractPlatform::class);

        $mockObject->method('getDateTimeTypeDeclarationSQL')
            ->willReturn('string')
        ;

        return $mockObject;
    }
}