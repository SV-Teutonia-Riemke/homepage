<?php

declare(strict_types=1);

namespace App\Infrastructure\Config;

use App\Storage\Entity\ConfigSetting;
use App\Storage\Repository\ConfigSettingRepository;

use function array_key_exists;

final class ConfigSettingProvider
{
    /** @var array<string, ConfigSetting>|null */
    private array|null $all = null;

    private ConfigItemCollection $items;

    public function __construct(
        private readonly ConfigSettingRepository $configSettingRepository,
        ConfigBuilder $configBuilder,
    ) {
        $this->items = $configBuilder->build()->getAllItems();
    }

    public function get(string $name): ConfigSetting
    {
        if (! $this->items->has($name)) {
            return new ConfigSetting($name);
        }

        $all = $this->all();

        if (! array_key_exists($name, $all)) {
            return new ConfigSetting(
                $name,
                $this->items->get($name)->default,
            );
        }

        return $all[$name];
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
