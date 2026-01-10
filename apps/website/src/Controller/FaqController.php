<?php

declare(strict_types=1);

namespace App\Website\Controller;

use App\Storage\Entity\FaqCategory;
use App\Storage\Repository\FaqArticleRepository;
use App\Storage\Repository\FaqCategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Routing\Requirement\Requirement;
use Symfony\Component\String\Slugger\SluggerInterface;

use function sprintf;

#[Route('/faq', name: 'faq_')]
class FaqController extends AbstractController
{
    public function __construct(
        private readonly FaqCategoryRepository $faqCategoryRepository,
        private readonly FaqArticleRepository $faqArticleRepository,
        private readonly SluggerInterface $slugger,
    ) {
    }

    #[Route('', name: 'index')]
    public function index(Request $request): Response
    {
        $category = $this->faqCategoryRepository->getFirst();
        if ($category === null) {
            throw $this->createNotFoundException();
        }

        return $this->forward(
            sprintf('%s::category', self::class),
            ['category' => $category->getId()],
        );
    }

    #[Route(
        path: '/category/{category}',
        name: 'category',
        requirements: ['category' => Requirement::DIGITS],
    )]
    #[Route(
        path: '/category/{category}-{slug}',
        name: 'category_slug',
        requirements: ['category' => Requirement::DIGITS, 'slug' => Requirement::ASCII_SLUG],
    )]
    public function category(
        Request $request,
        FaqCategory $category,
        string $slug = '',
    ): Response {
        if (! $category->isEnabled()) {
            throw $this->createNotFoundException();
        }

        $slugToBe = $category->getSlug($this->slugger);
        if (! $slugToBe->equalsTo($slug)) {
            return $this->redirectToRoute('app_faq_category_slug', [
                'category' => $category->getId(),
                'slug' => $slugToBe,
            ]);
        }

        $categories = $this->faqCategoryRepository->findEnabled();

        return $this->render('@page/faq/index.html.twig', [
            'category' => $category,
            'categories' => $categories,
            'articles' => $this->faqArticleRepository->findEnabledByCategory($category),
        ]);
    }
}
