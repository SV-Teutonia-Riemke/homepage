<?php

declare(strict_types=1);

use Symfony\Component\DependencyInjection\Loader\Configurator\App;
use Symfony\Component\HttpFoundation\Session\Storage\Handler\PdoSessionHandler;

use function Symfony\Component\DependencyInjection\Loader\Configurator\env;

return App::config([
    'framework' => [
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
    ],
    'services' => [
        PdoSessionHandler::class => [
            'arguments' => [
                env('DATABASE_URL')->string(),
            ],
        ],
    ],
]);
