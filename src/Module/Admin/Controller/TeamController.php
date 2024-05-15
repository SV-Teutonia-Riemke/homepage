<?php

declare(strict_types=1);

namespace App\Module\Admin\Controller;

use App\Module\Admin\Crud\CrudConfigBuilder;
use App\Module\Admin\Crud\Handler\FullHandler;
use App\Module\Admin\Form\Type\Forms\TeamType;
use App\Storage\Entity\Team;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Attribute\Route;

/** @template-extends AbstractCrudController<Team> */
#[AsController]
#[Route('/team', name: 'team_')]
final class TeamController extends AbstractCrudController
{
    use FullHandler;

    protected function configureCrudConfig(CrudConfigBuilder $builder): void
    {
        $builder->setDefaults();
        $builder->dtoClass             = Team::class;
        $builder->listTemplate         = '@admin/team/index.html.twig';
        $builder->createTemplate       = '@admin/team/create.html.twig';
        $builder->editTemplate         = '@admin/team/edit.html.twig';
        $builder->listRouteName        = 'app_admin_team_index';
        $builder->createRouteName      = 'app_admin_team_create';
        $builder->formType             = TeamType::class;
        $builder->defaultSortFieldName = 'p.id';
        $builder->defaultSortDirection = 'asc';
    }
}
