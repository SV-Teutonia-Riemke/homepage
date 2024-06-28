<?php

declare(strict_types=1);

use Symfony\Config\StofDoctrineExtensionsConfig;

return static function (StofDoctrineExtensionsConfig $config): void {
    $config
        ->defaultLocale('de')
        ->orm('default')->sortable(true);
};
