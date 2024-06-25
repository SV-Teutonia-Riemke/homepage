<?php

declare(strict_types=1);

namespace App\Module\Admin\Controller;

use App\Domain\Role;
use App\Module\Admin\Crud\CrudConfigBuilder;
use App\Module\Admin\Crud\Handler\FullHandler;
use App\Module\Admin\Form\Type\Forms\TeamType;
use App\Storage\Entity\Team;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

/** @template-extends AbstractCrudController<Team> */
#[AsController]
#[IsGranted(Role::MANAGE_TEAMS->value)]
#[Route('/team', name: 'team_')]
final class TeamController extends AbstractCrudController
{
    use FullHandler;

    protected function configureCrudConfig(CrudConfigBuilder $builder, Request $request): void
    {
        $builder->setMandatory(
            Team::class,
            'team',
        );
    }

    protected function getFormType(Request $request, object|null $object = null): string
    {
        return TeamType::class;
    }
}
