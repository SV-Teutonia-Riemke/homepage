<?php

declare(strict_types=1);

namespace App\Infrastructure\ImgProxy\Options;

use App\Infrastructure\ImgProxy\Domain\Color;
use InvalidArgumentException;

use function sprintf;

final readonly class Trim extends AbstractOption
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

        $this->color = $color === null ? null : Color::fromString($color);
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
            $this->color?->color,
            $this->equalHor === null ? null : ($this->equalHor ? 1 : 0),
            $this->equalVer === null ? null : ($this->equalVer ? 1 : 0),
        ];
    }
}
