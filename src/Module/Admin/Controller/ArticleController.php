<?php

declare(strict_types=1);

namespace App\Module\Admin\Controller;

use App\Module\Admin\Crud\CrudConfig;
use App\Module\Admin\Form\Type\Forms\ArticleType;
use App\Storage\Entity\Article;
use App\Storage\Repository\ArticleRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Attribute\Route;

/** @template-extends AbstractCrudController<Article> */
#[AsController]
#[Route('/article', name: 'article_')]
final class ArticleController extends AbstractCrudController
{
    public function __construct(
        private readonly ArticleRepository $articleRepository,
    ) {
    }

    #[Route('', name: 'index')]
    public function index(Request $request): Response
    {
        return $this->handleList($request);
    }

    #[Route('/create', name: 'create')]
    public function create(Request $request): Response
    {
        return $this->handleCreate($request);
    }

    #[Route('/{article}/edit', name: 'edit')]
    public function edit(Request $request, Article $article): Response
    {
        return $this->handleEdit($request, $article);
    }

    #[Route('/{article}/remove', name: 'remove')]
    public function remove(Article $article): Response
    {
        return $this->handleRemove($article);
    }

    #[Route('/{article}/enable', name: 'enable', defaults: ['enabled' => true])]
    #[Route('/{article}/disable', name: 'disable', defaults: ['enabled' => false])]
    public function changeEnabled(Article $article, bool $enabled): Response
    {
        return $this->handleEnabled($article, $enabled);
    }

    protected function getCrudConfig(): CrudConfig
    {
        return new CrudConfig(
            $this->articleRepository,
            '@admin/article/index.html.twig',
            '@admin/article/create.html.twig',
            '@admin/article/edit.html.twig',
            'app_admin_article_index',
            'app_admin_article_create',
            ArticleType::class,
            defaultSortFieldName: 'p.id',
            defaultSortDirection: 'desc',
        );
    }
}
