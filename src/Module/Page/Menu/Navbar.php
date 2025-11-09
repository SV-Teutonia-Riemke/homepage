<?php

declare(strict_types=1);

namespace App\Module\Page\Menu;

use App\Infrastructure\Menu\MenuGroup;
use App\Infrastructure\Menu\Type\TypeResolver;
use App\Storage\Repository\MenuItemRepository;
use Knp\Menu\FactoryInterface;
use Knp\Menu\ItemInterface;
use Symfony\Component\DependencyInjection\Attribute\AutoconfigureTag;

#[AutoconfigureTag(
    'knp_menu.menu_builder',
    [
        'method' => 'main',
        'alias' => 'main',
    ],
)]
final readonly class Navbar
{
    public function __construct(
        private FactoryInterface $factory,
        private MenuItemRepository $menuItemRepository,
        private TypeResolver $typeResolver,
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
