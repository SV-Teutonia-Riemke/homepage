<?php

declare(strict_types=1);

namespace App\Twig\Extension;

use App\Infrastructure\ImgProxy\ImgProxy;
use App\Infrastructure\ImgProxy\Options\Quality;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

class ImageProxyExtension extends AbstractExtension
{
    public function __construct(
        private readonly ImgProxy $imgProxy,
    ) {
    }

    /** @inheritDoc */
    public function getFunctions(): array
    {
        return [
            new TwigFunction('imgproxy', $this->imgproxy(...)),
        ];
    }

    /** @inheritDoc */
    public function getFilters(): array
    {
        return [
            new TwigFilter('imgproxy', $this->imgproxy(...)),
        ];
    }

    public function imgproxy(
        string $path,
    ): string {
        return $this->imgProxy
            ->image($path)
            ->encoded(true)
            ->with(
                new Quality(20),
            )
            ->__toString();
    }
}
