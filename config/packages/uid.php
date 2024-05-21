<?php

declare(strict_types=1);

use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symfony\Config\FrameworkConfig;

return static function (FrameworkConfig $frameworkConfig, ContainerConfigurator $containerConfigurator): void {
    $frameworkConfig
        ->uid()
            ->defaultUuidVersion(7)
            ->timeBasedUuidVersion(7);
};
