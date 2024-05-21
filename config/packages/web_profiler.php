<?php

declare(strict_types=1);

use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symfony\Config\FrameworkConfig;
use Symfony\Config\WebProfilerConfig;

return static function (
    WebProfilerConfig $webProfilerConfig,
    FrameworkConfig $frameworkConfig,
    ContainerConfigurator $containerConfigurator,
): void {
    if ($containerConfigurator->env() === 'dev') {
        $webProfilerConfig
            ->toolbar(true)
            ->interceptRedirects(false);

        $frameworkConfig->profiler()
            ->onlyExceptions(false)
            ->collectSerializerData(true);
    }

    if ($containerConfigurator->env() !== 'test') {
        return;
    }

    $webProfilerConfig
        ->toolbar(false)
        ->interceptRedirects(false);

    $frameworkConfig->profiler()
        ->collect(false);
};
