<?php

declare(strict_types=1);

namespace App\Module\Page\Menu;

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
        private readonly TeamRepository $teamRepository,
        #[Autowire(service: 'assets._default_package')] private readonly Package $package,
    ) {
    }

    public function main(): ItemInterface
    {
        $seniorTeams = $this->teamRepository->findAllSeniors();
        $juniorTeams = $this->teamRepository->findAllJuniors();

        $menu = $this->factory->createItem('root');

        $menu->addChild('Home', [
            'route' => 'app_index',
            'icon'  => 'fa6-solid:house',
        ]);

        if (count($seniorTeams) > 0) {
            $teamSeniors = $this->factory->createItem('Senioren', [
                'dropdown' => true,
                'icon'     => 'fa6-solid:person-cane',
            ]);

            foreach ($seniorTeams as $team) {
                $teamSeniors->addChild($team->getName(), [
                    'route'           => 'app_team',
                    'routeParameters' => [
                        'team' => $team->getId(),
                    ],
                ]);
            }

            $menu->addChild($teamSeniors);
        }

        if (count($juniorTeams) > 0) {
            $teamJuniors = $this->factory->createItem('Junioren', [
                'dropdown' => true,
                'icon'     => 'fa6-solid:child',
            ]);

            foreach ($juniorTeams as $team) {
                $teamJuniors->addChild($team->getName(), [
                    'route'           => 'app_team',
                    'routeParameters' => [
                        'team' => $team->getId(),
                    ],
                ]);
            }

            $menu->addChild($teamJuniors);
        }

        $menu->addChild('Teams', [
            'route' => 'app_person_groups',
            'icon'  => 'fa6-solid:people-group',
        ]);

        $menu->addChild('Trainingszeiten', [
            'icon'           => 'fa6-solid:calendar-day',
            'uri'            => $this->package->getUrl('build/documents/trainingszeiten.pdf'),
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

        return $menu;
    }
}
