<?php

declare(strict_types=1);

namespace App\Infrastructure\ImgProxy\Options;

use function array_merge;
use function is_string;

final class Extend extends AbstractOption
{
    private Gravity|null $gravity = null;

    public function __construct(
        private bool $extend = true,
        Gravity|string|null $gravity = null,
    ) {
        $this->gravity = is_string($gravity) ? Gravity::fromString($gravity) : $gravity;
    }

    public function name(): string
    {
        return 'ex';
    }

    /** @inheritDoc */
    public function data(): array
    {
        return array_merge(
            [(int) $this->extend],
            $this->gravity ? $this->gravity->data() : [],
        );
    }
}
