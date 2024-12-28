<?php

declare(strict_types=1);

namespace App\Infrastructure\ImgProxy\Preset;

use App\Infrastructure\ImgProxy\Options\AbstractOption;

use function array_values;

final readonly class Preset
{
    /** @param list<AbstractOption> $options */
    private function __construct(
        public array $options,
    ) {
    }

    public static function create(AbstractOption ...$options): self
    {
        return new self(array_values($options));
    }
}
