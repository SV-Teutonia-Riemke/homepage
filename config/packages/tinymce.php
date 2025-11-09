<?php

declare(strict_types=1);

use Symfony\Config\TinymceConfig;

return static function (TinymceConfig $config): void {
    $plugins = [
        'advlist',
        'autolink',
        'autoresize',
        'insertdatetime',
        'emoticons',
        'anchor',
        'link',
        'image',
        'media',
        'table',
        'lists',
        'advlist',
        'fullscreen',
        'quickbars',
        'searchreplace',
        'code',
        'preview',
        'help',
    ];

    $toolbar = [
        [
            'undo',
            'redo',
            'searchreplace',
        ],
        [
            'styles',
            'bold',
            'italic',
            'underline',
            'forecolor',
            'removeformat',
        ],
        [
            'alignleft',
            'aligncenter',
            'alignjustify',
            'alignright',
        ],
        [
            'bullist',
            'numlist',
        ],
        [
            'link',
            'anchor',
            'image',
            'media',
            'table',
        ],
        [
            'fullscreen',
            'code',
            'preview',
        ],
        [
            'help',
        ],
    ];

    $toolbarAsString = implode(' | ', array_map(static fn ($row): string => implode(' ', $row), $toolbar));

    $pluginsAsString = implode(' ', $plugins);

    $config
        ->plugins($pluginsAsString)
        ->toolbar($toolbarAsString);
};
