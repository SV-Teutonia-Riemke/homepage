<?php

declare(strict_types=1);

namespace App\Infrastructure\Menu\Type\Resolver;

use App\Storage\Entity\MenuItem;
use App\Storage\Repository\LinkRepository;
use Knp\Menu\FactoryInterface;
use Knp\Menu\ItemInterface;

class LinksResolver implements ResolverInterface
{
    public function __construct(
        private readonly LinkRepository $linkRepository,
    ) {
    }

    public function __invoke(
        MenuItem $menuItem,
        FactoryInterface $factory,
    ): ItemInterface {
        $links = $this->linkRepository->findEnabled();

        $linkItem = $factory->createItem($menuItem->getTitle(), [
            'dropdown' => true,
            'icon'     => $menuItem->getIcon(),
        ]);

        foreach ($links as $link) {
            $linkItem->addChild($link->getName(), [
                'uri'            => $link->getUri(),
                'linkAttributes' => [
                    'target' => '_blank',
                ],
            ]);
        }

        return $linkItem;
    }
}
