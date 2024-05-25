<?php

declare(strict_types=1);

use Symfony\Config\DoctrineConfig;

use function Symfony\Component\DependencyInjection\Loader\Configurator\env;

return static function (
    DoctrineConfig $doctrineConfig,
): void {
    $doctrineConfig
        ->dbal()
        ->defaultConnection('default')
        ->connection('default')
        ->dbnameSuffix(
            sprintf(
                '_test%s',
                env('TEST_TOKEN')->default(''),
            ),
        );
};
