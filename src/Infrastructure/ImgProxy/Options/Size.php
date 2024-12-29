<?php

declare(strict_types=1);

namespace App\Infrastructure\ImgProxy\Options;

use InvalidArgumentException;

final readonly class Size extends AbstractOption
{
    private Width|null $width;

    private Height|null $height;

    /**
     * @param int<0, max>|null $width
     * @param int<0, max>|null $height
     */
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

        $this->width  = $width === null ? null : new Width($width);
        $this->height = $height === null ? null : new Height($height);
    }

    public static function name(): string
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
