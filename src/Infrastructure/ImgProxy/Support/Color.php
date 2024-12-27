<?php

declare(strict_types=1);

namespace App\Infrastructure\ImgProxy\Support;

use InvalidArgumentException;

use function count;
use function ctype_digit;
use function explode;
use function implode;
use function max;
use function preg_match;
use function sprintf;
use function strtolower;

class Color
{
    private string $color;

    public function __construct(string $color)
    {
        if (! $this->isValidHexColor($color) && ! $this->isValidRgbColor($color)) {
            throw new InvalidArgumentException(sprintf('Invalid color: %s', $color));
        }

        $this->color = strtolower($color);
    }

    public static function fromHex(string $color): self
    {
        if (! self::isValidHexColor($color)) {
            throw new InvalidArgumentException(sprintf('Invalid color: %s', $color));
        }

        return new self($color);
    }

    public function value(): string
    {
        return $this->color;
    }

    private static function isValidHexColor(string $color): bool
    {
        return (bool) preg_match('/^[a-f0-9]{6}$/i', $color);
    }

    private static function isValidRgbColor(string $color): bool
    {
        $rgb = explode(':', $color);

        return count($rgb) === 3 && ctype_digit(implode($rgb)) && max($rgb) <= 255;
    }
}
