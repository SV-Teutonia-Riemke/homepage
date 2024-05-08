<?php

declare(strict_types=1);

namespace App\Infrastructure\Menu\Type\Resolver;

use App\Infrastructure\Asset\AssetUrlGenerator;
use App\Storage\Entity\MenuItem;
use App\Storage\Repository\DownloadRepository;
use Knp\Menu\FactoryInterface;
use Knp\Menu\ItemInterface;

class DownloadsResolver implements ResolverInterface
{
    public function __construct(
        private readonly DownloadRepository $downloadRepository,
        private readonly AssetUrlGenerator $assetUrlGenerator,
    ) {
    }

    public function __invoke(
        MenuItem $menuItem,
        FactoryInterface $factory,
    ): ItemInterface {
        $downloads    = $this->downloadRepository->findEnabled();
        $downloadItem = $factory->createItem($menuItem->getTitle(), [
            'dropdown' => true,
            'icon'     => $menuItem->getIcon(),
        ]);

        foreach ($downloads as $download) {
            $downloadLink = $download->getFile() === null
                ? $download->getUri()
                : $this->assetUrlGenerator->__invoke($download->getFile());

            $downloadItem->addChild($download->getName(), [
                'uri'            => $downloadLink,
                'linkAttributes' => [
                    'target' => '_blank',
                ],
            ]);
        }

        return $downloadItem;
    }
}
