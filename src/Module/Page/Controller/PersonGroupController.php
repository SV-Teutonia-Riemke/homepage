<?php

declare(strict_types=1);

namespace App\Module\Page\Controller;

use App\Storage\Repository\PersonGroupRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Attribute\Route;

#[AsController]
#[Route('/person-groups', name: 'app_person_groups')]
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
