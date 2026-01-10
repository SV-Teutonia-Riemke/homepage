<?php

declare(strict_types=1);

namespace App\Admin\Controller;

use App\Admin\Crud\CrudConfigBuilder;
use App\Admin\Crud\Handler\CRUDHandler;
use App\Admin\Form\Type\Forms\PersonSearchType;
use App\Admin\Form\Type\Forms\PersonType;
use App\Domain\Role;
use App\Storage\Entity\Person;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

/** @template-extends AbstractCrudController<Person, PersonType, PersonSearchType> */
#[IsGranted(Role::MANAGE_PERSONS->value)]
#[Route('/person', name: 'person_')]
final class PersonController extends AbstractCrudController
{
    use CRUDHandler;

    protected function configureCrudConfig(
        CrudConfigBuilder $builder,
        Request $request,
    ): void {
        $builder->setMandatory(
            Person::class,
            'person',
        );
    }

    protected function getFormType(
        Request $request,
        object|null $object = null,
    ): string {
        return PersonType::class;
    }

    protected function getSearchType(): string
    {
        return PersonSearchType::class;
    }
}
