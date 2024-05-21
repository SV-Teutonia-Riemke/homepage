<?php

declare(strict_types=1);

use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symfony\Config\UxIconsConfig;

return static function (UxIconsConfig $uxIconsConfig, ContainerConfigurator $containerConfigurator): void {
    $uxIconsConfig->defaultIconAttributes([
        'height' => '1.25em',
        'width' => '1.25em',
    ]);
};
