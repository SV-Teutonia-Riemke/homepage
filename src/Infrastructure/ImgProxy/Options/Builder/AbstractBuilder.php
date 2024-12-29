<?php

declare(strict_types=1);

namespace App\Infrastructure\ImgProxy\Options\Builder;

use App\Infrastructure\ImgProxy\Options\Option;

/**
 * @template T of Option
 * @implements Builder<T>
 */
abstract class AbstractBuilder implements Builder
{
    public function __toString(): string
    {
        return $this->build()->__toString();
    }
}
