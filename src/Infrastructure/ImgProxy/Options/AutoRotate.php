<?php

declare(strict_types=1);

namespace App\Infrastructure\ImgProxy\Options;

final readonly class AutoRotate extends AbstractOption
{
    public function __construct(
        private bool $rotate = true,
    ) {
    }

    public static function name(): string
    {
        return 'ar';
    }

    /** @inheritDoc */
    public function data(): array
    {
        return [
            $this->rotate ? 1 : 0,
        ];
    }
}
