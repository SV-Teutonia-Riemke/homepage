<?php

declare(strict_types=1);

namespace App\Infrastructure\ImgProxy\Options;

final readonly class ReturnAttachment extends AbstractOption
{
    public function __construct(
        private bool $value = true,
    ) {
    }

    public static function name(): string
    {
        return 'att';
    }

    /** @inheritDoc */
    public function data(): array
    {
        return [
            $this->value ? 1 : 0,
        ];
    }
}
