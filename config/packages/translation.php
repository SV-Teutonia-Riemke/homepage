<?php

declare(strict_types=1);

use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symfony\Config\FrameworkConfig;

return static function (FrameworkConfig $config, ContainerConfigurator $containerConfigurator): void {
    $config
        ->defaultLocale('de')
        ->translator()
            ->defaultPath('%kernel.project_dir%/translations')
            ->fallbacks(['de']);
};
