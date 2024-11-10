<?php

declare(strict_types=1);

namespace App\Twig\Components\Bootstrap\Card;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent(
    name: 'bs:card:header',
    template: 'components/bs/card/header.html.twig',
)]
class CardHeaderComponent
{
    public string|null $title = null;

    public string|null $icon = null;
}
