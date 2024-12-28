<?php

declare(strict_types=1);

namespace App\Infrastructure\ImgProxy\Options;

use InvalidArgumentException;

use function sprintf;

final class Blur extends AbstractOption
{
    public function __construct(private float $sigma)
    {
        if ($sigma < 0) {
            throw new InvalidArgumentException(sprintf('Invalid blur: %s', $sigma));
        }
    }

    public static function name(): string
    {
        return 'bl';
    }

    /** @inheritDoc */
    public function data(): array
    {
        return [
            $this->sigma,
        ];
    }
}
