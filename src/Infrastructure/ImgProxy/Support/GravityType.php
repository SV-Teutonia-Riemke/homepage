<?php

declare(strict_types=1);

namespace App\Infrastructure\ImgProxy\Support;

use InvalidArgumentException;

use function in_array;
use function sprintf;

class GravityType
{
    public const NORTH       = 'no';
    public const SOUTH       = 'so';
    public const EAST        = 'ea';
    public const WEST        = 'we';
    public const NORTH_EAST  = 'noea';
    public const NORTH_WEST  = 'nowe';
    public const SOUTH_EAST  = 'soea';
    public const SOUTH_WEST  = 'sowe';
    public const CENTER      = 'ce';
    public const SMART       = 'sm';
    public const FOCUS_POINT = 'fp';

    public const TYPES = [
        self::NORTH,
        self::SOUTH,
        self::EAST,
        self::WEST,
        self::NORTH_EAST,
        self::NORTH_WEST,
        self::SOUTH_EAST,
        self::SOUTH_WEST,
        self::CENTER,
        self::SMART,
        self::FOCUS_POINT,
    ];

    public function __construct(private string $type)
    {
        if (! in_array($type, self::TYPES)) {
            throw new InvalidArgumentException(sprintf('Invalid gravity: %s', $type));
        }
    }

    public function value(): string
    {
        return $this->type;
    }
}
