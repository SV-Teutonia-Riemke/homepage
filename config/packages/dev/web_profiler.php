<?php

declare(strict_types=1);

use Symfony\Component\DependencyInjection\Loader\Configurator\App;

return App::config([
    'framework' => [
        'profiler' => [
            'only_exceptions' => false,
            'collect' => true,
        ],
    ],
    'web_profiler' => [
        'toolbar' => [
            'enabled' => true,
            'ajax_replace' => true,
        ],
        'intercept_redirects' => false,
    ],
]);
