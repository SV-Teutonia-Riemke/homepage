<?php

declare(strict_types=1);

use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Config\SentryConfig;

use function Symfony\Component\DependencyInjection\Loader\Configurator\env;

return static function (
    SentryConfig $config,
): void {
    $config
        ->dsn(env('SENTRY_DSN')->string())
        ->options()->tracesSampleRate(env('SENTRY_TRACE')->float());

    $config->tracing()->enabled(true);
    $config->tracing()->dbal()->enabled(true);
    $config->tracing()->cache()->enabled(true);
    $config->tracing()->twig()->enabled(true);
    $config->messenger()->enabled(true);

    $config->options()->ignoreExceptions([
        NotFoundHttpException::class,
        AccessDeniedException::class,
        BadRequestHttpException::class,
    ]);
};
