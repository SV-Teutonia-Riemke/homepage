<?php

declare(strict_types=1);

namespace App\Twig\Extension;

use App\Storage\Entity\Sponsor;
use App\Storage\Repository\SponsorRepository;
use Twig\Attribute\AsTwigFunction;

use function usort;

final readonly class SponsorExtension
{
    public function __construct(
        private SponsorRepository $sponsorRepository,
    ) {
    }

    /** @return array<Sponsor> */
    #[AsTwigFunction(name: 'sponsors')]
    public function findSponsors(): array
    {
        $sponsors = $this->sponsorRepository->findEnabled();
        usort(
            $sponsors,
            static fn (Sponsor $a, Sponsor $b): int => $a->getLevel()->order() <=> $b->getLevel()->order(),
        );

        return $sponsors;
    }
}
