<?php

declare(strict_types=1);

namespace App\Infrastructure\ImgProxy\Options;

final readonly class KeepCopyright extends AbstractOption
{
    public function __construct(private bool $keep = true)
    {
    }

    public static function name(): string
    {
        return 'kcr';
    }

    /** @inheritDoc */
    public function data(): array
    {
        return [
            $this->keep ? 1 : 0,
        ];
    }
}
