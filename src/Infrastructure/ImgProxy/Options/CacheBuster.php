<?php

declare(strict_types=1);

namespace App\Infrastructure\ImgProxy\Options;

use InvalidArgumentException;

final readonly class CacheBuster extends AbstractOption
{
    public function __construct(private string $value)
    {
        if ($value === '') {
            throw new InvalidArgumentException('Cache buster cannot be empty');
        }
    }

    public static function name(): string
    {
        return 'cb';
    }

    /** @inheritDoc */
    public function data(): array
    {
        return [
            $this->value,
        ];
    }
}
