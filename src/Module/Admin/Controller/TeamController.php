<?php

declare(strict_types=1);

namespace App\Module\Admin\Controller;

use App\Module\Admin\Crud\CrudConfig;
use App\Module\Admin\Form\Type\Forms\TeamType;
use App\Storage\Entity\Team;
use App\Storage\Repository\TeamRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Attribute\Route;

#[AsController]
#[Route('/team', name: 'app_admin_team_')]
final class TeamController extends AbstractCrudController
{
    public function __construct(
        private readonly TeamRepository $teamRepository,
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

    #[Route('/{team}/edit', name: 'edit')]
    public function edit(Request $request, Team $team): Response
    {
        return $this->handleEdit($request, $team);
    }

    #[Route('/{team}/remove', name: 'remove')]
    public function remove(Team $team): Response
    {
        return $this->handleRemove($team);
    }

    #[Route('/{team}/enable', name: 'enable', defaults: ['enabled' => true])]
    #[Route('/{team}/disable', name: 'disable', defaults: ['enabled' => false])]
    public function changeEnabled(Team $team, bool $enabled): Response
    {
        return $this->handleEnabled($team, $enabled);
    }

    protected function getCrudConfig(): CrudConfig
    {
        return new CrudConfig(
            $this->teamRepository,
            '@admin/team/index.html.twig',
            '@admin/team/create.html.twig',
            '@admin/team/edit.html.twig',
            'app_admin_team_index',
            'app_admin_team_create',
            TeamType::class,
            defaultSortFieldName: 'p.id',
            defaultSortDirection: 'asc',
        );
    }
}
