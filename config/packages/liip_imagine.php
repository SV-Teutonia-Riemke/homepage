<?php

declare(strict_types=1);

use Liip\ImagineBundle\Imagine\Cache\Resolver\PsrCacheResolver;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

use function Symfony\Component\DependencyInjection\Loader\Configurator\service;

return static function (ContainerConfigurator $containerConfigurator): void {
    $containerConfigurator->extension('framework', [
        'cache' => [
            'pools' => [
                'liip_cache' => [
                    'adapter' => 'cache.adapter.redis',
                ],
            ],
        ],
    ]);

    $services = $containerConfigurator->services();

    $services->set('liip_imagine.cache.resolver.psr', PsrCacheResolver::class)
        ->args([
            service('liip_cache'),
            service('liip_imagine.cache.resolver.generic'),
        ])
        ->tag('liip_imagine.cache.resolver', [
            'resolver' => 'psr_cache',
        ]);

    $containerConfigurator->extension('liip_imagine', [
        'driver' => 'imagick',
        'default_filter_set_settings' => [
            'format' => 'webp',
        ],
        'resolvers' => [
            'generic' => [
                'web_path' => [
                    'web_root' => '%kernel.project_dir%/public',
                    'cache_prefix' => 'media/cache',
                ],
            ],
        ],
        'loaders' => [
            'default' => [
                'filesystem' => [
                    'data_root' => '%kernel.project_dir%/public',
                ],
            ],
            'flysystem' => [
                'flysystem' => [
                    'filesystem_service' => 'oneup_flysystem.default_filesystem_filesystem',
                ],
            ],
            'chain' => [
                'chain' => [
                    'loaders' => [
                        'default',
                        'flysystem',
                    ],
                ],
            ],
        ],
        'data_loader' => 'chain',
        'cache' => 'psr_cache',
        'filter_sets' => [
            'default' => null,
            'optimized' => [
                'quality' => 99,
            ],
            'sponsor_index' => [
                'quality' => 90,
                'filters' => [
                    'thumbnail' => [
                        'size' => [
                            118,
                            58,
                        ],
                        'mode' => 'inset',
                    ],
                    'background' => [
                        'size' => [
                            120,
                            60,
                        ],
                        'position' => 'center',
                        'transparency' => 100,
                    ],
                ],
            ],
            'sponsor_index_main' => [
                'quality' => 90,
                'filters' => [
                    'thumbnail' => [
                        'size' => [
                            256,
                            127,
                        ],
                        'mode' => 'inset',
                    ],
                    'background' => [
                        'size' => [
                            258,
                            129,
                        ],
                        'position' => 'center',
                        'transparency' => 100,
                    ],
                ],
            ],
            'sponsor_main' => [
                'quality' => 90,
                'filters' => [
                    'thumbnail' => [
                        'size' => [
                            380,
                            190,
                        ],
                        'mode' => 'inset',
                    ],
                    'background' => [
                        'size' => [
                            420,
                            220,
                        ],
                        'position' => 'center',
                    ],
                ],
            ],
            'sponsor_page' => [
                'quality' => 90,
                'filters' => [
                    'thumbnail' => [
                        'size' => [
                            245,
                            122,
                        ],
                        'mode' => 'inset',
                    ],
                    'background' => [
                        'size' => [
                            257,
                            124,
                        ],
                        'position' => 'center',
                    ],
                ],
            ],
        ],
        'twig' => [
            'mode' => 'lazy',
        ],
    ]);
};
