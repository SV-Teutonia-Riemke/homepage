<?php

declare(strict_types=1);

namespace App\Twig\Components\Pagination;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent(
    name: 'pagination:cta',
    template: 'components/pagination/cta.html.twig',
)]
class CallToActionComponent
{
    public string|null $up           = null;
    public string|null $down         = null;
    public bool|null $enabled        = null;
    public string|null $enable       = null;
    public string|null $disable      = null;
    public string|null $edit         = null;
    public string|null $remove       = null;
    public string|null $preElements  = null;
    public string|null $postElements = null;
}
