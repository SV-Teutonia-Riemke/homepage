<?php

declare(strict_types=1);

namespace App\Twig\Components\Bootstrap\Card;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent(
    name: 'bs:card:actions',
    template: 'components/bs/card/actions.html.twig',
)]
class CardActionsComponent
{
}
