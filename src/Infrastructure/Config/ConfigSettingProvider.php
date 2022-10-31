<?php

declare(strict_types=1);

namespace App\Infrastructure\Config;

use App\Storage\Entity\ConfigSetting;
use App\Storage\Repository\ConfigSettingRepository;

final class ConfigSettingProvider
{
    /** @var array<string, ConfigSetting>|null */
    private array|null $all = null;

    public function __construct(
        private readonly ConfigSettingRepository $configSettingRepository,
    ) {
    }

    public function get(string $name): ConfigSetting
    {
        $all     = $this->all();
        $setting = $all[$name] ?? null;

        if ($setting === null) {
            $setting = new ConfigSetting($name);
        }

        return $setting;
    }

    /** @return array<string, ConfigSetting> */
    private function all(): array
    {
        if ($this->all === null) {
            $this->all = $this->getAsNamesAndValues(...$this->configSettingRepository->findAll());
        }

        return $this->all;
    }

    /** @return array<string, ConfigSetting> */
    private function getAsNamesAndValues(ConfigSetting ...$settings): array
    {
        $result = [];

        foreach ($settings as $setting) {
            $result[$setting->getName()] = $setting;
        }

        return $result;
    }
}
