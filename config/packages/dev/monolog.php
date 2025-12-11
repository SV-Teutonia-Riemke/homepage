<?php

declare(strict_types=1);

use Symfony\Component\DependencyInjection\Loader\Configurator\App;

return App::config([
    'monolog' => [
        'handlers' => [
            'main' => [
                'type' => 'stream',
                'path' => '%kernel.logs_dir%/%kernel.environment%.log',
                'level' => 'warning',
                'channels' => [
                    '!event',
                ],
            ],
            'console' => [
                'type' => 'console',
                'process_psr_3_messages' => false,
                'channels' => [
                    '!event',
                    '!doctrine',
                    '!console',
                ],
            ],
            'deprecation' => [
                'type' => 'stream',
                'path' => '%kernel.logs_dir%/%kernel.environment%_deprecation.log',
                'channels' => [
                    'deprecation',
                ],
            ],
        ],
    ],
]);
