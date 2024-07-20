<?php

declare(strict_types=1);

namespace App\Module\Page\Controller;

use App\Storage\Entity\FaqCategory;
use App\Storage\Repository\FaqArticleRepository;
use App\Storage\Repository\FaqCategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Attribute\Route;

use function sprintf;

#[AsController]
#[Route('/faq', name: 'faq_')]
class FaqController extends AbstractController
{
    public function __construct(
        private readonly FaqCategoryRepository $faqCategoryRepository,
        private readonly FaqArticleRepository $faqArticleRepository,
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

    #[Route('/category/{category}', name: 'category')]
    public function category(
        Request $request,
        FaqCategory $category,
    ): Response {
        if (! $category->isEnabled()) {
            throw $this->createNotFoundException();
        }

        $categories = $this->faqCategoryRepository->findEnabled();

        return $this->render('@page/faq/index.html.twig', [
            'category' => $category,
            'categories' => $categories,
            'articles' => $this->faqArticleRepository->findEnabledByCategory($category),
        ]);
    }
}
