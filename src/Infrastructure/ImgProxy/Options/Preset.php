<?php

declare(strict_types=1);

namespace App\Infrastructure\ImgProxy\Options;

use InvalidArgumentException;

use function array_values;
use function count;

final class Preset extends AbstractOption
{
    /** @var list<string> */
    private array $presets;

    public function __construct(string ...$presets)
    {
        $this->presets = array_values($presets);

        if (count($this->presets) === 0) {
            throw new InvalidArgumentException('At least one preset must be set');
        }
    }

    public static function name(): string
    {
        return 'pr';
    }

    /** @inheritDoc */
    public function data(): array
    {
        return $this->presets;
    }
}
