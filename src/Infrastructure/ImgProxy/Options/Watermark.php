<?php

declare(strict_types=1);

namespace App\Infrastructure\ImgProxy\Options;

use App\Infrastructure\ImgProxy\Support\GravityType;
use InvalidArgumentException;

use function array_merge;
use function in_array;
use function sprintf;

final class Watermark extends AbstractOption
{
    private const string REPLICATE_POSITION = 're';

    public function __construct(
        private float $opacity,
        private string|null $position = null,
        private int|null $x = null,
        private int|null $y = null,
        private float|null $scale = null,
    ) {
        if ($opacity < 0 || $opacity > 1) {
            throw new InvalidArgumentException(sprintf('Invalid watermark opacity: %s', $opacity));
        }

        if ($scale < 0) {
            throw new InvalidArgumentException(sprintf('Invalid watermark scale: %s', $scale));
        }

        if ($position !== null && ! in_array($position, $this->positions(), true)) {
            throw new InvalidArgumentException(sprintf('Invalid watermark position: %s', $position));
        }
    }

    public static function name(): string
    {
        return 'wm';
    }

    /** @inheritDoc */
    public function data(): array
    {
        return [
            $this->opacity,
            $this->position,
            $this->x,
            $this->y,
            $this->scale,
        ];
    }

    /** @return array<string> */
    private function positions(): array
    {
        return array_merge(GravityType::TYPES, [self::REPLICATE_POSITION]);
    }
}
