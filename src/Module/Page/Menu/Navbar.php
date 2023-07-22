<?php

declare(strict_types=1);

namespace App\Module\Page\Menu;

use App\Infrastructure\Asset\AssetUrlGenerator;
use App\Storage\Repository\DownloadRepository;
use App\Storage\Repository\LinkRepository;
use App\Storage\Repository\TeamRepository;
use Knp\Menu\FactoryInterface;
use Knp\Menu\ItemInterface;
use Symfony\Component\Asset\Package;
use Symfony\Component\DependencyInjection\Attribute\Autowire;

use function count;

final class Navbar
{
    public function __construct(
        private readonly FactoryInterface $factory,
        private readonly AssetUrlGenerator $assetUrlGenerator,
        private readonly TeamRepository $teamRepository,
        private readonly LinkRepository $linkRepository,
        private readonly DownloadRepository $downloadRepository,
        #[Autowire(service: 'assets._default_package')]
        private readonly Package $package,
    ) {
    }

    public function main(): ItemInterface
    {
        $seniorTeams = $this->teamRepository->findAllSeniors();
        $juniorTeams = $this->teamRepository->findAllJuniors();

        $menu = $this->factory->createItem('root');

        $menu->addChild('Startseite', [
            'route' => 'app_index',
            'icon'  => 'fa6-solid:house',
        ]);

        $teams = $this->factory->createItem('Mannschaften', [
            'dropdown' => true,
            'icon'     => 'fa6-solid:users',
        ]);
        $menu->addChild($teams);

        foreach ($seniorTeams as $team) {
            $teams->addChild($team->getName(), [
                'route'           => 'app_team',
                'routeParameters' => [
                    'team' => $team->getId(),
                ],
            ]);
        }

        foreach ($juniorTeams as $key => $team) {
            $teams->addChild($team->getName(), [
                'route'           => 'app_team',
                'routeParameters' => [
                    'team' => $team->getId(),
                ],
                'attributes'      => [
                    'divider_prepend' => $key === 0,
                ],
            ]);
        }

        $menu->addChild('Verein', [
            'route' => 'app_person_groups',
            'icon'  => 'fa6-solid:people-group',
        ]);

        $menu->addChild('Shop', [
            'uri'            => 'https://svtr.link/clubshop',
            'linkAttributes' => [
                'target' => '_blank',
            ],
            'icon'           => 'fa6-solid:basket-shopping',
        ]);

        $menu->addChild('Sponsoren', [
            'route' => 'app_sponsor',
            'icon'  => 'fa6-solid:handshake-simple',
        ]);

        $menu->addChild('Trainingszeiten', [
            'icon'           => 'fa6-solid:calendar-day',
            'uri'            => 'https://svtr.link/trainingszeiten',
            'linkAttributes' => [
                'target' => '_blank',
            ],
        ]);

        $menu->addChild('Aufnahmeantrag', [
            'icon'           => 'fa6-solid:file-contract',
            'uri'            => $this->package->getUrl('build/documents/aufnahmeantrag.pdf'),
            'linkAttributes' => [
                'target' => '_blank',
            ],
        ]);

        $menu->addChild('Ruhr Cup', [
            'icon'  => 'fa6-solid:trophy',
            'route' => 'app_ruhr_cup',
        ]);

        $links = $this->linkRepository->findEnabled();
        if (count($links) > 0) {
            $linkItem = $this->factory->createItem('Links', [
                'dropdown' => true,
                'icon'     => 'fa6-solid:link',
            ]);

            foreach ($links as $link) {
                $linkItem->addChild($link->getName(), [
                    'uri'            => $link->getUri(),
                    'linkAttributes' => [
                        'target' => '_blank',
                    ],
                ]);
            }

            $menu->addChild($linkItem);
        }

        $downloads = $this->downloadRepository->findEnabled();
        if (count($downloads) > 0) {
            $downloadItem = $this->factory->createItem('Downloads', [
                'dropdown' => true,
                'icon'     => 'fa6-solid:download',
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

            $menu->addChild($downloadItem);
        }

        $menu->addChild('Zur alten Webseite / Archiv', [
            'icon'           => 'fa6-solid:box-archive',
            'uri'            => 'https://legacy.teutonia-riemke.de/',
            'attributes'     => [
                'class' => 'd-md-none',
            ],
            'linkAttributes' => [
                'target' => '_blank',
            ],
        ]);

        $menu->addChild('Spenden', [
            'icon'           => 'fa6-solid:heart',
            'uri'            => 'https://svtr.link/spenden',
            'attributes'     => [
                'class' => 'd-md-none',
            ],
            'linkAttributes' => [
                'target' => '_blank',
            ],
        ]);

        return $menu;
    }
}
