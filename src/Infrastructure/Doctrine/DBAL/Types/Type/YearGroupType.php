<?php

declare(strict_types=1);

namespace App\Infrastructure\Doctrine\DBAL\Types\Type;

use App\Domain\YearGroup;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Exception\InvalidFormat;
use Doctrine\DBAL\Types\Exception\InvalidType;
use Doctrine\DBAL\Types\Type;
use Override;
use Throwable;

final class YearGroupType extends Type
{
    public const string NAME = 'year_group';

    public function getName(): string
    {
        return self::NAME;
    }

    /** @inheritdoc */
    public function getSQLDeclaration(
        array $column,
        AbstractPlatform $platform,
    ): string {
        $column['length'] ??= 255;

        return $platform->getStringTypeDeclarationSQL($column);
    }

    /** @inheritdoc */
    #[Override]
    public function convertToPHPValue(
        $value,
        AbstractPlatform $platform,
    ): YearGroup|null {
        if ($value === null) {
            return null;
        }

        if ($value instanceof YearGroup) {
            return $value;
        }

        try {
            return YearGroup::fromString($value);
        } catch (Throwable) {
            throw InvalidFormat::new(
                $value,
                self::NAME,
                $platform->getDateFormatString(),
            );
        }
    }

    /** @inheritdoc */
    #[Override]
    public function convertToDatabaseValue(
        $value,
        AbstractPlatform $platform,
    ): string|null {
        if ($value === null) {
            return null;
        }

        if ($value instanceof YearGroup) {
            return $value->__toString();
        }

        throw InvalidType::new($value, self::NAME, ['null', YearGroup::class]);
    }
}
