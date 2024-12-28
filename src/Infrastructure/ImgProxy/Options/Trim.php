<?php

declare(strict_types=1);

namespace App\Infrastructure\ImgProxy\Options;

use App\Infrastructure\ImgProxy\Support\Color;
use InvalidArgumentException;

use function sprintf;

final class Trim extends AbstractOption
{
    private Color|null $color;

    public function __construct(
        private float $threshold,
        string|null $color = null,
        private bool|null $equalHor = null,
        private bool|null $equalVer = null,
    ) {
        if ($threshold < 0) {
            throw new InvalidArgumentException(sprintf('Invalid threshold: %s', $threshold));
        }

        $this->color = $color === null ? null : Color::fromHex($color);
    }

    public static function name(): string
    {
        return 't';
    }

    /** @inheritDoc */
    public function data(): array
    {
        return [
            $this->threshold,
            $this->color?->value(),
            isset($this->equalHor) ? (int) $this->equalHor : null,
            isset($this->equalVer) ? (int) $this->equalVer : null,
        ];
    }
}
