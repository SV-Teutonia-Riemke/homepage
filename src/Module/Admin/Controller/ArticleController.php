<?php

declare(strict_types=1);

namespace App\Module\Admin\Controller;

use App\Module\Admin\Form\Type\Forms\ArticleType;
use App\Storage\Entity\Article;
use App\Storage\Repository\ArticleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Annotation\Route;

use function assert;

#[AsController]
#[Route('/article', name: 'app_admin_article_')]
final class ArticleController extends AbstractController
{
    public function __construct(
        private readonly ArticleRepository $articleRepository,
        private readonly EntityManagerInterface $entityManager,
        private readonly PaginatorInterface $paginator,
    ) {
    }

    #[Route('', name: 'index')]
    public function index(): Response
    {
        $query      = $this->articleRepository->createQueryBuilder('p');
        $pagination = $this->paginator->paginate($query, options: [
            'defaultSortFieldName' => 'p.id',
            'defaultSortDirection' => 'desc',
        ]);

        return $this->render('@admin/article/index.html.twig', [
            'pagination' => $pagination,
        ]);
    }

    #[Route('/create', name: 'create')]
    public function create(Request $request): Response
    {
        $form = $this->createForm(ArticleType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $article = $form->getData();
            assert($article instanceof Article);

            $this->entityManager->persist($article);
            $this->entityManager->flush();

            return $this->redirectToRoute('app_admin_article_index');
        }

        return $this->renderForm('@admin/article/create.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/{article}/edit', name: 'edit')]
    public function edit(Request $request, Article $article): Response
    {
        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->persist($article);
            $this->entityManager->flush();

            return $this->redirectToRoute('app_admin_article_index');
        }

        return $this->renderForm('@admin/article/edit.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/{article}/remove', name: 'remove')]
    public function remove(Article $article): Response
    {
        $this->entityManager->remove($article);
        $this->entityManager->flush();

        return $this->redirectToRoute('app_admin_article_index');
    }

    #[Route('/{article}/enable', name: 'enable', defaults: ['enabled' => true])]
    #[Route('/{article}/disable', name: 'disable', defaults: ['enabled' => false])]
    public function changeEnabled(Article $article, bool $enabled): Response
    {
        $article->setEnabled($enabled);

        $this->entityManager->flush();

        return $this->redirectToRoute('app_admin_article_index');
    }
}
