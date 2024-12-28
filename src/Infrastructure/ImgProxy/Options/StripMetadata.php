<?php

declare(strict_types=1);

namespace App\Infrastructure\ImgProxy\Options;

final class StripMetadata extends AbstractOption
{
    public function __construct(private bool $strip = true)
    {
    }

    public static function name(): string
    {
        return 'sm';
    }

    /** @inheritDoc */
    public function data(): array
    {
        return [
            (int) $this->strip,
        ];
    }
}
