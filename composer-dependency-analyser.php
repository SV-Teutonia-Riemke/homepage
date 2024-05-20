<?php

declare(strict_types=1);

use ShipMonk\ComposerDependencyAnalyser\Config\Configuration;
use ShipMonk\ComposerDependencyAnalyser\Config\ErrorType;

$config = new Configuration();

return $config
    // Adjusting scanned paths
    ->addPathsToScan([
        __DIR__ . '/bin',
        __DIR__ . '/public',
        __DIR__ . '/src',
        __DIR__ . '/config',
    ], false)
    ->addPathToScan(__DIR__ . '/tests', true)

    // applies only to directory scanning, not directly listed files
    ->setFileExtensions(['php'])

    // Ignoring errors on specific packages
    ->ignoreErrorsOnPackages([
        'symfony/apache-pack',
        'symfony/asset',
        'symfony/flex',
        'symfony/http-client',
        'symfony/mime',
        'symfony/psr-http-message-bridge',
        'symfony/runtime',
        'symfony/security-csrf',
        'symfony/yaml',
        'twig/intl-extra',
        'twig/string-extra',
        'nyholm/psr7',
    ], [ErrorType::UNUSED_DEPENDENCY])

    // ignore errors on packages that are only used in dev but found in prod. example in bundles.php
    ->ignoreErrorsOnPackages([
        'symfony/web-profiler-bundle',
    ], [ErrorType::DEV_DEPENDENCY_IN_PROD]);
