<?php

declare(strict_types=1);

namespace App\Module\Admin\Controller;

use App\Module\Admin\Crud\CrudConfigBuilder;
use App\Module\Admin\Crud\Handler\CRUDHandler;
use App\Module\Admin\Form\Type\Forms\PersonSearchType;
use App\Module\Admin\Form\Type\Forms\PersonType;
use App\Storage\Entity\Person;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Attribute\Route;

/** @template-extends AbstractCrudController<Person> */
#[AsController]
#[Route('/person', name: 'person_')]
final class PersonController extends AbstractCrudController
{
    use CRUDHandler;

    protected function configureCrudConfig(CrudConfigBuilder $builder): void
    {
        $builder->dtoClass        = Person::class;
        $builder->listTemplate    = '@admin/person/index.html.twig';
        $builder->createTemplate  = '@admin/person/create.html.twig';
        $builder->editTemplate    = '@admin/person/edit.html.twig';
        $builder->listRouteName   = 'app_admin_person_index';
        $builder->createRouteName = 'app_admin_person_create';
    }

    protected function getFormType(Request $request, object|null $object = null): string
    {
        return PersonType::class;
    }

    protected function getSearchType(): string|null
    {
        return PersonSearchType::class;
    }
}
