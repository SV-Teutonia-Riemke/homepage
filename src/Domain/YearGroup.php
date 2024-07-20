<?php

declare(strict_types=1);

namespace App\Domain;

use RuntimeException;
use Stringable;

use function sprintf;
use function sscanf;

final class YearGroup implements Stringable
{
    private const FORMAT = '%d-%d';

    public function __construct(
        public readonly int $start,
        public readonly int $end,
    ) {
        if ($this->start > $this->end) {
            throw new RuntimeException(
                sprintf(
                    'Unable to create year group from years "%d" and "%d". Format must be "%s".',
                    $this->start,
                    $this->end,
                    self::FORMAT,
                ),
                1666202507743,
            );
        }
    }

    public static function fromString(string $string): self
    {
        [$start, $end] = sscanf($string, self::FORMAT);

        return self::fromYears($start, $end);
    }

    public static function fromYears(
        int $start,
        int $end,
    ): self {
        return new self($start, $end);
    }

    public function getDisplayName(): string
    {
        return sprintf('%d / %d', $this->start, $this->end);
    }

    public function __toString(): string
    {
        return sprintf(self::FORMAT, $this->start, $this->end);
    }
}
