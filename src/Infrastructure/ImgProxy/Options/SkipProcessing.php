<?php

declare(strict_types=1);

namespace App\Infrastructure\ImgProxy\Options;

use InvalidArgumentException;

use function array_values;
use function count;

final class SkipProcessing extends AbstractOption
{
    /** @var list<string> */
    private array $extensions;

    public function __construct(string ...$extensions)
    {
        $this->extensions = array_values($extensions);

        if (count($this->extensions) === 0) {
            throw new InvalidArgumentException('At least one extension must be set');
        }
    }

    public static function name(): string
    {
        return 'skp';
    }

    /** @inheritDoc */
    public function data(): array
    {
        return $this->extensions;
    }
}
