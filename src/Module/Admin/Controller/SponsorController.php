<?php

declare(strict_types=1);

namespace App\Module\Admin\Controller;

use App\Module\Admin\Crud\CrudConfigBuilder;
use App\Module\Admin\Crud\Handler\FullHandler;
use App\Module\Admin\Crud\Handler\PositionHandler;
use App\Module\Admin\Form\Type\Forms\SponsorType;
use App\Storage\Entity\Sponsor;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Attribute\Route;

/** @template-extends AbstractCrudController<Sponsor> */
#[AsController]
#[Route('/sponsor', name: 'sponsor_')]
final class SponsorController extends AbstractCrudController
{
    use FullHandler;
    use PositionHandler;

    protected function configureCrudConfig(CrudConfigBuilder $builder): void
    {
        $builder->setDefaults();
        $builder->dtoClass             = Sponsor::class;
        $builder->formType             = SponsorType::class;
        $builder->listTemplate         = '@admin/sponsor/index.html.twig';
        $builder->createTemplate       = '@admin/sponsor/create.html.twig';
        $builder->editTemplate         = '@admin/sponsor/edit.html.twig';
        $builder->listRouteName        = 'app_admin_sponsor_index';
        $builder->createRouteName      = 'app_admin_sponsor_create';
        $builder->defaultSortFieldName = 'p.position';
        $builder->defaultSortDirection = 'asc';
    }
}
