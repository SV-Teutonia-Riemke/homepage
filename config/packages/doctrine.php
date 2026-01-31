<?php

declare(strict_types=1);

use App\Infrastructure\Doctrine\DBAL\Types\Type\DateType;
use App\Infrastructure\Doctrine\DBAL\Types\Type\YearGroupType;
use Shapecode\Doctrine\DBAL\Types\DateTimeUTCType;
use Symfony\Component\DependencyInjection\Loader\Configurator\App;
use Symfony\Component\DependencyInjection\Loader\Configurator\EnvConfigurator;

return App::config([
    'doctrine' => [
        'dbal' => [
            'default_connection' => 'default',
            'types' => [
                'datetime' => DateTimeUTCType::class,
                'datetimeutc' => DateTimeUTCType::class,
                'date' => DateType::class,
                'year_group' => YearGroupType::class,
            ],
            'connections' => [
                'default' => [
                    'url' => new EnvConfigurator('DATABASE_URL')->resolve(),
                    'charset' => 'utf8mb4',
                    'logging' => false,
                    'default_table_options' => [
                        'charset' => 'utf8mb4',
                        'collate' => 'utf8mb4_unicode_ci',
                    ],
                    'server_version' => '11.4.0-MariaDB',
                ],
            ],
        ],
        'orm' => [
            'default_entity_manager' => 'default',
            'entity_managers' => [
                'default' => [
                    'naming_strategy' => 'doctrine.orm.naming_strategy.underscore_number_aware',
                    'auto_mapping' => true,
                    'mappings' => [
                        'App' => [
                            'is_bundle' => false,
                            'dir' => '%kernel.project_dir%/src/Storage/Entity',
                            'prefix' => 'App\Storage\Entity',
                            'alias' => 'App',
                        ],
                    ],
                ],
            ],
        ],
    ],
]);
