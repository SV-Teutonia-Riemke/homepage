<?php

declare(strict_types=1);

use Symfony\Component\DependencyInjection\Loader\Configurator\App;

return App::config([
    'ux_icons' => [
        'default_icon_attributes' => [
            'height' => '1.25em',
            'width' => '1.25em',
        ],
    ],
]);
