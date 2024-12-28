<?php

declare(strict_types=1);

namespace App\Infrastructure\ImgProxy\Options;

use InvalidArgumentException;

use function sprintf;

final class Dpr extends AbstractOption
{
    public function __construct(private int $dpr)
    {
        if ($dpr <= 0) {
            throw new InvalidArgumentException(sprintf('Invalid dpr: %s', $dpr));
        }
    }

    public static function name(): string
    {
        return 'dpr';
    }

    /** @inheritDoc */
    public function data(): array
    {
        return [
            $this->dpr,
        ];
    }
}
