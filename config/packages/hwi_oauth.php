<?php

declare(strict_types=1);

use Symfony\Config\HwiOauthConfig;

use function Symfony\Component\DependencyInjection\Loader\Configurator\env;

return static function (HwiOauthConfig $config): void {
    $config->resourceOwner('azure')
        ->type('azure')
        ->clientId(env('AZURE_CLIENT_ID')->string())
        ->clientSecret(env('AZURE_SECRET')->string())
        ->scope('openid profile email offline_access User.Read')
        ->options('application', env('AZURE_TENANT_ID')->string());
};
