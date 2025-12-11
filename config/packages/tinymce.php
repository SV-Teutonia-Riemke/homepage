<?php

declare(strict_types=1);

use Symfony\Component\DependencyInjection\Loader\Configurator\App;

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

return App::config([
    'tinymce' => [
        'plugins' => $pluginsAsString,
        'toolbar' => $toolbarAsString,
    ],
]);
