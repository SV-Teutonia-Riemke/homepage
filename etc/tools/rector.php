<?php

declare(strict_types=1);

use Rector\Caching\ValueObject\Storage\FileCacheStorage;
use Rector\Config\RectorConfig;

$projectDir = dirname(__DIR__, 2);

return RectorConfig::configure()
    ->withPaths([
        $projectDir . '/config',
        $projectDir . '/public',
        $projectDir . '/src',
        $projectDir . '/apps',
        $projectDir . '/tests',
    ])
    ->withPHPStanConfigs([
        __DIR__ . '/phpstan.neon',
    ])
    ->withCache($projectDir . '/var/cache/rector', FileCacheStorage::class)
    ->withSymfonyContainerXml($projectDir . '/var/cache/test/App_KernelTestDebugContainer.xml')
    ->withPhpSets()
    ->withAttributesSets(
        symfony: true,
        doctrine: true,
    )
    ->withComposerBased(
        doctrine: true,
        phpunit: true,
        symfony: true,
    )
    ->withTypeCoverageLevel(50)
    ->withDeadCodeLevel(50)
    ->withCodeQualityLevel(50)
    ->withImportNames(removeUnusedImports: true)
    ->withSets([
        $projectDir . '/vendor/thecodingmachine/safe/rector-migrate.php',
    ])
    ->withRules([
//        StringExtensionToConfigBuilderRector::class,
    ]);
