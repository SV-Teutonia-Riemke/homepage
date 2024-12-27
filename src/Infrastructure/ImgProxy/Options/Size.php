<?php

declare(strict_types=1);

namespace App\Infrastructure\ImgProxy\Options;

use InvalidArgumentException;

final class Size extends AbstractOption
{
    private Width|null $width = null;

    private Height|null $height = null;

    public function __construct(
        int|null $width = null,
        int|null $height = null,
        private bool|null $enlarge = null,
        private bool|null $extend = null,
    ) {
        $leastOnOf = $width ?? $height ?? $enlarge ?? $extend;
        if ($leastOnOf === null) {
            throw new InvalidArgumentException('At least one size argument must be set');
        }

        if ($width !== null) {
            $this->width = new Width($width);
        }

        if ($height === null) {
            return;
        }

        $this->height = new Height($height);
    }

    public function name(): string
    {
        return 's';
    }

    /** @inheritDoc */
    public function data(): array
    {
        return [
            $this->width?->width,
            $this->height?->height,
            $this->enlarge === null ? null : ($this->enlarge ? 1 : 0),
            $this->extend === null ? null : ($this->extend ? 1 : 0),
        ];
    }
}
