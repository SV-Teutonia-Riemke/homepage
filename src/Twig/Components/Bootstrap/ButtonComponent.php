<?php

declare(strict_types=1);

namespace App\Twig\Components\Bootstrap;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

use function implode;
use function sprintf;

#[AsTwigComponent(
    name: 'bs:button',
    template: 'components/bs/button.html.twig',
)]
final class ButtonComponent
{
    public string|null $href = null;

    public string $variant = 'primary';

    public bool $outline = false;

    public string|null $title = null;

    public string|null $icon = null;

    public bool $confirmation = false;

    public string|null $size = null;

    public string|null $tooltip = null;

    /** @return list<string> */
    public function getDefaultClasses(): array
    {
        $type = $this->outline ? 'btn-outline-%s' : 'btn-%s';

        $classes = [
            'btn',
            sprintf($type, $this->variant),
        ];

        if ($this->icon !== null && $this->title === null) {
            $classes[] = 'btn-icon';
        }

        if ($this->size !== null) {
            $classes[] = sprintf('btn-%s', $this->size);
        }

        return $classes;
    }

    public function getRootTag(): string
    {
        return $this->href !== null ? 'a' : 'button';
    }

    /** @return array<string, string> */
    public function getDefaults(): array
    {
        $defaults = [
            'class' => implode(' ', $this->getDefaultClasses()),
        ];

        if ($this->href !== null) {
            $defaults['href'] = $this->href;
        }

        if ($this->tooltip !== null) {
            $defaults['data-bs-toggle']    = 'tooltip';
            $defaults['data-bs-placement'] = 'top';
            $defaults['title']             = $this->tooltip;
        }

        return $defaults;
    }
}
