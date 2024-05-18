<?php

declare(strict_types=1);

namespace App\Module\Admin\Controller;

use App\Module\Admin\Crud\CrudConfigBuilder;
use App\Module\Admin\Crud\Handler\FullHandler;
use App\Module\Admin\Crud\Handler\PositionHandler;
use App\Module\Admin\Form\Type\Forms\PersonGroupType;
use App\Storage\Entity\PersonGroup;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Attribute\Route;

/** @template-extends AbstractCrudController<PersonGroup> */
#[AsController]
#[Route('/person-group', name: 'person_group_')]
final class PersonGroupController extends AbstractCrudController
{
    use FullHandler;
    use PositionHandler;

    protected function configureCrudConfig(CrudConfigBuilder $builder): void
    {
        $builder->dtoClass             = PersonGroup::class;
        $builder->listTemplate         = '@admin/person_group/index.html.twig';
        $builder->createTemplate       = '@admin/person_group/create.html.twig';
        $builder->editTemplate         = '@admin/person_group/edit.html.twig';
        $builder->listRouteName        = 'app_admin_person_group_index';
        $builder->createRouteName      = 'app_admin_person_group_create';
        $builder->defaultSortFieldName = 'p.position';
        $builder->defaultSortDirection = 'asc';
    }

    protected function getFormType(Request $request, object|null $object = null): string
    {
        return PersonGroupType::class;
    }
}
