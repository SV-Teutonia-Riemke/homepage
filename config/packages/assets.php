<?php

declare(strict_types=1);

use Pentatrion\ViteBundle\Asset\ViteAssetVersionStrategy;
use Symfony\Config\FrameworkConfig;

return static function (
    FrameworkConfig $frameworkConfig,
): void {
    $frameworkConfig
        ->assets()
//            ->jsonManifestPath('%kernel.project_dir%/public/build/manifest.json')
            ->package('vite')
                ->versionStrategy(ViteAssetVersionStrategy::class);
};
