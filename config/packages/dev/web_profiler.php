<?php

declare(strict_types=1);

use Symfony\Config\FrameworkConfig;
use Symfony\Config\WebProfilerConfig;

return static function (
    WebProfilerConfig $webProfilerConfig,
    FrameworkConfig $frameworkConfig,
): void {
    $webProfilerConfig
        ->toolbar()
            ->ajaxReplace(true)
            ->enabled(true);
    $webProfilerConfig->interceptRedirects(false);

    $frameworkConfig->profiler()
        ->onlyExceptions(false)
        ->collectSerializerData(true);
};
