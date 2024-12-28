<?php

declare(strict_types=1);

namespace App\DependencyInjection\Compiler;

use App\Infrastructure\ImgProxy\Options\Padding;
use App\Infrastructure\ImgProxy\Options\Size;
use App\Infrastructure\ImgProxy\Preset\Preset;
use App\Infrastructure\ImgProxy\PresetManager;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class ImgProxyCompilerPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container): void
    {
        $definition = $container->getDefinition(PresetManager::class);
        $definition->addMethodCall('add', [
            'default',
            Preset::create(
                new Size(118, 58),
                Padding::all(2),
            ),
        ]);
    }
}
