<?php

declare(strict_types=1);

namespace App\Admin\Controller;

use App\Admin\Crud\CrudConfigBuilder;
use App\Admin\Crud\Handler\FullHandler;
use App\Admin\Crud\Handler\PositionHandler;
use App\Admin\Form\Type\Forms\SponsorType;
use App\Domain\Role;
use App\Storage\Entity\Sponsor;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

/** @template-extends AbstractCrudController<Sponsor, SponsorType, null> */
#[IsGranted(Role::MANAGE_SPONSORS->value)]
#[Route('/sponsor', name: 'sponsor_')]
final class SponsorController extends AbstractCrudController
{
    use FullHandler;
    use PositionHandler;

    protected function configureCrudConfig(
        CrudConfigBuilder $builder,
        Request $request,
    ): void {
        $builder->setMandatory(
            Sponsor::class,
            'sponsor',
        );
        $builder->defaultSortFieldName = 'p.position';
        $builder->defaultSortDirection = 'asc';
    }

    protected function getFormType(
        Request $request,
        object|null $object = null,
    ): string {
        return SponsorType::class;
    }
}
