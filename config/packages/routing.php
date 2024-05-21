<?php

declare(strict_types=1);

use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symfony\Config\FrameworkConfig;

return static function (
    FrameworkConfig $config,
    ContainerConfigurator $containerConfigurator,
): void {
    $config->router()->utf8(true);

    if ($containerConfigurator->env() !== 'prod') {
        return;
    }

    $config->router()->strictRequirements(true);
};
