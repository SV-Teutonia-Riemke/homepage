<?php

declare(strict_types=1);

namespace App\Module\Admin\Twig\Component\Crud;

use App\Module\Admin\Crud\CrudConfig;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent(
    name: 'crud:row',
    template: '@admin/_components/crud/row.html.twig',
)]
class CrudRow
{
    /** @var CrudConfig<object> */
    public CrudConfig $crud;
    public object $object;
}
