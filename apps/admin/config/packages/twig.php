<?php

declare(strict_types=1);

use Symfony\Component\DependencyInjection\Loader\Configurator\App;

return App::config([
    'twig' => [
        'paths' => [
            '%kernel.project_dir%/apps/admin/templates' => 'admin',
        ],
    ],
]);
