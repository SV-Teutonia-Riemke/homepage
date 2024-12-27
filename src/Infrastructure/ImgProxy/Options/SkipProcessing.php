<?php

declare(strict_types=1);

namespace App\Infrastructure\ImgProxy\Options;

use InvalidArgumentException;

use function array_filter;

final class SkipProcessing extends AbstractOption
{
    /** @var string[] */
    private array $extensions;

    public function __construct(string ...$extensions)
    {
        $this->extensions = array_filter($extensions);

        if (empty($this->extensions)) {
            throw new InvalidArgumentException('At least one extension must be set');
        }
    }

    public function name(): string
    {
        return 'skp';
    }

    /** @inheritDoc */
    public function data(): array
    {
        return $this->extensions;
    }
}
