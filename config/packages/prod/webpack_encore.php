<?php

declare(strict_types=1);

use Symfony\Config\WebpackEncoreConfig;

return static function (
    WebpackEncoreConfig $webpackEncoreConfig,
): void {
    $webpackEncoreConfig->cache(true);
};
