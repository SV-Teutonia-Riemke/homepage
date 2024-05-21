<?php

declare(strict_types=1);

use App\Infrastructure\Clock\ClockFactory;
use App\Infrastructure\Menu\Extension\BadgeExtension;
use App\Infrastructure\Menu\Extension\DropdownExtension;
use App\Infrastructure\Menu\Extension\EventDispatcherExtension;
use App\Infrastructure\Menu\Extension\IconifyExtension;
use App\Infrastructure\Menu\Extension\OrderExtension;
use App\Infrastructure\Shlink\ShlinkClientFactory;
use App\Module\Page\Menu\Navbar;
use Psr\Clock\ClockInterface;
use Shlinkio\Shlink\SDK\ShlinkClient;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

use function Symfony\Component\DependencyInjection\Loader\Configurator\service;

return static function (ContainerConfigurator $containerConfigurator): void {
    $services = $containerConfigurator->services();

    $services->defaults()
        ->autowire()
        ->autoconfigure();

    $services->load('App\\', __DIR__ . '/../src/')
        ->exclude([
            __DIR__ . '/../src/DependencyInjection/',
            __DIR__ . '/../src/Storage/Entity/',
            __DIR__ . '/../src/Kernel.php',
        ]);

    $services->set(ClockInterface::class)
        ->factory(service(ClockFactory::class));

    $services->set(Navbar::class)
        ->tag('knp_menu.menu_builder', [
            'method' => 'main',
            'alias' => 'main',
        ]);

    $services->set(DropdownExtension::class)
        ->tag('knp_menu.factory_extension');

    $services->set(IconifyExtension::class)
        ->tag('knp_menu.factory_extension');

    $services->set(BadgeExtension::class)
        ->tag('knp_menu.factory_extension');

    $services->set(EventDispatcherExtension::class)
        ->tag('knp_menu.factory_extension', [
            'priority' => -1000,
        ]);

    $services->set(OrderExtension::class)
        ->tag('knp_menu.factory_extension', [
            'priority' => -1001,
        ]);

    $services->set(ShlinkClient::class)
        ->factory(service(ShlinkClientFactory::class));
};
