<?php

declare(strict_types=1);

use Symfony\Component\DependencyInjection\Loader\Configurator\App;

use function Symfony\Component\DependencyInjection\Loader\Configurator\env;

return App::config([
    'hwi_oauth' => [
        'resource_owners' => [
            'azure' => [
                'type' => 'azure',
                'client_id' => env('AZURE_CLIENT_ID')->string(),
                'client_secret' => env('AZURE_SECRET')->string(),
                'scope' => 'openid profile email offline_access User.Read',
                'options' => [
                    'application' => env('AZURE_TENANT_ID')->string(),
                ],
            ],
        ],
    ],
]);
