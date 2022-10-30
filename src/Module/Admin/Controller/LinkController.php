<?php

declare(strict_types=1);

namespace App\Module\Admin\Controller;

use App\Module\Admin\Form\Type\Forms\AbstractForm;
use App\Module\Admin\Form\Type\Forms\LinkType;
use App\Storage\Entity\Link;
use App\Storage\Repository\LinkRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\SubmitButton;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Annotation\Route;

use function assert;

#[AsController]
#[Route('/link', name: 'app_admin_link_')]
final class LinkController extends AbstractController
{
    public function __construct(
        private readonly LinkRepository $linkRepository,
        private readonly EntityManagerInterface $entityManager,
        private readonly PaginatorInterface $paginator,
    ) {
    }

    #[Route('', name: 'index')]
    public function index(Request $request): Response
    {
        $query      = $this->linkRepository->createQueryBuilder('p');
        $pagination = $this->paginator->paginate(
            $query,
            $request->query->getInt('page', 1),
            options: [
                'defaultSortFieldName' => 'p.id',
                'defaultSortDirection' => 'desc',
            ],
        );

        return $this->render('@admin/link/index.html.twig', [
            'pagination' => $pagination,
        ]);
    }

    #[Route('/create', name: 'create')]
    public function create(Request $request): Response
    {
        $form = $this->createForm(LinkType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            return $this->handleValidForm($form);
        }

        return $this->renderForm('@admin/link/create.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/{link}/edit', name: 'edit')]
    public function edit(Request $request, Link $link): Response
    {
        $form = $this->createForm(LinkType::class, $link);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            return $this->handleValidForm($form);
        }

        return $this->renderForm('@admin/link/edit.html.twig', [
            'form' => $form,
        ]);
    }

    private function handleValidForm(FormInterface $form): Response
    {
        $data = $form->getData();
        assert($data instanceof Link);

        $this->entityManager->persist($data);
        $this->entityManager->flush();

        $submitAndNew = $form->get(AbstractForm::BUTTON_SUBMIT_AND_NEW);
        assert($submitAndNew instanceof SubmitButton);

        if ($submitAndNew->isClicked()) {
            return $this->redirectToRoute('app_admin_link_create');
        }

        return $this->redirectToRoute('app_admin_link_index');
    }

    #[Route('/{link}/remove', name: 'remove')]
    public function remove(Link $link): Response
    {
        $this->entityManager->remove($link);
        $this->entityManager->flush();

        return $this->redirectToRoute('app_admin_link_index');
    }

    #[Route('/{link}/enable', name: 'enable', defaults: ['enabled' => true])]
    #[Route('/{link}/disable', name: 'disable', defaults: ['enabled' => false])]
    public function changeEnabled(Link $link, bool $enabled): Response
    {
        $link->setEnabled($enabled);

        $this->entityManager->flush();

        return $this->redirectToRoute('app_admin_link_index');
    }
}
