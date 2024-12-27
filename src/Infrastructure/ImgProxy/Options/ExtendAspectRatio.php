<?php

declare(strict_types=1);

namespace App\Infrastructure\ImgProxy\Options;

final class ExtendAspectRatio extends AbstractOption
{
    private Extend $extend;

    public function __construct(
        bool $extend = true,
        string|null $gravity = null,
    ) {
        $this->extend = new Extend($extend, $gravity);
    }

    public function name(): string
    {
        return 'exar';
    }

    /** @inheritDoc */
    public function data(): array
    {
        return $this->extend->data();
    }
}
