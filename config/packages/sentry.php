<?php

declare(strict_types=1);

use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symfony\Config\SentryConfig;

use function Symfony\Component\DependencyInjection\Loader\Configurator\env;

return static function (
    SentryConfig $config,
    ContainerConfigurator $containerConfigurator,
): void {
    if ($containerConfigurator->env() !== 'prod') {
        return;
    }

    $config
        ->dsn(env('SENTRY_DSN')->string())
        ->options()->tracesSampleRate(env('SENTRY_TRACE')->float());

    $config->tracing()->enabled(true);
    $config->tracing()->dbal()->enabled(true);
    $config->tracing()->cache()->enabled(true);
    $config->tracing()->twig()->enabled(true);
    $config->messenger()->enabled(true);
};
