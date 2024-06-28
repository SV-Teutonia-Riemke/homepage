<?php

declare(strict_types=1);

use Symfony\Config\KnpMenuConfig;

return static function (KnpMenuConfig $config): void {
    $config->twig()->template('_partials/menu.html.twig');
    $config
        ->templating(false)
        ->defaultRenderer('twig');
};
