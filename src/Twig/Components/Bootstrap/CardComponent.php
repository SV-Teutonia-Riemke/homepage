<?php

declare(strict_types=1);

namespace App\Twig\Components\Bootstrap;

use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;
use Symfony\UX\TwigComponent\Attribute\PostMount;
use Symfony\UX\TwigComponent\Attribute\PreMount;

#[AsTwigComponent(
    name: 'bs:card',
    template: 'components/bs/card.html.twig',
)]
final class CardComponent
{
    public string|null $header = null;

    public string|null $body = null;

    public string|null $footer = null;

    public string|null $statusTop = null;

    /** @var array{ src ?: ?string, alt ?: ?string, title ?: ?string, position ?: "top" | "bottom" | "overlay" } */
    public array $image;

    public string|null $imageSrc = null;

    public string|null $imageAlt = null;

    public string|null $imageTitle = null;

    public string|null $stamp = null;

    /** @var "top"|"bottom"|"overlay" */
    public string $imagePosition;

    /**
     * @param array<string, string> $data
     *
     * @return array<string, string>
     */
    #[PreMount]
    public function validate(array $data): array
    {
        $resolver = new OptionsResolver();
        $resolver->setIgnoreUndefined();

        $resolver->setDefaults([
            'header' => null,
            'body' => null,
            'footer' => null,
            'statusTop' => 'primary',
            'image' => [],
            'imagePosition' => 'top',
            'imageSrc' => null,
            'imageAlt' => null,
            'imageTitle' => null,
            'stamp' => null,
        ]);

        $resolver->setAllowedTypes('header', ['null', 'string']);
        $resolver->setAllowedTypes('body', ['null', 'string']);
        $resolver->setAllowedTypes('footer', ['null', 'string']);
        $resolver->setAllowedTypes('statusTop', ['null', 'string']);
        $resolver->setAllowedTypes('image', ['null', 'array']);
        $resolver->setAllowedTypes('imageSrc', ['null', 'string']);
        $resolver->setAllowedTypes('imageAlt', ['null', 'string']);
        $resolver->setAllowedTypes('imageTitle', ['null', 'string']);
        $resolver->setAllowedTypes('stamp', ['null', 'string']);

        $resolver->setAllowedValues('imagePosition', ['top', 'bottom', 'overlay']);

        return [
            ...$data,
            ...$resolver->resolve($data),
        ];
    }

    #[PostMount]
    public function configureImages(): void
    {
        // top image
        if ($this->imageSrc !== null) {
            return;
        }

        $this->image = [
            'src' => $this->imageSrc,
            'class' => 'card-img' . ($this->imagePosition !== 'overlay' ? '-' . $this->imagePosition : ''),
            'position' => $this->imagePosition,
        ];

        if ($this->imageAlt !== null) {
            $this->image['alt'] = $this->imageAlt;
        }

        if ($this->imageTitle === null) {
            return;
        }

        $this->image['title'] = $this->imageTitle;
    }
}
