<?php

declare(strict_types=1);

use ReCaptcha\ReCaptcha;
use ReCaptcha\RequestMethod;
use ReCaptcha\RequestMethod\Curl;
use ReCaptcha\RequestMethod\CurlPost;
use Symfony\Component\DependencyInjection\Loader\Configurator\App;
use Symfony\Component\DependencyInjection\Loader\Configurator\EnvConfigurator;
use Symfony\Component\DependencyInjection\Loader\Configurator\ReferenceConfigurator;

return App::config([
    'ewz_recaptcha' => [
        'api_host' => 'recaptcha.net',
        'version' => 3,
        'public_key' => new EnvConfigurator('GOOGLE_RECAPTCHA_SITE_KEY'),
        'private_key' => new EnvConfigurator('GOOGLE_RECAPTCHA_SECRET'),
    ],
    'services' => [
        ReCaptcha::class => [
            'arguments' => [
                '$secret' => new EnvConfigurator('GOOGLE_RECAPTCHA_SECRET'),
                '$requestMethod' => new ReferenceConfigurator(RequestMethod::class),
            ],
        ],
        RequestMethod::class => [
            'alias' => new ReferenceConfigurator(CurlPost::class),
        ],
        CurlPost::class => null,
        Curl::class => null,
    ],
]);
