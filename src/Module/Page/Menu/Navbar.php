<?php

declare(strict_types=1);

namespace App\Module\Page\Menu;

use App\Storage\Repository\TeamRepository;
use Knp\Menu\FactoryInterface;
use Knp\Menu\ItemInterface;

final class Navbar
{
    public function __construct(
        private readonly FactoryInterface $factory,
        private readonly TeamRepository $teamRepository,
    ) {
    }

    public function main(): ItemInterface
    {
        $seniorTeams = $this->teamRepository->findAllSeniors();
        $juniorTeams = $this->teamRepository->findAllJuniors();

        $menu = $this->factory->createItem('root');

        $menu->addChild('Home', [
            'route' => 'app_index',
            'icon'  => 'tabler:home',
        ]);

        $teamSeniors = $this->factory->createItem('Senioren', [
            'dropdown' => true,
            'icon'     => 'tabler:home',
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

        $teamJuniors = $this->factory->createItem('Junioren', [
            'dropdown' => true,
            'icon'     => 'tabler:home',
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

//        $menu->addChild('Sponsoren', [
//            'route' => 'app_index',
//            'icon'  => 'tabler:home',
//        ]);

        $menu->addChild('Teams', [
            'route' => 'app_index',
            'icon'  => 'tabler:home',
        ]);

//        $menu->addChild('Infos', [
//            'route' => 'app_index',
//            'icon'  => 'tabler:home',
//        ]);

        return $menu;
    }
}
