<?php

declare(strict_types=1);

namespace App\Infrastructure\Menu\Type\Resolver;

use App\Storage\Entity\MenuItem;
use App\Storage\Entity\MenuItem\MenuItemPage;
use InvalidArgumentException;
use Knp\Menu\FactoryInterface;
use Knp\Menu\ItemInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class PageResolver implements ResolverInterface
{
    public function __construct(
        private readonly UrlGeneratorInterface $urlGenerator,
    ) {
    }

    public function __invoke(
        MenuItem $menuItem,
        FactoryInterface $factory,
    ): ItemInterface {
        if (! $menuItem instanceof MenuItemPage) {
            throw new InvalidArgumentException('Invalid menu item type');
        }

        $uri = $this->urlGenerator->generate('app_page_wo_slug', ['page' => $menuItem->getPage()->getId()]);

        return $factory->createItem($menuItem->getTitle(), [
            'uri' => $uri,
            'icon' => $menuItem->getIcon(),
        ]);
    }
}
