<?php

declare(strict_types=1);

use Symfony\Component\DependencyInjection\Loader\Configurator\App;

return App::config([
    'doctrine' => [
        'orm' => [
            'default_entity_manager' => 'default',
            'entity_managers' => [
                'default' => [
                    'query_cache_driver' => [
                        'type' => 'pool',
                        'pool' => 'doctrine.system_cache_pool',
                    ],
                    'result_cache_driver' => [
                        'type' => 'pool',
                        'pool' => 'doctrine.system_cache_pool',
                    ],
                ],
            ],
        ],
    ],
    'framework' => [
        'cache' => [
            'pools' => [
                'doctrine.result_cache_pool' => [
                    'adapters' => 'cache.app',
                ],
                'doctrine.system_cache_pool' => [
                    'adapters' => 'cache.system',
                ],
            ],
        ],
    ],
]);
