<?php

declare(strict_types=1);

namespace App\Twig\Extension;

use Knp\Component\Pager\Pagination\PaginationInterface;
use Twig\Environment;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;
use Twig\TwigTest;

final class PaginationExtension extends AbstractExtension
{
    /** @inheritDoc */
    public function getTests(): array
    {
        return [
            new TwigTest('pagination', static fn ($object): bool => $object instanceof PaginationInterface),
        ];
    }

    /** @inheritDoc */
    public function getFunctions(): array
    {
        return [
            new TwigFunction('pagination_cta', $this->callToAction(...), [
                'needs_environment' => true,
                'is_safe'           => ['html'],
            ]),
        ];
    }

    private function callToAction(
        Environment $twig,
        object $object,
        string|null $removeLink = null,
        string|null $editLink = null,
        string|null $enableLink = null,
        string|null $disableLink = null,
        string|null $preElements = null,
        string|null $postElements = null,
    ): string {
        return $twig->render('_partials/pagination_macro.html.twig', [
            'object'       => $object,
            'removeLink'   => $removeLink,
            'editLink'     => $editLink,
            'enableLink'   => $enableLink,
            'disableLink'  => $disableLink,
            'preElements'  => $preElements,
            'postElements' => $postElements,
        ]);
    }
}
