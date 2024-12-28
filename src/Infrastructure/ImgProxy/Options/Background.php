<?php

declare(strict_types=1);

namespace App\Infrastructure\ImgProxy\Options;

use App\Infrastructure\ImgProxy\Support\Color;

use function is_string;

final class Background extends AbstractOption
{
    private Color $color;

    public function __construct(Color|string $color)
    {
        $this->color = is_string($color) ? new Color($color) : $color;
    }

    public static function fromHex(string $hexColor): self
    {
        return new self(Color::fromHex($hexColor));
    }

    public static function name(): string
    {
        return 'bg';
    }

    /** @inheritDoc */
    public function data(): array
    {
        return [
            $this->color->value(),
        ];
    }
}
