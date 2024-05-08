<?php

declare(strict_types=1);

namespace App\Infrastructure\Menu\Type\Resolver;

use App\Storage\Entity\MenuItem;
use App\Storage\Repository\TeamRepository;
use Knp\Menu\FactoryInterface;
use Knp\Menu\ItemInterface;

class TeamsResolver implements ResolverInterface
{
    public function __construct(
        private readonly TeamRepository $teamRepository,
    ) {
    }

    public function __invoke(
        MenuItem $menuItem,
        FactoryInterface $factory,
    ): ItemInterface {
        $seniorTeams = $this->teamRepository->findAllSeniors();
        $juniorTeams = $this->teamRepository->findAllJuniors();

        $teams = $factory->createItem($menuItem->getTitle(), [
            'dropdown' => true,
            'icon'     => $menuItem->getIcon(),
        ]);

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

        return $teams;
    }
}
