<?php

declare(strict_types=1);

namespace App\Infrastructure\ImgProxy\Options;

use function array_merge;

final readonly class Resize extends AbstractOption
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
