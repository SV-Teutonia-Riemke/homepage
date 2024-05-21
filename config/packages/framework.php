<?php

declare(strict_types=1);

use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symfony\Component\HttpFoundation\Session\Storage\Handler\PdoSessionHandler;

use function Symfony\Component\DependencyInjection\Loader\Configurator\env;

return static function (ContainerConfigurator $containerConfigurator): void {
    $services = $containerConfigurator->services();

    $services->set(PdoSessionHandler::class)
        ->args([
            env('DATABASE_URL')->string(),
        ]);

    $containerConfigurator->extension('framework', [
        'trusted_hosts' => [
            '^(.+\.)?loca\.lt$',
            '^(.+\.)?svt\.lcl$',
            '^(.+\.)?teutonia-riemke\.de$',
        ],
        'trusted_proxies' => '127.0.0.1,REMOTE_ADDR,192.168.0.0/16,172.16.0.0/12,10.0.0.0/8',
        'trusted_headers' => [
            'x-forwarded-for',
            'x-forwarded-host',
            'x-forwarded-proto',
            'x-forwarded-port',
            'x-forwarded-prefix',
        ],
        'secret' => env('APP_SECRET')->string(),
        'csrf_protection' => true,
        'http_method_override' => false,
        'session' => [
            'handler_id' => PdoSessionHandler::class,
            'cookie_secure' => 'auto',
            'cookie_samesite' => 'lax',
        ],
        'php_errors' => [
            'log' => true,
        ],
    ]);
    if ($containerConfigurator->env() !== 'test') {
        return;
    }

    $containerConfigurator->extension('framework', [
        'test' => true,
        'session' => [
            'handler_id' => null,
            'storage_factory_id' => 'session.storage.factory.mock_file',
        ],
    ]);
};
