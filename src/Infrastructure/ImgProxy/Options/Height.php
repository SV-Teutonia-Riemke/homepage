<?php

declare(strict_types=1);

namespace App\Infrastructure\ImgProxy\Options;

final readonly class Height extends AbstractOption
{
    /** @param int<0, max> $height */
    public function __construct(
        public readonly int $height,
    ) {
    }

    public static function name(): string
    {
        return 'h';
    }

    /** @inheritDoc */
    public function data(): array
    {
        return [
            $this->height,
        ];
    }
}
