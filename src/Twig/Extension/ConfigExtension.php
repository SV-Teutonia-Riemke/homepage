<?php

declare(strict_types=1);

namespace App\Twig\Extension;

use App\Infrastructure\Config\ConfigProvider;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

final class ConfigExtension extends AbstractExtension
{
    public function __construct(
        private readonly ConfigProvider $configProvider,
    ) {
    }

    /** @inheritDoc */
    public function getFunctions(): array
    {
        return [
            new TwigFunction('config_get', $this->configProvider->get(...)),
            new TwigFunction('config_has', $this->configProvider->has(...)),
        ];
    }
}
