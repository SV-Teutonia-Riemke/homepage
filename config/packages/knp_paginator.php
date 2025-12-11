<?php

declare(strict_types=1);

use Symfony\Component\DependencyInjection\Loader\Configurator\App;

return App::config([
    'knp_paginator'  => [
        'page_range' => 5,
        'default_options' => [
            'page_name' => 'page',
            'sort_field_name' => 'sort',
            'sort_direction_name' => 'direction',
            'distinct' => true,
            'filter_field_name' => 'filterField',
            'filter_value_name' => 'filterValue',
            'default_limit' => 20,
            'page_out_of_range' => 'fix',
        ],
        'template' => [
            'pagination' => '_partials/pagination.html.twig',
            'sortable' => '@KnpPaginator/Pagination/sortable_link.html.twig',
            'filtration' => '@KnpPaginator/Pagination/bootstrap_v5_filtration.html.twig',
        ],
    ],
]);
