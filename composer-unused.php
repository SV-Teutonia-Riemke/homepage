<?php

declare(strict_types=1);

use ComposerUnused\ComposerUnused\Configuration\Configuration;
use ComposerUnused\ComposerUnused\Configuration\NamedFilter;
use ComposerUnused\ComposerUnused\Configuration\PatternFilter;
use Webmozart\Glob\Glob;

return static function (Configuration $config): Configuration {
    return $config
        ->addPatternFilter(PatternFilter::fromString('/symfony\/.*/'))
        ->addNamedFilter(NamedFilter::fromString('ext-iconv'))
        ->addNamedFilter(NamedFilter::fromString('twig/intl-extra'))
        ->setAdditionalFilesFor('svt/svt', Glob::glob(__DIR__ . '/config/*.php'));
};
