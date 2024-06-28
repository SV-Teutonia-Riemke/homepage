<?php

declare(strict_types=1);

use Symfony\Config\FrameworkConfig;

return static function (FrameworkConfig $config): void {
    $config
        ->defaultLocale('de')
        ->translator()
            ->defaultPath('%kernel.project_dir%/translations')
            ->fallbacks(['de']);
};
