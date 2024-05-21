<?php

declare(strict_types=1);

use League\Flysystem\Filesystem;
use Symfony\Config\OneupFlysystemConfig;

return static function (OneupFlysystemConfig $config): void {
    $config
        ->adapter('default_adapter')
        ->local()
        ->location('%kernel.project_dir%/var/flysystem');

    $config->filesystem('default_filesystem')
        ->adapter('default_adapter')
        ->alias(Filesystem::class);
};
