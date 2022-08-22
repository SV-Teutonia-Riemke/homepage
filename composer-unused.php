<?php

declare(strict_types=1);

use ComposerUnused\ComposerUnused\Configuration\Configuration;
use ComposerUnused\ComposerUnused\Configuration\NamedFilter;
use Webmozart\Glob\Glob;

return static function (Configuration $config): Configuration {
    return $config
        ->addNamedFilter(NamedFilter::fromString('ext-iconv'))
        ->addNamedFilter(NamedFilter::fromString('symfony/apache-pack'))
        ->addNamedFilter(NamedFilter::fromString('symfony/flex'))
        ->addNamedFilter(NamedFilter::fromString('symfony/proxy-manager-bridge'))
        ->addNamedFilter(NamedFilter::fromString('symfony/runtime'))
        ->addNamedFilter(NamedFilter::fromString('symfony/yaml'))
        ->addNamedFilter(NamedFilter::fromString('twig/intl-extra'))
        ->setAdditionalFilesFor('nicklog/resin', Glob::glob(__DIR__ . '/config/*.php'));
};
