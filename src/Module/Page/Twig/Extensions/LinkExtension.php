<?php

declare(strict_types=1);

namespace App\Module\Page\Twig\Extensions;

use App\Storage\Repository\LinkRepository;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

final class LinkExtension extends AbstractExtension
{
    public function __construct(
        private readonly LinkRepository $linkRepository,
    ) {
    }

    /** @inheritDoc */
    public function getFunctions(): array
    {
        return [
            new TwigFunction('links', fn () => $this->linkRepository->findEnabled()),
        ];
    }
}
