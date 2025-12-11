<?php

declare(strict_types=1);

use Symfony\Component\DependencyInjection\Loader\Configurator\App;

return App::config([
    'framework' => [
        'default_locale' => 'de',
        'translator' => [
            'default_path' => '%kernel.project_dir%/translations',
            'fallbacks' => ['de'],
        ],
    ],
]);
