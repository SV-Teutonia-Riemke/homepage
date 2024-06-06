<?php

declare(strict_types=1);

use Symfony\Config\FrameworkConfig;

use function Symfony\Component\DependencyInjection\Loader\Configurator\env;

return static function (
    FrameworkConfig $frameworkConfig,
): void {
    $frameworkConfig->cache()
        ->app('cache.adapter.redis')
        ->defaultRedisProvider(env('REDIS_DSN')->string());
};
