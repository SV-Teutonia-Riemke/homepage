<?php

declare(strict_types=1);

use ReCaptcha\ReCaptcha;
use ReCaptcha\RequestMethod;
use ReCaptcha\RequestMethod\Curl;
use ReCaptcha\RequestMethod\CurlPost;
use Symfony\Component\DependencyInjection\Loader\Configurator\App;

use function Symfony\Component\DependencyInjection\Loader\Configurator\env;
use function Symfony\Component\DependencyInjection\Loader\Configurator\service;

return App::config([
    'ewz_recaptcha' => [
        'api_host' => 'recaptcha.net',
        'version' => 3,
        'public_key' => env('GOOGLE_RECAPTCHA_SITE_KEY'),
        'private_key' => env('GOOGLE_RECAPTCHA_SECRET'),
    ],
    'services' => [
        ReCaptcha::class => [
            'arguments' => [
                '$secret' => env('GOOGLE_RECAPTCHA_SECRET'),
                '$requestMethod' => service(RequestMethod::class),
            ],
        ],
        RequestMethod::class => [
            'alias' => service(CurlPost::class),
        ],
        CurlPost::class => null,
        Curl::class => null,
    ],
]);
