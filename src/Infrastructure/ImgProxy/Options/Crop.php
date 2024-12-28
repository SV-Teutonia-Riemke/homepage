<?php

declare(strict_types=1);

namespace App\Infrastructure\ImgProxy\Options;

use function array_merge;
use function is_string;

final class Crop extends AbstractOption
{
    private Width $width;

    private Height $height;

    private Gravity|null $gravity;

    public function __construct(
        int $width,
        int $height,
        Gravity|string|null $gravity = null,
    ) {
        $this->width   = new Width($width);
        $this->height  = new Height($height);
        $this->gravity = is_string($gravity) ? Gravity::fromString($gravity) : $gravity;
    }

    public static function name(): string
    {
        return 'c';
    }

    /** @inheritDoc */
    public function data(): array
    {
        return array_merge(
            $this->width->data(),
            $this->height->data(),
            $this->gravity?->data() ?? [],
        );
    }
}
