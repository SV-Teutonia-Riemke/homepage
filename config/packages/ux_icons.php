<?php

declare(strict_types=1);

use Symfony\Config\UxIconsConfig;

return static function (UxIconsConfig $uxIconsConfig): void {
    $uxIconsConfig->defaultIconAttributes([
        'height' => '1.25em',
        'width' => '1.25em',
    ]);
};
