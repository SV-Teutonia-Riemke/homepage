<?php

declare(strict_types=1);

namespace App\Twig\Components\Bootstrap;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent(
    name: 'bs:alert',
    template: 'components/bs/alert.html.twig',
)]
final class AlertComponent
{
    public string|null $message = null;
    public string|null $title   = null;
    public string $type         = 'info';
    public string|null $icon    = null;
    public bool $important      = false;

    public function getBackgroundClass(): string
    {
        return $this->important ? 'alert-important' : 'bg-white';
    }
}
