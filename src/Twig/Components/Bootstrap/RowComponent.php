<?php

declare(strict_types=1);

namespace App\Twig\Components\Bootstrap;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

use function implode;

#[AsTwigComponent(
    name: 'bs:row',
    template: 'components/bs/row.html.twig',
)]
class RowComponent
{
    public bool $cards = false;

    /** @return array<string, string> */
    public function getDefaults(): array
    {
        return [
            'class' => implode(' ', $this->getClasses()),
        ];
    }

    /** @return list<string> */
    public function getClasses(): array
    {
        $classes = [
            'row',
        ];

        if ($this->cards) {
            $classes[] = 'row-cards';
        }

        return $classes;
    }
}
