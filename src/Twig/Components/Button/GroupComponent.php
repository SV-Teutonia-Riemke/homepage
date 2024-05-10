<?php

declare(strict_types=1);

namespace App\Twig\Components\Button;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent(
    name: 'bs:button:group',
    template: 'components/button/group.html.twig',
)]
final class GroupComponent
{
    public string|null $size = null;
}
