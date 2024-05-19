<?php

declare(strict_types=1);

namespace App\Infrastructure\Menu\Type\Resolver;

use App\Infrastructure\Shlink\ShortUrlProvider;
use App\Storage\Entity\MenuItem;
use App\Storage\Repository\LinkRepository;
use Knp\Menu\FactoryInterface;
use Knp\Menu\ItemInterface;

class LinksResolver implements ResolverInterface
{
    public function __construct(
        private readonly LinkRepository $linkRepository,
        private readonly ShortUrlProvider $shortUrlProvider,
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
            $uri = $this->shortUrlProvider->getShortUrl($link->getUri(), ['link']);

            $linkItem->addChild($link->getName(), [
                'uri'            => $uri,
                'linkAttributes' => [
                    'target' => '_blank',
                ],
            ]);
        }

        return $linkItem;
    }
}
