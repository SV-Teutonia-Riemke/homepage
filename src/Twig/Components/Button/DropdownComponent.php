<?php

declare(strict_types=1);

namespace App\Twig\Components\Button;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent(
    name: 'bs:button:dropdown',
    template: 'components/button/dropdown.html.twig',
)]
class DropdownComponent
{
    public string $title;
    public string|null $type = null;
}
