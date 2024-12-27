<?php

declare(strict_types=1);

namespace App\Infrastructure\ImgProxy\Options;

final class ReturnAttachment extends AbstractOption
{
    public function __construct(private bool $value = true)
    {
    }

    public function name(): string
    {
        return 'att';
    }

    /** @inheritDoc */
    public function data(): array
    {
        return [
            (int) $this->value,
        ];
    }
}
