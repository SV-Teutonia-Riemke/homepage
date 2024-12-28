<?php

declare(strict_types=1);

namespace App\Infrastructure\ImgProxy\Support;

use InvalidArgumentException;

use function preg_match;
use function sprintf;
use function strtolower;
use function trim;

final readonly class Color
{
    private string $color;

    public function __construct(string $color)
    {
        $color = trim($color, '#');

        if (! self::isValidHexColor($color)) {
            throw new InvalidArgumentException(sprintf('Invalid color: %s', $color));
        }

        $this->color = strtolower($color);
    }

    public static function fromHex(string $color): self
    {
        return new self($color);
    }

    public function value(): string
    {
        return $this->color;
    }

    private static function isValidHexColor(string $color): bool
    {
        return preg_match('/^[a-f0-9]{6}$/i', $color) !== false;
    }
}
