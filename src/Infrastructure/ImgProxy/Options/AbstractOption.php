<?php

declare(strict_types=1);

namespace App\Infrastructure\ImgProxy\Options;

use Stringable;

use function array_unshift;
use function implode;
use function rtrim;

abstract class AbstractOption implements Stringable
{
    private const string SEPARATOR = ':';

    abstract public static function name(): string;

    /** @return list<mixed> */
    abstract public function data(): array;

    final public function value(): string
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

    public function __toString(): string
    {
        return $this->value();
    }
}
