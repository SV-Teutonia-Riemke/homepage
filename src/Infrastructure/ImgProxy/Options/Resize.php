<?php

declare(strict_types=1);

namespace App\Infrastructure\ImgProxy\Options;

use function array_merge;

final class Resize extends AbstractOption
{
    private ResizingType $type;

    private Size|null $size = null;

    public function __construct(
        string $type,
        int|null $width = null,
        int|null $height = null,
        bool|null $enlarge = null,
        bool|null $extend = null,
    ) {
        $this->type = new ResizingType($type);

        $leastOnOf = $width ?? $height ?? $enlarge ?? $extend;
        if ($leastOnOf === null) {
            return;
        }

        $this->size = new Size($width, $height, $enlarge, $extend);
    }

    public function name(): string
    {
        return 'rs';
    }

    /** @inheritDoc */
    public function data(): array
    {
        return array_merge(
            $this->type->data(),
            $this->size ? $this->size->data() : [],
        );
    }
}
