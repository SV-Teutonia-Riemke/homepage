<?php

declare(strict_types=1);

use Nyholm\Psr7\Factory\Psr17Factory;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ServerRequestFactoryInterface;
use Psr\Http\Message\StreamFactoryInterface;
use Psr\Http\Message\UploadedFileFactoryInterface;
use Psr\Http\Message\UriFactoryInterface;
use Symfony\Component\DependencyInjection\Loader\Configurator\App;

return App::config([
    'services' => [
        Psr17Factory::class => null,
        'nyholm.psr7.psr17_factory' => [
            'alias' => Psr17Factory::class,
        ],
        RequestFactoryInterface::class => [
            'alias' => Psr17Factory::class,
        ],
        ResponseFactoryInterface::class => [
            'alias' => Psr17Factory::class,
        ],
        ServerRequestFactoryInterface::class => [
            'alias' => Psr17Factory::class,
        ],
        StreamFactoryInterface::class => [
            'alias' => Psr17Factory::class,
        ],
        UploadedFileFactoryInterface::class => [
            'alias' => Psr17Factory::class,
        ],
        UriFactoryInterface::class => [
            'alias' => Psr17Factory::class,
        ],
    ],
]);
