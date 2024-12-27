<?php

declare(strict_types=1);

namespace App\Infrastructure\ImgProxy\Options;

final class StripColorProfile extends AbstractOption
{
    public function __construct(private bool $strip = true)
    {
    }

    public function name(): string
    {
        return 'scp';
    }

    /** @inheritDoc */
    public function data(): array
    {
        return [
            (int) $this->strip,
        ];
    }
}
