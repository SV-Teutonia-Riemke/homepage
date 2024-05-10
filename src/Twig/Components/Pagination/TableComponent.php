<?php

declare(strict_types=1);

namespace App\Twig\Components\Pagination;

use Knp\Bundle\PaginatorBundle\Pagination\SlidingPaginationInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent(
    name: 'pagination:table',
    template: 'components/pagination/table.html.twig',
)]
class TableComponent
{
    public string $paginationTitle;

    /** @var SlidingPaginationInterface<array-key, mixed> */
    public SlidingPaginationInterface $pagination;

    public FormInterface|null $form;
}
