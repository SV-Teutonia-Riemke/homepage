<?php

declare(strict_types=1);

namespace App\Twig\Extension;

use App\Infrastructure\Config\ConfigProvider;
use Twig\Attribute\AsTwigFunction;

final readonly class ConfigExtension
{
    public function __construct(
        private ConfigProvider $configProvider,
    ) {
    }

    #[AsTwigFunction('config_get')]
    public function configGet(string $name): mixed
    {
        return $this->configProvider->get($name);
    }

    #[AsTwigFunction('config_has')]
    public function hasConfig(string $name): bool
    {
        return $this->configProvider->has($name);
    }
}
