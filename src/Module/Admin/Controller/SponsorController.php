<?php

declare(strict_types=1);

namespace App\Module\Admin\Controller;

use App\Module\Admin\Form\Type\Forms\SponsorType;
use App\Storage\Entity\Sponsor;
use App\Storage\Repository\SponsorRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Annotation\Route;

use function assert;

#[AsController]
#[Route('/sponsor', name: 'app_admin_sponsor_')]
final class SponsorController extends AbstractController
{
    public function __construct(
        private readonly SponsorRepository $sponsorRepository,
        private readonly EntityManagerInterface $entityManager,
        private readonly PaginatorInterface $paginator,
    ) {
    }

    #[Route('', name: 'index')]
    public function index(Request $request): Response
    {
        $query      = $this->sponsorRepository->createQueryBuilder('p');
        $pagination = $this->paginator->paginate(
            $query,
            $request->query->getInt('page', 1)
        );

        return $this->render('@admin/sponsor/index.html.twig', [
            'pagination' => $pagination,
        ]);
    }

    #[Route('/create', name: 'create')]
    public function create(Request $request): Response
    {
        $form = $this->createForm(SponsorType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $sponsor = $form->getData();
            assert($sponsor instanceof Sponsor);

            $this->entityManager->persist($sponsor);
            $this->entityManager->flush();

            return $this->redirectToRoute('app_admin_sponsor_index');
        }

        return $this->renderForm('@admin/sponsor/create.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/{sponsor}/edit', name: 'edit')]
    public function edit(Request $request, Sponsor $sponsor): Response
    {
        $form = $this->createForm(SponsorType::class, $sponsor);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->flush();

            return $this->redirectToRoute('app_admin_sponsor_index');
        }

        return $this->renderForm('@admin/sponsor/edit.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/{sponsor}/remove', name: 'remove')]
    public function remove(Sponsor $sponsor): Response
    {
        $this->entityManager->remove($sponsor);
        $this->entityManager->flush();

        return $this->redirectToRoute('app_admin_sponsor_index');
    }

    #[Route('/{sponsor}/enable', name: 'enable', defaults: ['enabled' => true])]
    #[Route('/{sponsor}/disable', name: 'disable', defaults: ['enabled' => false])]
    public function changeEnabled(Sponsor $sponsor, bool $enabled): Response
    {
        $sponsor->setEnabled($enabled);

        $this->entityManager->flush();

        return $this->redirectToRoute('app_admin_sponsor_index');
    }
}
