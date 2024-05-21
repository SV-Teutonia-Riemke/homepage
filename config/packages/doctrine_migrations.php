<?php

declare(strict_types=1);

use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symfony\Config\DoctrineMigrationsConfig;

return static function (DoctrineMigrationsConfig $doctrineMigrationsConfig, ContainerConfigurator $containerConfigurator): void {
    $doctrineMigrationsConfig
        ->migrationsPath('DoctrineMigrations', '%kernel.project_dir%/migrations')
        ->enableProfiler('%kernel.debug%');
};
