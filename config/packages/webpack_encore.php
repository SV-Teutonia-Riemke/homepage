<?php

declare(strict_types=1);

use Symfony\Config\FrameworkConfig;
use Symfony\Config\WebpackEncoreConfig;

return static function (
    WebpackEncoreConfig $webpackEncoreConfig,
    FrameworkConfig $frameworkConfig,
): void {
    $webpackEncoreConfig
        ->outputPath('%kernel.project_dir%/public/build')
        ->scriptAttributes('defer', true)
        ->scriptAttributes('data-turbo-track', 'reload')
        ->linkAttributes('data-turbo-track', 'reload');

    $frameworkConfig
        ->assets()
            ->jsonManifestPath('%kernel.project_dir%/public/build/manifest.json');
};
