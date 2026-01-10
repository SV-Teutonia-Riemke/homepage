<?php

declare(strict_types=1);

namespace App\Admin\Controller;

use App\Admin\Crud\CrudConfigBuilder;
use App\Admin\Crud\Handler\FullHandler;
use App\Admin\Crud\Handler\PositionHandler;
use App\Admin\Form\Type\Forms\FaqCategoryType;
use App\Domain\Role;
use App\Storage\Entity\FaqCategory;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

/** @template-extends AbstractCrudController<FaqCategory, FaqCategoryType, null> */
#[IsGranted(Role::MANAGE_FAQ->value)]
#[Route('/faq/category', name: 'faq_category_')]
final class FaqCategoryController extends AbstractCrudController
{
    use FullHandler;
    use PositionHandler;

    protected function configureCrudConfig(
        CrudConfigBuilder $builder,
        Request $request,
    ): void {
        $builder->setMandatory(
            FaqCategory::class,
            'faq_category',
        );
        $builder->defaultSortFieldName = 'p.position';
        $builder->defaultSortDirection = 'asc';
    }

    protected function getFormType(
        Request $request,
        object|null $object = null,
    ): string {
        return FaqCategoryType::class;
    }
}
