<?php

declare(strict_types=1);

namespace App\Admin\Twig\Component\Crud;

use App\Admin\Crud\CrudConfig;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent(
    name: 'crud:create',
    template: '@admin/_components/crud/create.html.twig',
)]
class CrudCreate
{
    /** @var CrudConfig<object> */
    public CrudConfig $crud;

    public string $title = 'Erstellen';

    public string $icon = 'fa6-solid:plus';

    public string $type = 'primary';
}
