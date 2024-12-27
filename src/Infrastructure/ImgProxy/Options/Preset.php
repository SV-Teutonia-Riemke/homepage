<?php

declare(strict_types=1);

namespace App\Infrastructure\ImgProxy\Options;

use InvalidArgumentException;

use function array_filter;

final class Preset extends AbstractOption
{
    /** @var string[] */
    private array $presets;

    public function __construct(string ...$presets)
    {
        $this->presets = array_filter($presets);

        if (empty($this->presets)) {
            throw new InvalidArgumentException('At least one preset must be set');
        }
    }

    public function name(): string
    {
        return 'pr';
    }

    /** @inheritDoc */
    public function data(): array
    {
        return $this->presets;
    }
}
