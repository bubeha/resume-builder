<?php

namespace App\Infrastructure\Persistence\Doctrine\Types;

use App\Domain\ValueObjects\Uuid;
use Doctrine\DBAL\Types\GuidType;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\ConversionException;
use Throwable;

class UuidType extends GuidType
{
    public const NAME = 'uuid';

    public function convertToPHPValue($value, AbstractPlatform $platform): ?Uuid
    {
        if (empty($value)) {
            return null;
        }

        if (\is_string($value)) {
            try {
                return Uuid::fromString($value);
            } catch (Throwable) {
            }
        }

        throw ConversionException::conversionFailedFormat($value, $this->getName(), 'uuid');
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform): ?string
    {
        if (empty($value)) {
            return null;
        }

        if (!$value instanceof Uuid) {
            throw ConversionException::conversionFailedInvalidType(
                $value,
                $this->getName(),
                ['null', Uuid::class],
            );
        }

        return (string)$value;
    }

    public function getName(): string
    {
        return self::NAME;
    }
}