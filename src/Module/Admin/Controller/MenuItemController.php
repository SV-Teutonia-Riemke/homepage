<?php

declare(strict_types=1);

namespace App\Module\Admin\Controller;

use App\Infrastructure\Menu\MenuType;
use App\Module\Admin\Crud\CrudConfig;
use App\Module\Admin\Form\Type\Forms\MenuItemPageType;
use App\Module\Admin\Form\Type\Forms\MenuItemType;
use App\Module\Admin\Form\Type\Forms\MenuItemUrlType;
use App\Storage\Entity\MenuItem;
use App\Storage\Repository\MenuItemRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Attribute\Route;

/** @template-extends AbstractCrudController<MenuItem> */
#[AsController]
#[Route('/menu', name: 'menu_item_')]
final class MenuItemController extends AbstractCrudController
{
    public function __construct(
        private readonly MenuItemRepository $menuItemRepository,
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

    #[Route('/{menuItem}/edit', name: 'edit')]
    public function edit(Request $request, MenuItem $menuItem): Response
    {
        return $this->handleEdit($request, $menuItem);
    }

    #[Route('/{menuItem}/remove', name: 'remove')]
    public function remove(MenuItem $menuItem): Response
    {
        return $this->handleRemove($menuItem);
    }

    #[Route('/{menuItem}/enable', name: 'enable', defaults: ['enabled' => true])]
    #[Route('/{menuItem}/disable', name: 'disable', defaults: ['enabled' => false])]
    public function changeEnabled(MenuItem $menuItem, bool $enabled): Response
    {
        return $this->handleEnabled($menuItem, $enabled);
    }

    #[Route('/{menuItem}/up', name: 'up', defaults: ['position' => -1])]
    #[Route('/{menuItem}/down', name: 'down', defaults: ['position' => 1])]
    public function position(MenuItem $menuItem, int $position): Response
    {
        return $this->handlePosition($menuItem, $position);
    }

    protected function getCrudConfig(): CrudConfig
    {
        return new CrudConfig(
            $this->menuItemRepository,
            '@admin/menu_item/index.html.twig',
            '@admin/menu_item/create.html.twig',
            '@admin/menu_item/edit.html.twig',
            'app_admin_menu_item_index',
            'app_admin_menu_item_create',
            static function (Request $request, MenuItem|null $menuItem = null): string {
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
            },
            defaultSortFieldName: 'p.position',
            defaultSortDirection: 'asc',
        );
    }
}
