<?php

declare(strict_types=1);

namespace App\Website\Controller;

use App\Storage\Repository\PersonGroupRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/verein', name: 'person_groups', options: ['sitemap' => true])]
final class PersonGroupController extends AbstractController
{
    public function __construct(
        private readonly PersonGroupRepository $personGroupRepository,
    ) {
    }

    public function __invoke(): Response
    {
        return $this->render('@page/person_group/index.html.twig', [
            'personGroups' => $this->personGroupRepository->findEnabled(),
        ]);
    }
}
