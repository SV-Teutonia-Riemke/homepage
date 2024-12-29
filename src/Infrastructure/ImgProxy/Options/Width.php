<?php

declare(strict_types=1);

namespace App\Infrastructure\ImgProxy\Options;

final readonly class Width extends AbstractOption
{
    /** @param int<0, max> $width */
    public function __construct(
        public readonly int $width,
    ) {
    }

    public static function name(): string
    {
        return 'w';
    }

    /** @inheritDoc */
    public function data(): array
    {
        return [
            $this->width,
        ];
    }
}
