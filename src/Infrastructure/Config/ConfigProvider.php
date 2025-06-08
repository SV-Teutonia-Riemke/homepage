<?php

declare(strict_types=1);

namespace App\Infrastructure\Config;

final readonly class ConfigProvider
{
    public function __construct(
        private ConfigSettingProvider $configSettingProvider,
    ) {
    }

    public function get(string $name): mixed
    {
        return $this->configSettingProvider->get($name)->getValue();
    }

    public function has(string $name): bool
    {
        return $this->get($name) !== null;
    }
}
