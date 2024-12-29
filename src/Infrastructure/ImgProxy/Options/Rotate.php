<?php

declare(strict_types=1);

namespace App\Infrastructure\ImgProxy\Options;

use InvalidArgumentException;

use function sprintf;

final readonly class Rotate extends AbstractOption
{
    /** @param int<0, 360> $angle */
    public function __construct(private int $angle)
    {
        if ($angle % 90 !== 0) {
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
