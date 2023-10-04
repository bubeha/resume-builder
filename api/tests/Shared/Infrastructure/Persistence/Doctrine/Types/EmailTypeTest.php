<?php

declare(strict_types=1);

namespace Tests\Shared\Infrastructure\Persistence\Doctrine\Types;

use DG\BypassFinals;
use Doctrine\DBAL\Exception;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\ConversionException;
use Doctrine\DBAL\Types\Type;
use App\Shared\Infrastructure\Persistence\Doctrine\Types\EmailType;
use PHPUnit\Framework\TestCase;
use App\Shared\Domain\ValueObjects\Email;

/**
 * @internal
 */
final class EmailTypeTest extends TestCase
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

        if (!Type::hasType(EmailType::NAME)) {
            Type::addType(EmailType::NAME, EmailType::class);
        }

        $this->type = Type::getType(EmailType::NAME);
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
    public function testConvertToPhpValueShouldReturnUuidClass(): void
    {
        self::assertInstanceOf(Email::class, $this->type->convertToPHPValue('some@correct.email', $this->platform));
    }

    public function testConvertToPhpValueShouldThrowException(): void
    {
        $this->expectException(ConversionException::class);

        $this->type->convertToPHPValue(Email::fromString('some@correct.email'), $this->platform);
    }

    public function testConvertToPhpValueShouldThrowExceptionWithIncorrectEmail(): void
    {
        $this->expectException(ConversionException::class);

        $this->type->convertToPHPValue('some incorrect email', $this->platform);
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
        $email = Email::fromString('some@correct.email');

        self::assertSame((string)$email, $this->type->convertToDatabaseValue($email, $this->platform));
    }

    public function testConvertToDatabaseShouldThrowException(): void
    {
        $this->expectException(ConversionException::class);

        $this->type->convertToDatabaseValue((string)Email::fromString('some@correct.email'), $this->platform);
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
