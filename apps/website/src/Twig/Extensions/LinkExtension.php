<?php

declare(strict_types=1);

namespace App\Website\Twig\Extensions;

use App\Storage\Repository\LinkRepository;
use Override;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

final class LinkExtension extends AbstractExtension
{
    public function __construct(
        private readonly LinkRepository $linkRepository,
    ) {
    }

    /** @inheritDoc */
    #[Override]
    public function getFunctions(): array
    {
        return [
            new TwigFunction('links', fn (): array => $this->linkRepository->findEnabled()),
        ];
    }
}
