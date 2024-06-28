<?php

declare(strict_types=1);

use Pentatrion\ViteBundle\Asset\ViteAssetVersionStrategy;
use Symfony\Config\FrameworkConfig;

return static function (
    FrameworkConfig $frameworkConfig,
): void {
    $frameworkConfig
        ->assets()
            ->package('vite')
                ->versionStrategy(ViteAssetVersionStrategy::class);
};
