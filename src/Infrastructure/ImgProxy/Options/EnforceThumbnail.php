<?php

declare(strict_types=1);

namespace App\Infrastructure\ImgProxy\Options;

final readonly class EnforceThumbnail extends AbstractOption
{
    public function __construct(private string|null $format = null)
    {
    }

    public static function name(): string
    {
        return 'eth';
    }

    /** @inheritDoc */
    public function data(): array
    {
        return [
            $this->format ?? true,
        ];
    }
}
