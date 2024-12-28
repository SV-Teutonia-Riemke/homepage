<?php

declare(strict_types=1);

namespace App\Infrastructure\ImgProxy\Options;

use function array_merge;
use function is_string;

final class Resize extends AbstractOption
{
    private ResizingType $type;

    public function __construct(
        ResizingType|string $type,
        private int|null $width = null,
        private int|null $height = null,
        private bool|null $enlarge = null,
        private bool|null $extend = null,
    ) {
        $this->type = is_string($type) ? new ResizingType($type) : $type;
    }

    public static function create(ResizingType|string $resizingType): self
    {
        return new self($resizingType);
    }

    public function with(
        ResizingType|string|null $type = null,
        int|null $width = null,
        int|null $height = null,
        bool|null $enlarge = null,
        bool|null $extend = null,
    ): self {
        $clone = clone $this;

        if ($type !== null) {
            $clone->type = is_string($type) ? new ResizingType($type) : $type;
        }

        if ($width !== null) {
            $clone->width = $width;
        }

        if ($height !== null) {
            $clone->height = $height;
        }

        if ($enlarge !== null) {
            $clone->enlarge = $enlarge;
        }

        if ($extend !== null) {
            $clone->extend = $extend;
        }

        return $clone;
    }

    public function width(int $width): self
    {
        $clone        = clone $this;
        $clone->width = $width;

        return $clone;
    }

    public function height(int $height): self
    {
        $clone         = clone $this;
        $clone->height = $height;

        return $clone;
    }

    public function enlarge(bool $enlarge = true): self
    {
        $clone          = clone $this;
        $clone->enlarge = $enlarge;

        return $clone;
    }

    public function extend(bool $extend = true): self
    {
        $clone         = clone $this;
        $clone->extend = $extend;

        return $clone;
    }

    public static function name(): string
    {
        return 'rs';
    }

    /** @inheritDoc */
    public function data(): array
    {
        $leastOnOf = $this->width ?? $this->height ?? $this->enlarge ?? $this->extend;

        $size = $leastOnOf === null ? null : new Size($this->width, $this->height, $this->enlarge, $this->extend);

        return array_merge(
            $this->type->data(),
            $size?->data() ?? [],
        );
    }
}
