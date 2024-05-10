<?php

declare(strict_types=1);

namespace App\Twig\Components\Card;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent(
    name: 'bs:card:header',
    template: 'components/card/header.html.twig',
)]
class CardHeaderComponent
{
    public string|null $title = null;
}
