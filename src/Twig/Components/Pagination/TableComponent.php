<?php

declare(strict_types=1);

namespace App\Twig\Components\Pagination;

use Symfony\Component\Form\FormInterface;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent(
    name: 'pagination:table',
    template: 'components/pagination/table.html.twig',
)]
class TableComponent
{
    public string $title;

    /** @var iterable<array-key, mixed> */
    public iterable $iterable;

    public FormInterface|null $form = null;
}
