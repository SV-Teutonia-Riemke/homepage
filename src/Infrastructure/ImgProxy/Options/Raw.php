<?php

declare(strict_types=1);

namespace App\Infrastructure\ImgProxy\Options;

final class Raw extends AbstractOption
{
    public function __construct(private bool $raw = true)
    {
    }

    public function name(): string
    {
        return 'raw';
    }

    /** @inheritDoc */
    public function data(): array
    {
        return [
            (int) $this->raw,
        ];
    }
}
