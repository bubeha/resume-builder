<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Doctrine\Types;

use App\Domain\ValueObjects\DateTime;
use App\Domain\ValueObjects\Email;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\ConversionException;
use Doctrine\DBAL\Types\DateTimeImmutableType;
use Throwable;

final class DateTimeType extends DateTimeImmutableType
{
    public const NAME = 'datetime_immutable';

    /**
     * @throws ConversionException
     */
    public function convertToPHPValue($value, AbstractPlatform $platform): ?DateTime
    {
        if ($value === null) {
            return null;
        }

        try {
            return DateTime::create((string)$value);
        } catch (Throwable) {
        }

        throw ConversionException::conversionFailedFormat($value, self::NAME, $platform->getDateTimeFormatString());
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform): ?string
    {
        if (empty($value)) {
            return null;
        }

        if (!$value instanceof DateTime) {
            throw ConversionException::conversionFailedInvalidType(
                $value,
                self::NAME,
                ['null', Email::class],
            );
        }

        return (string)$value;
    }
}
