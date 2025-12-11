<?php

declare(strict_types=1);

use Symfony\Component\DependencyInjection\Loader\Configurator\App;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

use function Symfony\Component\DependencyInjection\Loader\Configurator\env;

return App::config([
    'sentry' => [
        'dsn' => env('SENTRY_DSN')->string(),
        'options' => [
            'traces_sample_rate' => env('SENTRY_TRACE')->float(),
            'ignore_exceptions' => [
                NotFoundHttpException::class,
                AccessDeniedException::class,
                BadRequestHttpException::class,
            ],
        ],
        'tracing' => [
            'enabled' => true,
            'dbal' => true,
            'cache' => true,
            'twig' => true,
        ],
        'messenger' => [
            'enabled' => true,
        ],
    ],
]);
