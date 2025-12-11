<?php

declare(strict_types=1);

use Symfony\Component\DependencyInjection\Loader\Configurator\App;

return App::config([
    'knp_menu' => [
        'twig' => [
            'template' => '_partials/menu.html.twig',
        ],
        'templating' => false,
        'default_renderer' => 'twig',
    ],
]);
