<?php

declare(strict_types=1);

use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

return static function (
    ContainerConfigurator $containerConfigurator,
): void {
    $containerConfigurator->extension('twig', [
        'default_path' => '%kernel.project_dir%/templates',
        'form_themes' => [
            'bootstrap_5_layout.html.twig',
        ],
        'paths' => [
            '%kernel.project_dir%/src/Module/Admin/Templates' => 'admin',
            '%kernel.project_dir%/src/Module/Page/Templates' => 'page',
        ],
    ]);
};
