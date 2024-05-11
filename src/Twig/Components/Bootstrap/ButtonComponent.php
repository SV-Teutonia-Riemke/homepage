<?php

declare(strict_types=1);

namespace App\Twig\Components\Bootstrap;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

use function sprintf;

#[AsTwigComponent(
    name: 'bs:button',
    template: 'components/bootstrap/button.html.twig',
)]
final class ButtonComponent
{
    public string $href;
    public string $type       = 'primary';
    public bool $outline      = false;
    public string|null $title = null;
    public string|null $icon  = null;

    /** @return list<string> */
    public function getDefaultClasses(): array
    {
        $type = $this->outline ? 'btn-outline-%s' : 'btn-%s';

        return [
            'btn',
            sprintf($type, $this->type),
        ];
    }
}
