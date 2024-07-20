<?php

declare(strict_types=1);

namespace App\Module\Admin\Controller;

use App\Domain\Role;
use App\Module\Admin\Crud\CrudConfigBuilder;
use App\Module\Admin\Crud\Handler\FullHandler;
use App\Module\Admin\Form\Type\Forms\PageType;
use App\Storage\Entity\Page;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

/** @template-extends AbstractCrudController<Page> */
#[AsController]
#[IsGranted(Role::MANAGE_PAGES->value)]
#[Route('/page', name: 'page_')]
final class PageController extends AbstractCrudController
{
    use FullHandler;

    protected function configureCrudConfig(
        CrudConfigBuilder $builder,
        Request $request,
    ): void {
        $builder->setMandatory(
            Page::class,
            'page',
        );
    }

    protected function getFormType(
        Request $request,
        object|null $object = null,
    ): string {
        return PageType::class;
    }
}
