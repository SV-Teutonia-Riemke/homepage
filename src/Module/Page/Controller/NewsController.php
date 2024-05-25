<?php

declare(strict_types=1);

namespace App\Module\Page\Controller;

use App\Storage\Entity\Article;
use App\Storage\Repository\ArticleRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Attribute\Route;

#[AsController]
final class NewsController extends AbstractController
{
    public function __construct(
        private readonly ArticleRepository $articleRepository,
        private readonly PaginatorInterface $paginator,
    ) {
    }

    #[Route('/news', name: 'news', options: ['sitemap' => true, 'section' => 'article'])]
    public function news(Request $request): Response
    {
        $query = $this->articleRepository
            ->createQueryBuilder('p')
            ->where('p.enabled = true')
            ->orderBy('p.id', 'DESC');

        $page = $request->query->getInt('page', 1);
        if ($page < 1) {
            $page = 1;
        }

        $pagination = $this->paginator->paginate(
            $query,
            $page,
        );

        return $this->render('@page/news/index.html.twig', [
            'articles' => $pagination,
        ]);
    }

    #[Route('/news/{id}', name: 'news_article')]
    public function article(Article $article): Response
    {
        return $this->render('@page/news/article.html.twig', [
            'article'  => $article,
        ]);
    }
}
