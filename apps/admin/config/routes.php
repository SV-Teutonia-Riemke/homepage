<?php

declare(strict_types=1);

use Symfony\Component\Routing\Loader\Configurator\RoutingConfigurator;

return static function (RoutingConfigurator $routingConfigurator): void {
    $routingConfigurator
        ->import(
            __DIR__ . '/../src/Controller/',
            'attribute',
        )
        ->namePrefix('admin_');

    $routingConfigurator
        ->add(
            'admin_logout',
            '/logout',
        )
        ->methods([
            'GET',
        ]);

    $routingConfigurator->add(
        'azure_login',
        '/login/check-azure',
    );
};
