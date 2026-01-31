<?php

declare(strict_types=1);

use Symfony\Component\DependencyInjection\Loader\Configurator\App;
use Symfony\Component\DependencyInjection\Loader\Configurator\EnvConfigurator;

return App::config([
    'hwi_oauth' => [
        'resource_owners' => [
            'azure' => [
                'type' => 'azure',
                'client_id' => new EnvConfigurator('AZURE_CLIENT_ID')->string(),
                'client_secret' => new EnvConfigurator('AZURE_SECRET')->string(),
                'scope' => 'openid profile email offline_access User.Read',
                'options' => [
                    'application' => new EnvConfigurator('AZURE_TENANT_ID')->string(),
                ],
            ],
        ],
    ],
]);
