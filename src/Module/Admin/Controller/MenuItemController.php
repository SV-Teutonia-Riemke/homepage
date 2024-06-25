<?php

declare(strict_types=1);

namespace App\Module\Admin\Controller;

use App\Domain\Role;
use App\Infrastructure\Menu\MenuType;
use App\Module\Admin\Crud\CrudConfigBuilder;
use App\Module\Admin\Crud\Handler\FullHandler;
use App\Module\Admin\Crud\Handler\PositionHandler;
use App\Module\Admin\Form\Type\Forms\MenuItemPageType;
use App\Module\Admin\Form\Type\Forms\MenuItemType;
use App\Module\Admin\Form\Type\Forms\MenuItemUrlType;
use App\Storage\Entity\MenuItem;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

/** @template-extends AbstractCrudController<MenuItem> */
#[AsController]
#[IsGranted(Role::MANAGE_MENU->value)]
#[Route('/menu', name: 'menu_item_')]
final class MenuItemController extends AbstractCrudController
{
    use FullHandler;
    use PositionHandler;

    protected function configureCrudConfig(CrudConfigBuilder $builder, Request $request): void
    {
        $builder->setMandatory(
            MenuItem::class,
            'menu_item',
        );
        $builder->defaultSortFieldName = 'p.position';
        $builder->defaultSortDirection = 'asc';
    }

    protected function getFormType(Request $request, object|null $object = null): string
    {
        if ($object instanceof MenuItem) {
            return match ($object->getType()) {
                MenuType::PAGE => MenuItemPageType::class,
                MenuType::URL => MenuItemUrlType::class,
                default => MenuItemType::class,
            };
        }

        $type = $request->get('type');

        return match ($type) {
            'page' => MenuItemPageType::class,
            'url' => MenuItemUrlType::class,
            default => MenuItemType::class,
        };
    }
}
