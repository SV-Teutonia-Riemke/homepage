<?php

declare(strict_types=1);

namespace App\Twig\Extension;

use App\Infrastructure\Asset\AssetUrlGenerator;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

final class FileExtension extends AbstractExtension
{
    public function __construct(
        private readonly AssetUrlGenerator $assetUrlGenerator,
    ) {
    }

    /** @inheritDoc */
    public function getFilters(): array
    {
        return [
            new TwigFilter('file_url', $this->assetUrlGenerator->__invoke(...)),
        ];
    }

    /** @inheritDoc */
    public function getFunctions(): array
    {
        return [
            new TwigFunction('file_url', $this->assetUrlGenerator->__invoke(...)),
        ];
    }
}
