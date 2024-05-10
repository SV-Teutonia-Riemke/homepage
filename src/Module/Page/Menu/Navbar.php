<?php

declare(strict_types=1);

namespace App\Module\Page\Menu;

use App\Infrastructure\Menu\MenuGroup;
use App\Infrastructure\Menu\Type\TypeResolver;
use App\Storage\Repository\MenuItemRepository;
use Knp\Menu\FactoryInterface;
use Knp\Menu\ItemInterface;

final class Navbar
{
    public function __construct(
        private readonly FactoryInterface $factory,
        private readonly MenuItemRepository $menuItemRepository,
        private readonly TypeResolver $typeResolver,
    ) {
    }

    public function main(): ItemInterface
    {
        $menuItems = $this->menuItemRepository->findByGroupAndEnabled(MenuGroup::MAIN);

        $menu = $this->factory->createItem('root');

        foreach ($menuItems as $menuItem) {
            $menu->addChild(
                $this->typeResolver->resolve($menuItem),
            );
        }

        return $menu;
    }
}
