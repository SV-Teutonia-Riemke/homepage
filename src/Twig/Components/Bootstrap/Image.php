<?php

declare(strict_types=1);

namespace App\Twig\Components\Bootstrap;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;
use Symfony\UX\TwigComponent\Attribute\PostMount;

use function ksort;

#[AsTwigComponent(
    name: 'bs:img',
    template: 'components/bs/image.html.twig',
)]
class Image
{
    /**
     * @param array<string, string> $data
     *
     * @return array<string, string>
     */
    #[PostMount]
    public function configureAttributes(array $data): array
    {
        $data = [
            'class' => 'img-fluid',
            ...$data,
        ];
        ksort($data);

        return $data;
    }
}
