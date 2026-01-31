<?php

declare(strict_types=1);

use Symfony\Component\DependencyInjection\Loader\Configurator\App;
use Symfony\Component\DependencyInjection\Loader\Configurator\EnvConfigurator;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

return App::config([
    'sentry' => [
        'dsn' => new EnvConfigurator('SENTRY_DSN')->string(),
        'options' => [
            'traces_sample_rate' => new EnvConfigurator('SENTRY_TRACE')->float(),
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
