<?php

declare(strict_types=1);

namespace App\Infrastructure\Config;

use App\Storage\Entity\ConfigSetting;
use App\Storage\Repository\ConfigSettingRepository;
use Psr\Log\LoggerInterface;

final class ConfigProvider
{
    public function __construct(
        private readonly ConfigSettingRepository $configSettingRepository,
        private readonly LoggerInterface $logger,
    ) {
    }

    public function get(string $name): string|null
    {
        $setting = $this->configSettingRepository->findOneBy([
            'name' => $name,
        ]);

        if ($setting === null) {
            $this->logger->info('Config does not exist', [
                'config' => $name,
            ]);

            return null;
        }

        return $setting->getValue();
    }

    /** @return array<string, string|null> */
    public function all(): array
    {
        return $this->getAsNamesAndValues(...$this->configSettingRepository->findAll());
    }

    /** @return array<string, string|null> */
    private function getAsNamesAndValues(ConfigSetting ...$settings): array
    {
        $result = [];

        foreach ($settings as $setting) {
            $result[$setting->getName()] = $setting->getValue();
        }

        return $result;
    }
}
