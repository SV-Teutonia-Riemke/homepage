<?php

declare(strict_types=1);

namespace App\Infrastructure\ImgProxy\Options;

use InvalidArgumentException;

final class Padding extends AbstractOption
{
    public function __construct(
        private int|null $top = null,
        private int|null $right = null,
        private int|null $bottom = null,
        private int|null $left = null,
    ) {
        $leastOnOf = $top ?? $right ?? $bottom ?? $left;
        if ($leastOnOf === null) {
            throw new InvalidArgumentException('At least one dimension must be set');
        }
    }

    public static function all(int $value): self
    {
        return new self($value, $value, $value, $value);
    }

    public static function xy(
        int $x,
        int $y,
    ): self {
        return new self($y, $x, $y, $x);
    }

    public static function name(): string
    {
        return 'pd';
    }

    /** @inheritDoc */
    public function data(): array
    {
        return [
            $this->top,
            $this->right,
            $this->bottom,
            $this->left,
        ];
    }
}
