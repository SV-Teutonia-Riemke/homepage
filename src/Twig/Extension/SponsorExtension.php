<?php

declare(strict_types=1);

namespace App\Twig\Extension;

use App\Storage\Entity\Sponsor;
use App\Storage\Repository\SponsorRepository;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

use function usort;

class SponsorExtension extends AbstractExtension
{
    public function __construct(
        private readonly SponsorRepository $sponsorRepository,
    ) {
    }

    /** @inheritDoc */
    public function getFunctions(): array
    {
        return [
            new TwigFunction('sponsors', $this->findSponsors(...)),
        ];
    }

    /** @return array<Sponsor> */
    private function findSponsors(): array
    {
        $sponsors = $this->sponsorRepository->findEnabled();
        usort(
            $sponsors,
            static fn (Sponsor $a, Sponsor $b): int => $a->getLevel()->order() <=> $b->getLevel()->order(),
        );

        return $sponsors;
    }
}
