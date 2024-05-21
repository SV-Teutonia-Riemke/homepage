<?php

declare(strict_types=1);

use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symfony\Config\KnpMenuConfig;

return static function (KnpMenuConfig $config, ContainerConfigurator $containerConfigurator): void {
    $config->twig()->template('_partials/menu.html.twig');
    $config
        ->templating(false)
        ->defaultRenderer('twig');
};
