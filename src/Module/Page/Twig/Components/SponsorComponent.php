<?php

declare(strict_types=1);

namespace App\Module\Page\Twig\Components;

use App\Storage\Entity\Sponsor;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

use function sprintf;

#[AsTwigComponent(
    name: 'sponsor',
    template: '@page/_components/sponsor.html.twig',
)]
class SponsorComponent
{
    public Sponsor $sponsor;
    public int|null $mainColumn    = null;
    public int|null $defaultColumn = null;
    public string $mainFilter;
    public string $defaultFilter;
    public string $defaultBackgroundColor = '#ffffff';

    /** @return array<string, mixed> */
    public function getDefaultAttributes(): array
    {
        $attributes = [];

        if ($this->getColumn() !== null) {
            $attributes['class'] = sprintf('col-%d', $this->getColumn());
        }

        return $attributes;
    }

    private function getColumn(): int|null
    {
        if ($this->mainColumn === null || $this->defaultColumn === null) {
            return null;
        }

        return $this->sponsor->getLevel()->isMain() ? $this->mainColumn : $this->defaultColumn;
    }

    public function getFilterName(): string
    {
        return $this->sponsor->getLevel()->isMain() ? $this->mainFilter : $this->defaultFilter;
    }
}
