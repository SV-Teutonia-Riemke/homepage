<?php

declare(strict_types=1);

namespace App\Infrastructure\ImgProxy\Options;

final readonly class MaxBytes extends AbstractOption
{
    /** @param int<0, max> $bytes */
    public function __construct(
        private int $bytes,
    ) {
    }

    public static function name(): string
    {
        return 'mb';
    }

    /** @inheritDoc */
    public function data(): array
    {
        return [
            $this->bytes,
        ];
    }
}
