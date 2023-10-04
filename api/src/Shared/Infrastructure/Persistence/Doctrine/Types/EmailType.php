<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Persistence\Doctrine\Types;

use App\Shared\Domain\ValueObjects\Email;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\ConversionException;
use Doctrine\DBAL\Types\StringType;
use Throwable;

final class EmailType extends StringType
{
    public const NAME = 'email';

    public function convertToPHPValue($value, AbstractPlatform $platform): ?Email
    {
        if ($value === null) {
            return null;
        }

        if (\is_string($value)) {
            try {
                return Email::fromString($value);
            } catch (Throwable) {
            }
        }

        throw ConversionException::conversionFailedFormat($value, $this->getName(), 'Email string');
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform): ?string
    {
        if (empty($value)) {
            return null;
        }

        if (!$value instanceof Email) {
            throw ConversionException::conversionFailedInvalidType(
                $value,
                $this->getName(),
                ['null', Email::class],
            );
        }

        return (string)$value;
    }

    public function getName(): string
    {
        return self::NAME;
    }
}
