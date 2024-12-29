<?php

declare(strict_types=1);

namespace App\Infrastructure\ImgProxy\Options;

use function array_merge;

final readonly class Extend extends AbstractOption
{
    private Gravity|null $gravity;

    public function __construct(
        private bool $extend = true,
        Gravity|string|null $gravity = null,
    ) {
        $this->gravity = Gravity::fromMixed($gravity);
    }

    public static function name(): string
    {
        return 'ex';
    }

    /** @inheritDoc */
    public function data(): array
    {
        return array_merge(
            [$this->extend ? 1 : 0],
            $this->gravity?->data() ?? [],
        );
    }
}
