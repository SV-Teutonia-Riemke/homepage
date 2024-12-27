<?php

declare(strict_types=1);

namespace App\Infrastructure\ImgProxy\Options;

use InvalidArgumentException;

final class CacheBuster extends AbstractOption
{
    public function __construct(private string $value)
    {
        if (empty($value)) {
            throw new InvalidArgumentException('Cache buster cannot be empty');
        }
    }

    public function name(): string
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
