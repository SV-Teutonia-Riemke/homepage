<?php

declare(strict_types=1);

namespace App\Infrastructure\ImgProxy\Domain;

enum GravityType: string
{
    case NORTH       = 'no';
    case SOUTH       = 'so';
    case EAST        = 'ea';
    case WEST        = 'we';
    case NORTH_EAST  = 'noea';
    case NORTH_WEST  = 'nowe';
    case SOUTH_EAST  = 'soea';
    case SOUTH_WEST  = 'sowe';
    case CENTER      = 'ce';
    case SMART       = 'sm';
    case FOCUS_POINT = 'fp';

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
}
