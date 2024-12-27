<?php

declare(strict_types=1);

namespace App\Infrastructure\ImgProxy\Options;

use InvalidArgumentException;

use function sprintf;

final class MaxBytes extends AbstractOption
{
    public function __construct(private int $bytes)
    {
        if ($bytes < 0) {
            throw new InvalidArgumentException(sprintf('Invalid max bytes: %s', $bytes));
        }
    }

    public function name(): string
    {
        return 'mb';
    }

    /** @inheritDoc */
    public function data(): array
    {
        return [
            $this->bytes,
        ];
    }
}
