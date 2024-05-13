<?php

declare(strict_types=1);

namespace App\Module\Admin\Controller;

use App\Module\Admin\Crud\CrudConfig;
use App\Module\Admin\Form\Type\Forms\PersonGroupType;
use App\Storage\Entity\PersonGroup;
use App\Storage\Repository\PersonGroupRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Attribute\Route;

/** @template-extends AbstractCrudController<PersonGroup> */
#[AsController]
#[Route('/person-group', name: 'person_group_')]
final class PersonGroupController extends AbstractCrudController
{
    public function __construct(
        private readonly PersonGroupRepository $personGroupRepository,
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

    #[Route('/{personGroup}/edit', name: 'edit')]
    public function edit(Request $request, PersonGroup $personGroup): Response
    {
        return $this->handleEdit($request, $personGroup);
    }

    #[Route('/{personGroup}/remove', name: 'remove')]
    public function remove(PersonGroup $personGroup): Response
    {
        return $this->handleRemove($personGroup);
    }

    #[Route('/{personGroup}/enable', name: 'enable', defaults: ['enabled' => true])]
    #[Route('/{personGroup}/disable', name: 'disable', defaults: ['enabled' => false])]
    public function changeEnabled(PersonGroup $personGroup, bool $enabled): Response
    {
        return $this->handleEnabled($personGroup, $enabled);
    }

    #[Route('/{personGroup}/up', name: 'up', defaults: ['position' => -1])]
    #[Route('/{personGroup}/down', name: 'down', defaults: ['position' => 1])]
    public function position(PersonGroup $personGroup, int $position): Response
    {
        return $this->handlePosition($personGroup, $position);
    }

    protected function getCrudConfig(): CrudConfig
    {
        return new CrudConfig(
            $this->personGroupRepository,
            '@admin/person_group/index.html.twig',
            '@admin/person_group/create.html.twig',
            '@admin/person_group/edit.html.twig',
            'app_admin_person_group_index',
            'app_admin_person_group_create',
            PersonGroupType::class,
            defaultSortFieldName: 'p.position',
            defaultSortDirection: 'asc',
        );
    }
}
