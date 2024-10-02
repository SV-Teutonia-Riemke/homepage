<?php

declare(strict_types=1);

namespace App\Module\Admin\Controller;

use App\Domain\EmbedArticle;
use App\Domain\Role;
use App\Storage\Entity\ExternalArticle;
use Doctrine\ORM\EntityManagerInterface;
use Embed\Embed;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\SubmitButton;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

use function assert;

#[AsController]
#[IsGranted(Role::MANAGE_FILES->value)]
#[Route('/external-articles', name: 'external_articles_')]
final class ExternalArticleController extends AbstractController
{
    public function __construct(
        private readonly Embed $embed,
        private readonly EntityManagerInterface $entityManager,
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

        return $this->render('@admin/external_article/index.html.twig', [
            'form' => $form,
            'article' => $article ?? null,
        ]);
    }

    private function saveUrl(string $url): Response
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

        return $this->redirectToRoute('app_admin_external_articles_index');
    }
}
