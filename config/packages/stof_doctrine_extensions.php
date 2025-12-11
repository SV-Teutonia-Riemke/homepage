<?php

declare(strict_types=1);

use Symfony\Component\DependencyInjection\Loader\Configurator\App;

return App::config([
    'stof_doctrine_extensions' => [
        'default_locale' => 'de',
        'orm' => [
            'default' => [
                'sortable' => true,
            ],
        ],
    ],
]);
