<?php

declare(strict_types=1);

namespace App\Infrastructure\Config;

final class ConfigProvider
{
    public function __construct(
        private readonly ConfigSettingProvider $configSettingProvider,
    ) {
    }

    public function get(string $name): string|null
    {
        return $this->configSettingProvider->get($name)->getValue();
    }

    public function has(string $name): bool
    {
        return $this->get($name) !== null;
    }
}
