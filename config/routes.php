<?php

declare(strict_types=1);

use Symfony\Component\Routing\Loader\Configurator\RoutingConfigurator;

return static function (RoutingConfigurator $routingConfigurator): void {
    $routingConfigurator->import(__DIR__ . '/../src/Module/Page/Controller/', 'attribute')
        ->namePrefix('app_');

    $routingConfigurator->import(__DIR__ . '/../src/Module/Admin/Controller/', 'attribute')
        ->prefix('admin')
        ->namePrefix('app_admin_');

    $routingConfigurator->add('app_admin_logout', '/admin/logout')
        ->methods([
            'GET',
        ]);

    $routingConfigurator->add('azure_login', '/admin/login/check-azure');
};
