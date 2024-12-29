<?php

declare(strict_types=1);

namespace App\Infrastructure\ImgProxy\Options;

use App\Infrastructure\ImgProxy\Domain\Color;

final readonly class Background extends AbstractOption
{
    private Color $color;

    public function __construct(
        Color|string $color,
    ) {
        $this->color = Color::fromStringOrSelf($color);
    }

    public static function fromString(string $hexColor): self
    {
        return new self(Color::fromString($hexColor));
    }

    public static function name(): string
    {
        return 'bg';
    }

    /** @inheritDoc */
    public function data(): array
    {
        return [
            $this->color->color,
        ];
    }
}
