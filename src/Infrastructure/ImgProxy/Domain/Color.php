<?php

declare(strict_types=1);

namespace App\Infrastructure\ImgProxy\Domain;

use InvalidArgumentException;

use function ltrim;
use function preg_match;
use function sprintf;
use function strtolower;

final readonly class Color
{
    public string $color;

    public function __construct(string $color)
    {
        $color = ltrim($color, '#');

        if (! self::isValidHexColor($color)) {
            throw new InvalidArgumentException(sprintf('Invalid color: %s', $color));
        }

        $this->color = strtolower($color);
    }

    public static function fromString(string $color): self
    {
        return new self($color);
    }

    public static function fromStringOrSelf(string|self $color): self
    {
        if ($color instanceof self) {
            return $color;
        }

        return self::fromString($color);
    }

    public static function isValidHexColor(string $color): bool
    {
        return preg_match('/^[a-f0-9]{6}$/i', $color) !== false;
    }
}
