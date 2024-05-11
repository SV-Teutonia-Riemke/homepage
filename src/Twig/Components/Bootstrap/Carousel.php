<?php

declare(strict_types=1);

namespace App\Twig\Components\Bootstrap;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent(
    name: 'bs:carousel',
    template: 'components/bootstrap/carousel.html.twig',
)]
final class Carousel
{
    public string|null $id = null;

    /** @var array<int<0, max>, string> A list of image src links. Rendered as carousel items. */
    public array $items = [];

    /** @var bool Enables sliding. */
    public bool $slide = true;

    /** @var bool Enables controls. */
    public bool $controls = false;
}
