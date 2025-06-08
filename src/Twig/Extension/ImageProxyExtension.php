<?php

declare(strict_types=1);

namespace App\Twig\Extension;

use App\Infrastructure\ImgProxy\PresetManager;
use Nicklog\ImgProxy\ImgProxy;
use Nicklog\ImgProxy\Options\AbstractOption;
use Twig\Attribute\AsTwigFilter;
use Twig\Attribute\AsTwigFunction;

use function count;

final readonly class ImageProxyExtension
{
    public function __construct(
        private ImgProxy $imgProxy,
        private PresetManager $presetManager,
    ) {
    }

    /** @param list<AbstractOption> $options */
    #[AsTwigFilter('imgproxy')]
    #[AsTwigFunction('imgproxy')]
    public function imgproxy(
        string $path,
        string|null $presetName = null,
        bool $useExtension = false,
        array $options = [],
    ): string {
        $builder = $this->imgProxy->urlBuilder($path);

        if ($presetName !== null && $this->presetManager->has($presetName)) {
            $preset  = $this->presetManager->get($presetName);
            $builder = $builder->withPreset($preset);
        }

        if (count($options) > 0) {
            $builder = $builder->with(...$options);
        }

        $builder = $builder->useExtension($useExtension);

        return $builder->__toString();
    }
}
