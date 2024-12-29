<?php

declare(strict_types=1);

namespace App\Infrastructure\ImgProxy\Options\Builder;

use App\Infrastructure\ImgProxy\Options\Option;
use App\Infrastructure\ImgProxy\Options\Resize;
use App\Infrastructure\ImgProxy\Options\ResizingType;

use function is_string;

/** @extends AbstractBuilder<Resize> */
final class ResizeBuilder extends AbstractBuilder
{
    private ResizingType $type;

    /**
     * @param int<0, max>|null $width
     * @param int<0, max>|null $height
     */
    public function __construct(
        ResizingType|string $type,
        private int|null $width = null,
        private int|null $height = null,
        private bool|null $enlarge = null,
        private bool|null $extend = null,
    ) {
        $this->type = ResizingType::fromStringOrSelf($type);
    }

    public static function create(ResizingType|string $resizingType): self
    {
        return new self($resizingType);
    }

    /**
     * @param int<0, max>|null $width
     * @param int<0, max>|null $height
     */
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

    /** @param int<0, max> $width */
    public function width(int $width): self
    {
        $clone        = clone $this;
        $clone->width = $width;

        return $clone;
    }

    /** @param int<0, max> $height */
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

    public function build(): Option
    {
        return new Resize(
            $this->type,
            $this->width,
            $this->height,
            $this->enlarge,
            $this->extend,
        );
    }
}
