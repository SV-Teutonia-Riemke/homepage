<?php

declare(strict_types=1);

namespace App\Module\Admin\Controller;

use App\Module\Admin\Crud\CrudConfigBuilder;
use App\Module\Admin\Crud\Handler\FullHandler;
use App\Module\Admin\Form\Type\Forms\PageType;
use App\Storage\Entity\Page;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Attribute\Route;

/** @template-extends AbstractCrudController<Page> */
#[AsController]
#[Route('/page', name: 'page_')]
final class PageController extends AbstractCrudController
{
    use FullHandler;

    protected function configureCrudConfig(CrudConfigBuilder $builder): void
    {
        $builder->setDefaults();
        $builder->dtoClass        = Page::class;
        $builder->formType        = PageType::class;
        $builder->listTemplate    = '@admin/page/index.html.twig';
        $builder->createTemplate  = '@admin/page/create.html.twig';
        $builder->editTemplate    = '@admin/page/edit.html.twig';
        $builder->listRouteName   = 'app_admin_page_index';
        $builder->createRouteName = 'app_admin_page_create';
    }
}
