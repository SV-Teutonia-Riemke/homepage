<?php

declare(strict_types=1);

namespace App\Infrastructure\ImgProxy\Options;

use InvalidArgumentException;

use function sprintf;

final readonly class Zoom extends AbstractOption
{
    public function __construct(
        private float $x,
        private float|null $y = null,
    ) {
        if ($x <= 0) {
            throw new InvalidArgumentException(sprintf('Invalid zoom X value: %s', $x));
        }

        if ($y !== null && $y <= 0) {
            throw new InvalidArgumentException(sprintf('Invalid zoom Y value: %s', $y));
        }
    }

    public static function name(): string
    {
        return 'z';
    }

    /** @inheritDoc */
    public function data(): array
    {
        return [
            $this->x,
            $this->y,
        ];
    }
}
