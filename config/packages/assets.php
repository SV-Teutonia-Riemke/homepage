<?php

declare(strict_types=1);

use Pentatrion\ViteBundle\Asset\ViteAssetVersionStrategy;
use Symfony\Component\DependencyInjection\Loader\Configurator\App;

return App::config([
    'framework' => [
        'assets' => [
            'packages' => [
                'vite' => [
                    'version_strategy' => ViteAssetVersionStrategy::class,
                ],
            ],
        ],
    ],
]);
