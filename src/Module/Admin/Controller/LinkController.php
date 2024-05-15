<?php

declare(strict_types=1);

namespace App\Module\Admin\Controller;

use App\Module\Admin\Crud\CrudConfigBuilder;
use App\Module\Admin\Crud\Handler\FullHandler;
use App\Module\Admin\Form\Type\Forms\LinkType;
use App\Storage\Entity\Link;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Attribute\Route;

/** @template-extends AbstractCrudController<Link> */
#[AsController]
#[Route('/link', name: 'link_')]
final class LinkController extends AbstractCrudController
{
    use FullHandler;

    protected function configureCrudConfig(CrudConfigBuilder $builder): void
    {
        $builder->setDefaults();
        $builder->dtoClass             = Link::class;
        $builder->formType             = LinkType::class;
        $builder->listTemplate         = '@admin/link/index.html.twig';
        $builder->createTemplate       = '@admin/link/create.html.twig';
        $builder->editTemplate         = '@admin/link/edit.html.twig';
        $builder->listRouteName        = 'app_admin_link_index';
        $builder->createRouteName      = 'app_admin_link_create';
        $builder->defaultSortFieldName = 'p.id';
        $builder->defaultSortDirection = 'desc';
    }
}
