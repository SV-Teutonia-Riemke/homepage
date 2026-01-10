<?php

declare(strict_types=1);

namespace App\Admin\Controller;

use App\Admin\Crud\CrudConfigBuilder;
use App\Admin\Crud\Handler\FullHandler;
use App\Admin\Form\Type\Forms\TeamSearchType;
use App\Admin\Form\Type\Forms\TeamType;
use App\Domain\Role;
use App\Storage\Entity\Team;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

/** @template-extends AbstractCrudController<Team, TeamType, null> */
#[IsGranted(Role::MANAGE_TEAMS->value)]
#[Route('/team', name: 'team_')]
final class TeamController extends AbstractCrudController
{
    use FullHandler;

    protected function configureCrudConfig(
        CrudConfigBuilder $builder,
        Request $request,
    ): void {
        $builder->setMandatory(
            Team::class,
            'team',
        );

        $builder->defaultSortFieldName = 'p.id';
        $builder->defaultSortDirection = 'desc';
    }

    protected function getFormType(
        Request $request,
        object|null $object = null,
    ): string {
        return TeamType::class;
    }

    protected function getSearchType(): string
    {
        return TeamSearchType::class;
    }
}
