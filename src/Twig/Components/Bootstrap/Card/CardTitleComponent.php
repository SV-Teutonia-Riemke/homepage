<?php

declare(strict_types=1);

namespace App\Twig\Components\Bootstrap\Card;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent(
    name: 'bs:card:title',
    template: 'components/bs/card/title.html.twig',
)]
class CardTitleComponent
{
    public string|null $title = null;

    public string|null $icon = null;
}
