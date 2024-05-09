<?php

declare(strict_types=1);

namespace App\Module\Page\Controller;

use App\Storage\Entity\Page;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Routing\Requirement\Requirement;
use Symfony\Component\String\Slugger\SluggerInterface;

#[AsController]
#[Route(
    path: '/p/{page}',
    name: 'page',
    requirements: [
        'page' => Requirement::POSITIVE_INT,
    ],
    methods: [Request::METHOD_GET],
)]
final class PageController extends AbstractController
{
    public function __construct(
        private readonly SluggerInterface $slugger,
    ) {
    }

    #[Route(
        path: '-{slug}',
        name: '',
        options: [
            'sitemap' => true,
            'section' => 'page',
        ],
    )]
    public function news(Page $page, string $slug): Response
    {
        if (! $page->isEnabled()) {
            throw $this->createNotFoundException();
        }

        $slugToBe = $page->getSlug($this->slugger);

        if (! $slugToBe->equalsTo($slug)) {
            return $this->redirectToRoute(
                'app_page',
                [
                    'page' => $page->getId(),
                    'slug' => $slugToBe,
                ],
            );
        }

        return $this->render(
            '@page/page/index.html.twig',
            [
                'page' => $page,
                'pageContent' => $this->renderView($page->getContent()),
            ],
        );
    }

    #[Route(
        path: '',
        name: '_wo_slug',
    )]
    public function article(Page $page): Response
    {
        return $this->redirectToRoute(
            'app_page',
            [
                'page' => $page->getId(),
                'slug' => $page->getSlug($this->slugger),
            ],
        );
    }
}
