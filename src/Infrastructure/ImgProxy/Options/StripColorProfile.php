<?php

declare(strict_types=1);

namespace App\Infrastructure\ImgProxy\Options;

final readonly class StripColorProfile extends AbstractOption
{
    public function __construct(
        private bool $strip = true,
    ) {
    }

    public static function name(): string
    {
        return 'scp';
    }

    /** @inheritDoc */
    public function data(): array
    {
        return [
            $this->strip ? 1 : 0,
        ];
    }
}
