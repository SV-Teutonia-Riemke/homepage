<?php

declare(strict_types=1);

namespace App\Infrastructure\ImgProxy\Options;

final readonly class Dpr extends AbstractOption
{
    /** @param int<1, max> $dpr */
    public function __construct(private int $dpr)
    {
    }

    public static function name(): string
    {
        return 'dpr';
    }

    /** @inheritDoc */
    public function data(): array
    {
        return [
            $this->dpr,
        ];
    }
}
