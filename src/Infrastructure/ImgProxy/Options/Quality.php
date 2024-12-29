<?php

declare(strict_types=1);

namespace App\Infrastructure\ImgProxy\Options;

final readonly class Quality extends AbstractOption
{
    /** @param int<0, 100> $quality */
    public function __construct(private int $quality)
    {
    }

    public static function name(): string
    {
        return 'q';
    }

    /** @inheritDoc */
    public function data(): array
    {
        return [
            $this->quality,
        ];
    }
}
