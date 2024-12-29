<?php

declare(strict_types=1);

namespace App\Infrastructure\ImgProxy\Options\Builder;

use App\Infrastructure\ImgProxy\Options\Option;

/** @template T of Option */
interface Builder extends Option
{
    /** @phpstan-return T */
    public function build(): Option;
}
