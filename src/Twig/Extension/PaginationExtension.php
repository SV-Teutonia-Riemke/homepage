<?php

declare(strict_types=1);

namespace App\Twig\Extension;

use Knp\Component\Pager\Pagination\PaginationInterface;
use Twig\Attribute\AsTwigFunction;
use Twig\Attribute\AsTwigTest;
use Twig\Environment;

final readonly class PaginationExtension
{
    #[AsTwigTest('pagination')]
    public function isPagination(mixed $object): bool
    {
        return $object instanceof PaginationInterface;
    }

    #[AsTwigFunction(
        name: 'pagination_cta',
        needsEnvironment: true,
        isSafe: ['html'],
    )]
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
