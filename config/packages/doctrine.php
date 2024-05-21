<?php

declare(strict_types=1);

use App\Infrastructure\Doctrine\DBAL\Types\Type\DateType;
use App\Infrastructure\Doctrine\DBAL\Types\Type\YearGroupType;
use Shapecode\Doctrine\DBAL\Types\DateTimeUTCType;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symfony\Config\DoctrineConfig;
use Symfony\Config\FrameworkConfig;

use function Symfony\Component\DependencyInjection\Loader\Configurator\env;

return new class () {
    public function __invoke(
        DoctrineConfig $doctrineConfig,
        FrameworkConfig $frameworkConfig,
        ContainerConfigurator $containerConfigurator,
    ): void {
        $dbal = $doctrineConfig->dbal();
        $dbal->defaultConnection('default');
        $dbal->type('datetime')->class(DateTimeUTCType::class);
        $dbal->type('datetimeutc')->class(DateTimeUTCType::class);
        $dbal->type('date')->class(DateType::class);
        $dbal->type('year_group')->class(YearGroupType::class);

        $defaultConnection = $dbal->connection('default');
        $defaultConnection
            ->url(env('DATABASE_URL')->resolve())
            ->charset('utf8mb4')
            ->logging(false)
            ->defaultTableOption('charset', 'utf8mb4')
            ->defaultTableOption('collate', 'utf8mb4_unicode_ci')
            ->serverVersion('10.5.0-MariaDB');

        $orm = $doctrineConfig->orm();
        $orm
            ->autoGenerateProxyClasses(true)
            ->defaultEntityManager('default');

        $defaultEntityManager = $orm->entityManager('default');
        $defaultEntityManager->namingStrategy('doctrine.orm.naming_strategy.underscore_number_aware');
        $defaultEntityManager->autoMapping(true);
        $defaultEntityManager->mapping('App')
            ->isBundle(false)
            ->dir('%kernel.project_dir%/src/Storage/Entity')
            ->prefix('App\Storage\Entity')
            ->alias('App');

        if ($containerConfigurator->env() === 'test') {
            $defaultConnection->dbnameSuffix(sprintf('_test%s', env('TEST_TOKEN')->default('')));
        }

        if ($containerConfigurator->env() !== 'prod') {
            return;
        }

        $orm->autoGenerateProxyClasses(false);
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
    }
};
