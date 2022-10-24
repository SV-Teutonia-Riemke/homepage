<?php

declare(strict_types=1);

namespace App\Module\Page\Controller;

use App\Storage\Entity\Team;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

use function array_filter;
use function implode;

#[AsController]
#[Route('/team/{team}', name: 'app_team')]
#[Route('/team/{team}/{slug}', name: 'app_team_slug')]
final class TeamController extends AbstractController
{
    public function __construct(
        private readonly SluggerInterface $slugger,
    ) {
    }

    public function __invoke(
        Request $request,
        Team $team,
        string $slug = '',
    ): Response {
        $slugParts = array_filter([
            $team->getName(),
            $team->getSeason()?->__toString(),
        ]);

        $slugToBe = $this->slugger->slug(implode('/', $slugParts));

        if (! $slugToBe->equalsTo($slug)) {
            return $this->redirectToRoute('app_team_slug', [
                'team' => $team->getId(),
                'slug' => $slugToBe,
            ]);
        }

        return $this->render('@page/team/index.html.twig', [
            'team' => $team,
        ]);
    }
}
