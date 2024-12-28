<?php

declare(strict_types=1);

namespace App\Infrastructure\ImgProxy\Options;

use InvalidArgumentException;

use function sprintf;

final class Height extends AbstractOption
{
    public function __construct(public readonly int $height)
    {
        if ($height < 0) {
            throw new InvalidArgumentException(sprintf('Invalid height: %s', $height));
        }
    }

    public static function name(): string
    {
        return 'h';
    }

    /** @inheritDoc */
    public function data(): array
    {
        return [
            $this->height,
        ];
    }
}
