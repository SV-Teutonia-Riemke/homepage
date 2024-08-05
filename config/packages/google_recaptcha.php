<?php

declare(strict_types=1);

use ReCaptcha\ReCaptcha;
use ReCaptcha\RequestMethod;
use ReCaptcha\RequestMethod\Curl;
use ReCaptcha\RequestMethod\CurlPost;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

use function Symfony\Component\DependencyInjection\Loader\Configurator\env;
use function Symfony\Component\DependencyInjection\Loader\Configurator\service;

return static function (ContainerConfigurator $containerConfigurator): void {
    $services = $containerConfigurator->services();

    $services->set(ReCaptcha::class)
        ->arg('$secret', env('GOOGLE_RECAPTCHA_SECRET'))
        ->arg('$requestMethod', service(RequestMethod::class));

    $services->alias(RequestMethod::class, CurlPost::class);
    $services->set(CurlPost::class);
    $services->set(Curl::class);

    $containerConfigurator->extension('ewz_recaptcha', [
        'api_host' => 'recaptcha.net',
        'version' => 3,
        'public_key' => env('GOOGLE_RECAPTCHA_SITE_KEY'),
        'private_key' => env('GOOGLE_RECAPTCHA_SECRET'),
    ]);
};
