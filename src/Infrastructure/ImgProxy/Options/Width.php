<?php

declare(strict_types=1);

namespace App\Infrastructure\ImgProxy\Options;

use InvalidArgumentException;

use function sprintf;

final class Width extends AbstractOption
{
    public function __construct(
        public readonly int $width,
    ) {
        if ($width < 0) {
            throw new InvalidArgumentException(sprintf('Invalid width: %s', $width));
        }
    }

    public static function name(): string
    {
        return 'w';
    }

    /** @inheritDoc */
    public function data(): array
    {
        return [
            $this->width,
        ];
    }
}
