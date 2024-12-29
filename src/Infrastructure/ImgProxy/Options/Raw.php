<?php

declare(strict_types=1);

namespace App\Infrastructure\ImgProxy\Options;

final readonly class Raw extends AbstractOption
{
    public function __construct(
        private bool $raw = true,
    ) {
    }

    public static function name(): string
    {
        return 'raw';
    }

    /** @inheritDoc */
    public function data(): array
    {
        return [
            $this->raw ? 1 : 0,
        ];
    }
}
