<?php

declare(strict_types=1);

use Symfony\Config\PrestaSitemapConfig;

return static function (PrestaSitemapConfig $config): void {
    $config->defaults()
        ->priority(1)
        ->changefreq('daily')
        ->lastmod('now');

    $config->defaultSection('default');
};
