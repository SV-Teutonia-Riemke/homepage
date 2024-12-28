<?php

declare(strict_types=1);

namespace App\Infrastructure\ImgProxy\Options;

use InvalidArgumentException;

use function sprintf;

final class Rotate extends AbstractOption
{
    public function __construct(private int $angle)
    {
        if ($angle < 0 || $angle % 90 !== 0) {
            throw new InvalidArgumentException(sprintf('Invalid angle: %s', $angle));
        }
    }

    public static function name(): string
    {
        return 'rot';
    }

    /** @inheritDoc */
    public function data(): array
    {
        return [
            $this->angle,
        ];
    }
}
