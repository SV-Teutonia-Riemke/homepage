<?php

declare(strict_types=1);

use Symfony\Component\DependencyInjection\Loader\Configurator\App;

return App::config([
    'presta_sitemap' => [
        'default_section' => 'default',
        'defaults' => [
            'priority' => 1,
            'changefreq' => 'daily',
            'lastmod' => 'now',
        ],
    ],
]);
