<?php

declare(strict_types=1);

namespace App\Infrastructure\ImgProxy\Options;

final class Enlarge extends AbstractOption
{
    public function __construct(private bool $enlarge = true)
    {
    }

    public function name(): string
    {
        return 'el';
    }

    /** @inheritDoc */
    public function data(): array
    {
        return [
            (int) $this->enlarge,
        ];
    }
}
