<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Persistence\Doctrine\Types;

use App\Shared\Domain\ValueObjects\HashedPassword;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\ConversionException;
use Doctrine\DBAL\Types\StringType;

final class HashedPasswordType extends StringType
{
    public const NAME = 'hashed_password';

    public function convertToPHPValue($value, AbstractPlatform $platform): ?HashedPassword
    {
        if ($value === null) {
            return null;
        }

        if (\is_string($value)) {
            return HashedPassword::fromHash($value);
        }

        throw ConversionException::conversionFailedFormat($value, $this->getName(), 'Hashed password string');
    }

    public function getName(): string
    {
        return self::NAME;
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform): ?string
    {
        if (empty($value)) {
            return null;
        }

        if (!$value instanceof HashedPassword) {
            throw ConversionException::conversionFailedInvalidType(
                $value,
                $this->getName(),
                ['null', HashedPassword::class],
            );
        }

        return (string)$value;
    }
}
