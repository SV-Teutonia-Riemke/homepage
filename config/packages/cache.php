<?php

declare(strict_types=1);

use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symfony\Config\FrameworkConfig;

use function Symfony\Component\DependencyInjection\Loader\Configurator\env;

return static function (FrameworkConfig $frameworkConfig, ContainerConfigurator $containerConfigurator): void {
    if ($containerConfigurator->env() !== 'prod') {
        return;
    }

    $frameworkConfig->cache()
        ->app('cache.adapter.redis')
        ->defaultRedisProvider(env('REDIS_DSN')->string());
};
