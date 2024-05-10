<?php

declare(strict_types=1);

namespace App\Twig\Components\Card;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent(
    name: 'bs:card:body',
    template: 'components/card/body.html.twig',
)]
final class CardBodyComponent
{
}
