<?php

declare(strict_types=1);

namespace App\Infrastructure\ImgProxy\Options;

final readonly class Format extends AbstractOption
{
    /** @param non-empty-string $extension */
    public function __construct(private string $extension)
    {
    }

    public static function name(): string
    {
        return 'f';
    }

    /** @inheritDoc */
    public function data(): array
    {
        return [
            $this->extension,
        ];
    }
}
