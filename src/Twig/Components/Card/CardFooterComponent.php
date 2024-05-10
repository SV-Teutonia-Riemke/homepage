<?php

declare(strict_types=1);

namespace App\Twig\Components\Card;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent(
    name: 'bs:card:footer',
    template: 'components/card/footer.html.twig',
)]
class CardFooterComponent
{
}
