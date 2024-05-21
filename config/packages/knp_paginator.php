<?php

declare(strict_types=1);

use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symfony\Config\KnpPaginatorConfig;

return static function (KnpPaginatorConfig $config, ContainerConfigurator $containerConfigurator): void {
    $config->pageRange(5);
    $config->defaultOptions()
        ->pageName('page')
        ->sortFieldName('sort')
        ->sortDirectionName('direction')
        ->distinct(true)
        ->filterFieldName('filterField')
        ->filterValueName('filterValue')
        ->defaultLimit(20)
        ->pageOutOfRange('fix');

    $config->template()
        ->pagination('_partials/pagination.html.twig')
        ->sortable('@KnpPaginator/Pagination/sortable_link.html.twig')
        ->filtration('@KnpPaginator/Pagination/bootstrap_v5_filtration.html.twig');
};
