<?php

declare(strict_types=1);

namespace App\Module\Admin\Controller;

use App\Module\Admin\Crud\CrudConfigBuilder;
use App\Module\Admin\Crud\Handler\FullHandler;
use App\Module\Admin\Form\Type\Forms\ArticleType;
use App\Storage\Entity\Article;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Attribute\Route;

/** @template-extends AbstractCrudController<Article> */
#[AsController]
#[Route('/article', name: 'article_')]
final class ArticleController extends AbstractCrudController
{
    use FullHandler;

    protected function configureCrudConfig(CrudConfigBuilder $builder): void
    {
        $builder->setDefaults();
        $builder->dtoClass             = Article::class;
        $builder->formType             = ArticleType::class;
        $builder->listTemplate         = '@admin/article/index.html.twig';
        $builder->createTemplate       = '@admin/article/create.html.twig';
        $builder->editTemplate         = '@admin/article/edit.html.twig';
        $builder->listRouteName        = 'app_admin_article_index';
        $builder->createRouteName      = 'app_admin_article_create';
        $builder->defaultSortFieldName = 'p.id';
        $builder->defaultSortDirection = 'desc';
    }
}
