<?php

declare(strict_types=1);

namespace App\Admin\Controller;

use App\Domain\EmbedArticle;
use App\Domain\Role;
use App\Storage\Entity\ExternalArticle;
use App\Storage\Repository\ExternalArticleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Embed\Embed;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\SubmitButton;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

use function assert;

#[IsGranted(Role::MANAGE_FILES->value)]
#[Route('/external-articles', name: 'external_articles_')]
final class ExternalArticleController extends AbstractController
{
    public function __construct(
        private readonly Embed $embed,
        private readonly EntityManagerInterface $entityManager,
        private readonly PaginatorInterface $paginator,
        private readonly ExternalArticleRepository $externalArticleRepository,
    ) {
    }

    #[Route('', name: 'index')]
    public function index(
        Request $request,
    ): Response {
        $builder = $this->createFormBuilder(null, [
            'method' => 'GET',
        ]);
        $builder
            ->add('url', UrlType::class, [
                'label' => 'URL',
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'URL Vorschau',
            ])
            ->add('submit_and_safe', SubmitType::class, [
                'label' => 'URL speichern',
            ]);

        $form = $builder->getForm();
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $submitAndSafe = $form->get('submit_and_safe');
            assert($submitAndSafe instanceof SubmitButton);

            if ($submitAndSafe->isClicked()) {
                return $this->saveUrl($form->get('url')->getData());
            }

            $url     = $form->get('url')->getData();
            $article = new EmbedArticle($this->embed->get($url));
        }

        $query = $this->externalArticleRepository->createQueryBuilder('p');
        $query->orderBy('p.id', 'DESC');

        $pagination = $this->paginator->paginate(
            $query,
            $request->query->getInt('page', 1),
        );

        return $this->render('@admin/external_article/index.html.twig', [
            'form' => $form,
            'article' => $article ?? null,
            'iterable' => $pagination,
        ]);
    }

    private function saveUrl(string $url): RedirectResponse
    {
        $article = new EmbedArticle($this->embed->get($url));

        $externalArticle = new ExternalArticle(
            $article->getUrl()->__toString(),
            $article->getTitle(),
            $article->getDescription(),
            $article->getImage()?->__toString(),
            $article->getAuthor(),
            $article->getAuthorUrl()?->__toString(),
            $article->getPublishedTime(),
        );

        $this->entityManager->persist($externalArticle);
        $this->entityManager->flush();

        return $this->redirectToRoute('admin_external_articles_index');
    }

    #[Route('/{object}/enable', name: 'enable', defaults: ['enabled' => true])]
    #[Route('/{object}/disable', name: 'disable', defaults: ['enabled' => false])]
    public function changeEnabled(
        bool $enabled,
        ExternalArticle $object,
    ): RedirectResponse {
        $object->setEnabled($enabled);

        $this->entityManager->flush();

        return $this->redirectToRoute('admin_external_articles_index');
    }

    #[Route('/{object}/remove', name: 'remove')]
    public function remove(
        ExternalArticle $object,
    ): RedirectResponse {
        $this->entityManager->remove($object);
        $this->entityManager->flush();

        return $this->redirectToRoute('admin_external_articles_index');
    }
}
