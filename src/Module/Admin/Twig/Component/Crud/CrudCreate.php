<?php

declare(strict_types=1);

namespace App\Module\Admin\Twig\Component\Crud;

use App\Module\Admin\Crud\CrudConfig;
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
}
