<?php

declare(strict_types=1);

namespace App\Infrastructure\ImgProxy\Options;

use InvalidArgumentException;

use function array_merge;
use function array_values;
use function count;

final readonly class FormatQuality extends AbstractOption
{
    /** @var list<mixed> */
    private array $options;

    /** @param array<string, int<0, 100>> $options */
    public function __construct(array $options)
    {
        $normalizedOptions = [];

        foreach ($options as $format => $quality) {
            $data                = (new Quality($quality))->data();
            $normalizedOptions[] = [$format, ...$data];
        }

        if (count($normalizedOptions) === 0) {
            throw new InvalidArgumentException('At least one format quality must be set');
        }

        $this->options = $normalizedOptions;
    }

    public static function name(): string
    {
        return 'fq';
    }

    /** @inheritDoc */
    public function data(): array
    {
        return array_values(array_merge(...$this->options));
    }
}
