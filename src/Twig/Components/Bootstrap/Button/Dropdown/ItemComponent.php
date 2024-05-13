<?php

declare(strict_types=1);

namespace App\Twig\Components\Bootstrap\Button\Dropdown;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent(
    name: 'bs:button:dropdown:item',
    template: 'components/bs/button/dropdown/item.html.twig',
)]
class ItemComponent
{
    public string $title;
    public string $href;
}
