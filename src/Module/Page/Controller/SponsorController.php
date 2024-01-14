<?php

declare(strict_types=1);

namespace App\Module\Page\Controller;

use App\Domain\SponsorLevel;
use App\Storage\Repository\SponsorRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Attribute\Route;

use function uksort;

#[AsController]
#[Route('/sponsoren', name: 'app_sponsor')]
final class SponsorController extends AbstractController
{
    public function __construct(
        private readonly SponsorRepository $sponsorRepository,
    ) {
    }

    public function __invoke(): Response
    {
        $sponsors = $this->sponsorRepository->findEnabled();

        $levels = [];

        foreach ($sponsors as $sponsor) {
            $levels[$sponsor->getLevel()->value][] = $sponsor;
        }

        uksort(
            $levels,
            static fn (string $a, string $b): int => SponsorLevel::from($a)->order() <=> SponsorLevel::from($b)->order()
        );

        return $this->render('@page/sponsor/index.html.twig', [
            'levels' => $levels,
        ]);
    }
}
