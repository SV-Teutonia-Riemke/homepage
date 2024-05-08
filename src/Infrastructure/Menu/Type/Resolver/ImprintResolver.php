<?php

declare(strict_types=1);

namespace App\Infrastructure\Menu\Type\Resolver;

use App\Storage\Entity\MenuItem;
use Knp\Menu\FactoryInterface;
use Knp\Menu\ItemInterface;

class ImprintResolver implements ResolverInterface
{
    public function __invoke(
        MenuItem $menuItem,
        FactoryInterface $factory,
    ): ItemInterface {
        return $factory->createItem($menuItem->getTitle(), [
            'route' => 'app_imprint',
            'icon' => $menuItem->getIcon(),
        ]);
    }
}
