<?php

declare(strict_types=1);

namespace App\Twig\Components\Bootstrap\Button;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent(
    name: 'bs:button:group',
    template: 'components/bs/button/group.html.twig',
)]
final class GroupComponent
{
    public string|null $size = null;
}
