<?php

declare(strict_types=1);

namespace App\Twig\Extension;

use App\Infrastructure\ImgProxy\ImgProxy;
use App\Infrastructure\ImgProxy\Options\AbstractOption;
use App\Infrastructure\ImgProxy\PresetManager;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

use function count;

class ImageProxyExtension extends AbstractExtension
{
    public function __construct(
        private readonly ImgProxy $imgProxy,
        private readonly PresetManager $presetManager,
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
        string|null $presetName = null,
        AbstractOption ...$options,
    ): string {
        $builder = $this->imgProxy->builder($path);

        if ($presetName !== null && $this->presetManager->has($presetName)) {
            $preset  = $this->presetManager->get($presetName);
            $builder = $builder->withPreset($preset);
        }

        if (count($options) > 0) {
            $builder = $builder->with(...$options);
        }

        return $builder->__toString();
    }
}
