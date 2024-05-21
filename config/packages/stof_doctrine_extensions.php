<?php

declare(strict_types=1);

use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symfony\Config\StofDoctrineExtensionsConfig;

return static function (StofDoctrineExtensionsConfig $config, ContainerConfigurator $containerConfigurator): void {
    $config
        ->defaultLocale('de')
        ->orm('default')->sortable(true);
};
