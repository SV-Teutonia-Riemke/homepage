<?php

declare(strict_types=1);

namespace App\Twig\Components\Bootstrap;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

use function implode;
use function sprintf;

#[AsTwigComponent(
    name: 'bs:col',
    template: 'components/bs/col.html.twig',
)]
class ColComponent
{
    public int|null $col = 12;

    public int|null $lg = null;

    public int|null $md = null;

    public int|null $sm = null;

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
        $classes = [];

        $classes[] = $this->col === null ? 'col' : sprintf('col-%d', $this->col);

        if ($this->lg !== null) {
            $classes[] = sprintf('col-lg-%d', $this->lg);
        }

        if ($this->md !== null) {
            $classes[] = sprintf('col-md-%d', $this->md);
        }

        if ($this->sm !== null) {
            $classes[] = sprintf('col-sm-%d', $this->sm);
        }

        return $classes;
    }
}
