<?php

declare(strict_types=1);

namespace App\Infrastructure\ImgProxy\Options;

use InvalidArgumentException;

use function array_merge;

final class FormatQuality extends AbstractOption
{
    /** @var list<mixed> */
    private array $options = [];

    /** @param array<string, int> $options */
    public function __construct(array $options)
    {
        foreach ($options as $format => $quality) {
            $data            = (new Quality($quality))->data();
            $this->options[] = [$format, ...$data];
        }

        if (empty($this->options)) {
            throw new InvalidArgumentException('At least one format quality must be set');
        }
    }

    public function name(): string
    {
        return 'fq';
    }

    /** @inheritDoc */
    public function data(): array
    {
        return array_merge(...$this->options);
    }
}
