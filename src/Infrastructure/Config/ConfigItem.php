<?php

declare(strict_types=1);

namespace App\Infrastructure\Config;

final class ConfigItem
{
    /** @param array<string, mixed> $formOptions */
    public function __construct(
        public readonly string $name,
        public readonly string $formType,
        public readonly array $formOptions = [],
    ) {
    }
}
