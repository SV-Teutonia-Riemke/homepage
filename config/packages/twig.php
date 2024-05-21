<?php

declare(strict_types=1);

use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symfony\Config\TwigConfig;

return static function (TwigConfig $twigConfig, ContainerConfigurator $containerConfigurator): void {
    $twigConfig
        ->defaultPath('%kernel.project_dir%/templates')
        ->path('%kernel.project_dir%/src/Module/Admin/Templates', 'admin')
        ->path('%kernel.project_dir%/src/Module/Page/Templates', 'page')
        ->formThemes([
            'bootstrap_5_layout.html.twig',
        ]);

    if ($containerConfigurator->env() !== 'test') {
        return;
    }

    $twigConfig->strictVariables(true);
};
