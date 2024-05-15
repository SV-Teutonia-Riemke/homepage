<?php

declare(strict_types=1);

namespace App\Module\Admin\Controller;

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

/** @template-extends AbstractCrudController<MenuItem> */
#[AsController]
#[Route('/menu', name: 'menu_item_')]
final class MenuItemController extends AbstractCrudController
{
    use FullHandler;
    use PositionHandler;

    protected function configureCrudConfig(CrudConfigBuilder $builder): void
    {
        $builder->setDefaults();
        $builder->dtoClass             = MenuItem::class;
        $builder->listTemplate         = '@admin/menu_item/index.html.twig';
        $builder->createTemplate       = '@admin/menu_item/create.html.twig';
        $builder->editTemplate         = '@admin/menu_item/edit.html.twig';
        $builder->listRouteName        = 'app_admin_menu_item_index';
        $builder->createRouteName      = 'app_admin_menu_item_create';
        $builder->formType             = $this->getFormType(...);
        $builder->defaultSortFieldName = 'p.position';
        $builder->defaultSortDirection = 'asc';
    }

    private function getFormType(Request $request, MenuItem|null $menuItem = null): string
    {
        if ($menuItem !== null) {
            return match ($menuItem->getType()) {
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
