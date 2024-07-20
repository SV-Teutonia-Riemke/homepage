<?php

declare(strict_types=1);

use App\Infrastructure\Doctrine\DBAL\Types\Type\DateType;
use App\Infrastructure\Doctrine\DBAL\Types\Type\YearGroupType;
use Shapecode\Doctrine\DBAL\Types\DateTimeUTCType;
use Symfony\Config\DoctrineConfig;

use function Symfony\Component\DependencyInjection\Loader\Configurator\env;

return static function (
    DoctrineConfig $doctrineConfig,
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
        ->serverVersion('11.4.0-MariaDB');

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
};
