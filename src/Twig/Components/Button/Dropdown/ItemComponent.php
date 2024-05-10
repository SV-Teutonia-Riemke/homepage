<?php

declare(strict_types=1);

namespace App\Twig\Components\Button\Dropdown;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent(
    name: 'bs:button:dropdown:item',
    template: 'components/button/dropdown/item.html.twig',
)]
class ItemComponent
{
    public string $title;
    public string $href;
}
