<?php

declare(strict_types=1);

use App\Infrastructure\Shlink\ShlinkClientFactory;
use Embed\Embed;
use Shlinkio\Shlink\SDK\ShlinkClient;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

use function Symfony\Component\DependencyInjection\Loader\Configurator\service;

return static function (ContainerConfigurator $containerConfigurator): void {
    $services = $containerConfigurator->services();

    $services->defaults()
        ->autowire()
        ->autoconfigure();

    $services
        ->load(
            'App\\',
            __DIR__ . '/../src/',
        )
        ->exclude([
            __DIR__ . '/../src/DependencyInjection/',
            __DIR__ . '/../src/Domain/',
            __DIR__ . '/../src/Storage/Entity/',
            __DIR__ . '/../src/Kernel.php',
        ]);

    $services->set(ShlinkClient::class)
        ->factory(service(ShlinkClientFactory::class));

    $services->set(Embed::class);
};
