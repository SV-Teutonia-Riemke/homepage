<?php

declare(strict_types=1);

namespace App\Infrastructure\Menu\Type\Resolver;

use App\Storage\Entity\MenuItem;
use App\Storage\Entity\MenuItem\MenuItemUrl;
use InvalidArgumentException;
use Knp\Menu\FactoryInterface;
use Knp\Menu\ItemInterface;

class UrlResolver implements ResolverInterface
{
    public function __invoke(
        MenuItem $menuItem,
        FactoryInterface $factory,
    ): ItemInterface {
        if (! $menuItem instanceof MenuItemUrl) {
            throw new InvalidArgumentException('Invalid menu item type');
        }

        return $factory->createItem($menuItem->getTitle(), [
            'uri'            => $menuItem->getUrl(),
            'linkAttributes' => [
                'target' => '_blank',
            ],
            'icon' => $menuItem->getIcon(),
        ]);
    }
}
