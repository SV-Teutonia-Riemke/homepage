<?php

declare(strict_types=1);

use Nyholm\Psr7\Factory\Psr17Factory;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ServerRequestFactoryInterface;
use Psr\Http\Message\StreamFactoryInterface;
use Psr\Http\Message\UploadedFileFactoryInterface;
use Psr\Http\Message\UriFactoryInterface;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

return static function (ContainerConfigurator $containerConfigurator): void {
    $services = $containerConfigurator->services();

    $services->alias(RequestFactoryInterface::class, 'nyholm.psr7.psr17_factory');
    $services->alias(ResponseFactoryInterface::class, 'nyholm.psr7.psr17_factory');
    $services->alias(ServerRequestFactoryInterface::class, 'nyholm.psr7.psr17_factory');
    $services->alias(StreamFactoryInterface::class, 'nyholm.psr7.psr17_factory');
    $services->alias(UploadedFileFactoryInterface::class, 'nyholm.psr7.psr17_factory');
    $services->alias(UriFactoryInterface::class, 'nyholm.psr7.psr17_factory');
    $services->set('nyholm.psr7.psr17_factory', Psr17Factory::class);
};
