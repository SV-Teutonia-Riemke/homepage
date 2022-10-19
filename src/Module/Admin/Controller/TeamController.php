<?php

declare(strict_types=1);

namespace App\Module\Admin\Controller;

use App\Module\Admin\Form\Type\Forms\TeamType;
use App\Storage\Entity\Team;
use App\Storage\Repository\TeamRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Annotation\Route;

use function assert;

#[AsController]
#[Route('/team', name: 'app_admin_team_')]
final class TeamController extends AbstractController
{
    public function __construct(
        private readonly TeamRepository $teamRepository,
        private readonly EntityManagerInterface $entityManager,
        private readonly PaginatorInterface $paginator,
    ) {
    }

    #[Route('', name: 'index')]
    public function index(Request $request): Response
    {
        $query      = $this->teamRepository->createQueryBuilder('p')->orderBy('p.id', 'ASC');
        $pagination = $this->paginator->paginate(
            $query,
            $request->query->getInt('page', 1),
        );

        return $this->render('@admin/team/index.html.twig', [
            'pagination' => $pagination,
        ]);
    }

    #[Route('/create', name: 'create')]
    public function create(Request $request): Response
    {
        $form = $this->createForm(TeamType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $team = $form->getData();
            assert($team instanceof Team);

            $this->entityManager->persist($team);
            $this->entityManager->flush();

            return $this->redirectToRoute('app_admin_team_index');
        }

        return $this->renderForm('@admin/team/create.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/{team}/edit', name: 'edit')]
    public function edit(Request $request, Team $team): Response
    {
        $form = $this->createForm(TeamType::class, $team);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->persist($team);
            $this->entityManager->flush();

            return $this->redirectToRoute('app_admin_team_index');
        }

        return $this->renderForm('@admin/team/edit.html.twig', [
            'form' => $form,
            'team' => $team,
        ]);
    }

    #[Route('/{team}/remove', name: 'remove')]
    public function remove(Team $team): Response
    {
        $this->entityManager->remove($team);
        $this->entityManager->flush();

        return $this->redirectToRoute('app_admin_team_index');
    }
}
