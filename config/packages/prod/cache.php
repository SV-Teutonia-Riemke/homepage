<?php

declare(strict_types=1);

use Symfony\Component\DependencyInjection\Loader\Configurator\App;

use function Symfony\Component\DependencyInjection\Loader\Configurator\env;

return App::config([
    'framework' => [
        'cache' => [
            'app' => 'cache.adapter.redis',
            'default_redis_provider' => env('REDIS_DSN')->string(),
        ],
    ],
]);
