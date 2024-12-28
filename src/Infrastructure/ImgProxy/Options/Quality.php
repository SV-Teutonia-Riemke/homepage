<?php

declare(strict_types=1);

namespace App\Infrastructure\ImgProxy\Options;

use InvalidArgumentException;

use function sprintf;

final class Quality extends AbstractOption
{
    public function __construct(private int $quality)
    {
        if ($quality < 0 || $quality > 100) {
            throw new InvalidArgumentException(sprintf('Invalid quality: %s', $quality));
        }
    }

    public static function name(): string
    {
        return 'q';
    }

    /** @inheritDoc */
    public function data(): array
    {
        return [
            $this->quality,
        ];
    }
}
