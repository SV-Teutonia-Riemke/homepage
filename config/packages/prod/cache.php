<?php

declare(strict_types=1);

use Symfony\Component\DependencyInjection\Loader\Configurator\App;
use Symfony\Component\DependencyInjection\Loader\Configurator\EnvConfigurator;

return App::config([
    'framework' => [
        'cache' => [
            'app' => 'cache.adapter.redis',
            'default_redis_provider' => new EnvConfigurator('REDIS_DSN')->string(),
        ],
    ],
]);
