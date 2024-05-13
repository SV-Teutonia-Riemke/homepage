<?php

declare(strict_types=1);

namespace App\Twig\Components\Bootstrap\Card;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent(
    name: 'bs:card:footer',
    template: 'components/bs/card/footer.html.twig',
)]
class CardFooterComponent
{
}
