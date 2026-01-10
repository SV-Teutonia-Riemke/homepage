<?php

declare(strict_types=1);

use ShipMonk\ComposerDependencyAnalyser\Config\Configuration;
use ShipMonk\ComposerDependencyAnalyser\Config\ErrorType;

$config = new Configuration();

return $config
    // Adjusting scanned paths
    ->addPathsToScan([
        __DIR__ . '/../../bin',
        __DIR__ . '/../../public',
        __DIR__ . '/../../config',
    ], false)
    ->addPathToScan(__DIR__ . '/../../tests', true)

    ->ignoreUnknownFunctionsRegex('/Symfony\\\\Component\\\\DependencyInjection\\\\Loader\\\\Configurator\\\\.+/')

    // Ignoring errors on specific packages
    ->ignoreErrorsOnPackages([
        'symfony/apache-pack',
        'symfony/asset',
        'symfony/clock',
        'symfony/flex',
        'symfony/http-client',
        'symfony/psr-http-message-bridge',
        'symfony/runtime',
        'symfony/security-bundle',
        'symfony/security-csrf',
        'symfony/yaml',
        'twig/intl-extra',
        'twig/string-extra',
        'cweagans/composer-patches',
        'runtime/frankenphp-symfony'
    ], [ErrorType::UNUSED_DEPENDENCY])

    // ignore errors on packages that are only used in dev but found in prod. example in bundles.php
    ->ignoreErrorsOnPackages([
        'symfony/web-profiler-bundle',
    ], [ErrorType::DEV_DEPENDENCY_IN_PROD]);
