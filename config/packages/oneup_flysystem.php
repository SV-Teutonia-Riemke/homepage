<?php

declare(strict_types=1);

use League\Flysystem\Filesystem;
use Symfony\Component\DependencyInjection\Loader\Configurator\App;

return App::config([
    'oneup_flysystem' => [
        'adapters' => [
            'default_adapter' => [
                'local' => [
                    'location' => '%kernel.project_dir%/var/flysystem',
                ],
            ],
        ],
        'filesystems' => [
            'default_filesystem' => [
                'adapter' => 'default_adapter',
                'alias' => Filesystem::class,
            ],
        ],
    ],
]);
