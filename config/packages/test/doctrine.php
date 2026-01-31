<?php

declare(strict_types=1);

use Symfony\Component\DependencyInjection\Loader\Configurator\App;
use Symfony\Component\DependencyInjection\Loader\Configurator\EnvConfigurator;

return App::config([
    'doctrine' => [
        'dbal' => [
            'default_connection' => 'default',
            'connections' => [
                'default' => [
                    'dbname_suffix' => sprintf(
                        '_test%s',
                        new EnvConfigurator('TEST_TOKEN')->default(''),
                    ),
                ],
            ],
        ],
    ],
]);
