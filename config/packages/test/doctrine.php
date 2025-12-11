<?php

declare(strict_types=1);

use Symfony\Component\DependencyInjection\Loader\Configurator\App;

use function Symfony\Component\DependencyInjection\Loader\Configurator\env;

return App::config([
    'doctrine' => [
        'dbal' => [
            'default_connection' => 'default',
            'connections' => [
                'default' => [
                    'dbname_suffix' => sprintf(
                        '_test%s',
                        env('TEST_TOKEN')->default(''),
                    ),
                ],
            ],
        ],
    ],
]);
