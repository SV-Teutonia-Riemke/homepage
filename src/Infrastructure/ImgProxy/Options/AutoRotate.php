<?php

declare(strict_types=1);

namespace App\Infrastructure\ImgProxy\Options;

final class AutoRotate extends AbstractOption
{
    public function __construct(private bool $rotate = true)
    {
    }

    public function name(): string
    {
        return 'ar';
    }

    /** @inheritDoc */
    public function data(): array
    {
        return [
            (int) $this->rotate,
        ];
    }
}
