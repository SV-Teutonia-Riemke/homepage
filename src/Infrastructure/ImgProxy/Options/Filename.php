<?php

declare(strict_types=1);

namespace App\Infrastructure\ImgProxy\Options;

final readonly class Filename extends AbstractOption
{
    /** @param non-empty-string $name */
    public function __construct(private string $name)
    {
    }

    public static function name(): string
    {
        return 'fn';
    }

    /** @inheritDoc */
    public function data(): array
    {
        return [
            $this->name,
        ];
    }
}
