<?php

declare(strict_types=1);

namespace App\Infrastructure\ImgProxy\Options;

final readonly class MinHeight extends AbstractOption
{
    private Height $height;

    /** @param int<0, max> $height */
    public function __construct(int $height)
    {
        $this->height = new Height($height);
    }

    public static function name(): string
    {
        return 'mh';
    }

    /** @inheritDoc */
    public function data(): array
    {
        return $this->height->data();
    }
}
