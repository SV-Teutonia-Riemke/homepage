<?php

declare(strict_types=1);

namespace App\Infrastructure\ImgProxy\Options;

use InvalidArgumentException;

final class Format extends AbstractOption
{
    public function __construct(private string $extension)
    {
        if ($extension === '') {
            throw new InvalidArgumentException('Format cannot be empty');
        }
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
