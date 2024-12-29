<?php

declare(strict_types=1);

namespace App\Infrastructure\ImgProxy\Options;

use function array_unshift;
use function implode;
use function rtrim;

abstract readonly class AbstractOption implements OptionNamed
{
    public const string SEPARATOR = ':';

    /** @return list<mixed> */
    abstract public function data(): array;

    final public function __toString(): string
    {
        $data = $this->data();

        array_unshift($data, $this::name());

        // Remove empty options from end.
        return rtrim(
            implode(
                self::SEPARATOR,
                $data,
            ),
            self::SEPARATOR,
        );
    }
}
