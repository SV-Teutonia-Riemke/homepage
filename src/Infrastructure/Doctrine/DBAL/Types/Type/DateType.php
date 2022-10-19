<?php

declare(strict_types=1);

namespace App\Infrastructure\Doctrine\DBAL\Types\Type;

use App\Domain\Date;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\ConversionException;
use Doctrine\DBAL\Types\Type;
use Throwable;

final class DateType extends Type
{
    public const NAME = 'date';

    public function getName(): string
    {
        return self::NAME;
    }

    /** @inheritdoc */
    public function getSQLDeclaration(array $column, AbstractPlatform $platform): string
    {
        return $platform->getDateTypeDeclarationSQL($column);
    }

    /** @inheritdoc */
    public function convertToPHPValue($value, AbstractPlatform $platform): Date|null
    {
        if ($value === null) {
            return null;
        }

        if ($value instanceof Date) {
            return $value;
        }

        try {
            return Date::fromString($value);
        } catch (Throwable) {
            throw ConversionException::conversionFailedFormat(
                $value,
                self::NAME,
                $platform->getDateFormatString(),
            );
        }
    }

    /** @inheritdoc */
    public function convertToDatabaseValue($value, AbstractPlatform $platform): string|null
    {
        if ($value === null) {
            return null;
        }

        if ($value instanceof Date) {
            return $value->format($platform->getDateFormatString());
        }

        throw ConversionException::conversionFailedInvalidType($value, self::NAME, ['null', Date::class]);
    }

    public function requiresSQLCommentHint(AbstractPlatform $platform): bool
    {
        return true;
    }
}
