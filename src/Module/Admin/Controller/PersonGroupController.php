<?php

declare(strict_types=1);

namespace App\Module\Admin\Controller;

use App\Module\Admin\Form\Type\Forms\PersonGroupType;
use App\Storage\Entity\PersonGroup;
use App\Storage\Repository\PersonGroupRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Annotation\Route;

use function assert;

#[AsController]
#[Route('/person-group', name: 'app_admin_person_group_')]
final class PersonGroupController extends AbstractController
{
    public function __construct(
        private readonly PersonGroupRepository $personGroupRepository,
        private readonly EntityManagerInterface $entityManager,
        private readonly PaginatorInterface $paginator,
    ) {
    }

    #[Route('', name: 'index')]
    public function index(): Response
    {
        $query      = $this->personGroupRepository->createQueryBuilder('p');
        $pagination = $this->paginator->paginate($query);

        return $this->render('admin/person_group/index.html.twig', [
            'pagination' => $pagination,
        ]);
    }

    #[Route('/create', name: 'create')]
    public function create(Request $request): Response
    {
        $form = $this->createForm(PersonGroupType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $personGroup = $form->getData();
            assert($personGroup instanceof PersonGroup);

            $this->entityManager->persist($personGroup);
            $this->entityManager->flush();

            return $this->redirectToRoute('app_admin_person_group_index');
        }

        return $this->renderForm('admin/person_group/create.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/{personGroup}/edit', name: 'edit')]
    public function edit(Request $request, PersonGroup $personGroup): Response
    {
        $form = $this->createForm(PersonGroupType::class, $personGroup);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->persist($personGroup);
            $this->entityManager->flush();

            return $this->redirectToRoute('app_admin_person_group_index');
        }

        return $this->renderForm('admin/person_group/edit.html.twig', [
            'form'        => $form,
            'personGroup' => $personGroup,
        ]);
    }

    #[Route('/{personGroup}/remove', name: 'remove')]
    public function remove(PersonGroup $personGroup): Response
    {
        $this->entityManager->remove($personGroup);
        $this->entityManager->flush();

        return $this->redirectToRoute('app_admin_person_group_index');
    }
}
