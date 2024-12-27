<?php

declare(strict_types=1);

namespace App\Infrastructure\ImgProxy\Options;

final class Expires extends AbstractOption
{
    public function __construct(private int $timestamp)
    {
    }

    public function name(): string
    {
        return 'exp';
    }

    /** @inheritDoc */
    public function data(): array
    {
        return [
            $this->timestamp,
        ];
    }
}
