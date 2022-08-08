<?php

declare(strict_types=1);

namespace App\Module\Page\Controller;

use App\Storage\Entity\Team;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Annotation\Route;

#[AsController]
#[Route('/team/{team}', name: 'app_team')]
final class TeamController extends AbstractController
{
    public function __invoke(Team $team): Response
    {
        return $this->render('page/team/index.html.twig', [
            'team' => $team,
        ]);
    }
}
