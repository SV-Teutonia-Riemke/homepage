<?php

declare(strict_types=1);

namespace App\Module\Admin\Controller;

use App\Module\Admin\Crud\CrudConfig;
use App\Module\Admin\Form\Type\Forms\PersonSearchType;
use App\Module\Admin\Form\Type\Forms\PersonType;
use App\Storage\Entity\Person;
use App\Storage\Repository\PersonRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Attribute\Route;

/** @template-extends AbstractCrudController<Person> */
#[AsController]
#[Route('/person', name: 'person_')]
final class PersonController extends AbstractCrudController
{
    public function __construct(
        private readonly PersonRepository $personRepository,
    ) {
    }

    #[Route('', name: 'index')]
    public function index(Request $request): Response
    {
        return $this->handleList($request);
    }

    #[Route('/create', name: 'create')]
    public function create(Request $request): Response
    {
        return $this->handleCreate($request);
    }

    #[Route('/{person}/edit', name: 'edit')]
    public function edit(Request $request, Person $person): Response
    {
        return $this->handleEdit($request, $person);
    }

    #[Route('/{person}/remove', name: 'remove')]
    public function remove(Person $person): Response
    {
        return $this->handleRemove($person);
    }

    protected function getCrudConfig(): CrudConfig
    {
        return new CrudConfig(
            $this->personRepository,
            '@admin/person/index.html.twig',
            '@admin/person/create.html.twig',
            '@admin/person/edit.html.twig',
            'app_admin_person_index',
            'app_admin_person_create',
            PersonType::class,
            PersonSearchType::class,
        );
    }
}
