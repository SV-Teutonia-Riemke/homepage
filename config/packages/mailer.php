<?php

declare(strict_types=1);

use Symfony\Component\DependencyInjection\Loader\Configurator\App;
use Symfony\Component\DependencyInjection\Loader\Configurator\EnvConfigurator;

return App::config([
    'framework' => [
        'mailer' => [
            'dsn' => new EnvConfigurator('MAILER_DSN'),
        ],
    ],
]);
