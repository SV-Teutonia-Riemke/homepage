<?php

declare(strict_types=1);

use Pentatrion\ViteBundle\Controller\ProfilerController;
use Symfony\Component\Routing\Loader\Configurator\RoutingConfigurator;

return static function (RoutingConfigurator $routingConfigurator): void {
    $routingConfigurator
        ->import('@PentatrionViteBundle/Resources/config/routing.yaml')
        ->prefix('/build');

    $routingConfigurator
        ->add('_profiler_vite', '/_profiler/vite')
        ->defaults([
            '_controller' => sprintf('%s::info', ProfilerController::class),
        ]);
};
