<?php

declare(strict_types=1);

namespace App\Module\Admin\Controller;

use App\Domain\Role;
use App\Module\Admin\Crud\CrudConfigBuilder;
use App\Module\Admin\Crud\Handler\FullHandler;
use App\Module\Admin\Crud\Handler\PositionHandler;
use App\Module\Admin\Form\Type\Forms\FaqArticleType;
use App\Storage\Entity\FaqArticle;
use App\Storage\Repository\FaqCategoryRepository;
use Doctrine\ORM\QueryBuilder;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

/** @template-extends AbstractCrudController<FaqArticle> */
#[AsController]
#[IsGranted(Role::MANAGE_FAQ->value)]
#[Route('/faq/category/{category}/article', name: 'faq_article_')]
final class FaqArticleController extends AbstractCrudController
{
    use FullHandler;
    use PositionHandler;

    public function __construct(
        private readonly FaqCategoryRepository $faqCategoryRepository,
    ) {
    }

    protected function configureCrudConfig(
        CrudConfigBuilder $builder,
        Request $request,
    ): void {
        $builder->setMandatory(
            FaqArticle::class,
            'faq_article',
        );
        $builder->defaultSortFieldName = 'p.position';
        $builder->defaultSortDirection = 'asc';
        $builder->defaultRouteParams   = ['category' => $request->attributes->get('category')];

        $builder->formEmptyDataCallable = function (FormInterface $form) use ($request): FaqArticle {
            $category = $this->faqCategoryRepository->find($request->attributes->get('category'));
            if ($category === null) {
                throw $this->createNotFoundException();
            }

            return new FaqArticle(
                $category,
                $form->get('title')->getData() ?? '',
                $form->get('content')->getData() ?? '',
            );
        };
    }

    protected function doConfigureQueryBuilder(
        QueryBuilder $queryBuilder,
        Request $request,
    ): void {
        $category = $this->faqCategoryRepository->find($request->attributes->get('category'));
        if ($category === null) {
            throw $this->createNotFoundException();
        }

        $queryBuilder
            ->andWhere('p.group = :category')
            ->setParameter('category', $category->getId());
    }

    protected function getFormType(
        Request $request,
        object|null $object = null,
    ): string {
        return FaqArticleType::class;
    }
}
