<?php

declare(strict_types=1);

namespace App\Module\Admin\Controller;

use App\Domain\Role;
use App\Module\Admin\Crud\CrudConfigBuilder;
use App\Module\Admin\Crud\Handler\FullHandler;
use App\Module\Admin\Crud\Handler\PositionHandler;
use App\Module\Admin\Form\Type\Forms\LinkType;
use App\Storage\Entity\Link;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

/** @template-extends AbstractCrudController<Link, LinkType, null> */
#[IsGranted(Role::MANAGE_LINKS->value)]
#[Route('/link', name: 'link_')]
final class LinkController extends AbstractCrudController
{
    use FullHandler;
    use PositionHandler;

    protected function configureCrudConfig(
        CrudConfigBuilder $builder,
        Request $request,
    ): void {
        $builder->setMandatory(
            Link::class,
            'link',
        );

        $builder->defaultSortFieldName = 'p.position';
        $builder->defaultSortDirection = 'asc';
    }

    protected function getFormType(
        Request $request,
        object|null $object = null,
    ): string {
        return LinkType::class;
    }
}
