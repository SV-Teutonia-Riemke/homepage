<?php

declare(strict_types=1);

use Symfony\Config\DoctrineConfig;
use Symfony\Config\FrameworkConfig;

return static function (
    DoctrineConfig $doctrineConfig,
    FrameworkConfig $frameworkConfig,
): void {
    $orm = $doctrineConfig->orm();

    $defaultEntityManager = $orm->entityManager('default');
    $defaultEntityManager
        ->queryCacheDriver()
        ->type('pool')
        ->pool('doctrine.system_cache_pool');

    $defaultEntityManager
        ->resultCacheDriver()
        ->type('pool')
        ->pool('doctrine.result_cache_pool');

    $frameworkConfig->cache()->pool('doctrine.result_cache_pool')->adapters('cache.app');
    $frameworkConfig->cache()->pool('doctrine.system_cache_pool')->adapters('cache.system');
};
