<?php

declare(strict_types=1);

namespace App\Module\Admin\Controller;

use App\Module\Admin\Form\Type\Forms\AbstractForm;
use App\Module\Admin\Form\Type\Forms\PersonType;
use App\Storage\Entity\Person;
use App\Storage\Repository\PersonRepository;
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
#[Route('/person', name: 'app_admin_person_')]
final class PersonController extends AbstractController
{
    public function __construct(
        private readonly PersonRepository $personRepository,
        private readonly EntityManagerInterface $entityManager,
        private readonly PaginatorInterface $paginator,
    ) {
    }

    #[Route('', name: 'index')]
    public function index(Request $request): Response
    {
        $query      = $this->personRepository->createQueryBuilder('p');
        $pagination = $this->paginator->paginate(
            $query,
            $request->query->getInt('page', 1)
        );

        return $this->render('@admin/person/index.html.twig', [
            'pagination' => $pagination,
        ]);
    }

    #[Route('/create', name: 'create')]
    public function create(Request $request): Response
    {
        $form = $this
            ->createForm(PersonType::class)
            ->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            return $this->handleValidForm($form);
        }

        return $this->renderForm('@admin/person/create.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/{person}/edit', name: 'edit')]
    public function edit(Request $request, Person $person): Response
    {
        $form = $this
            ->createForm(PersonType::class, $person)
            ->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            return $this->handleValidForm($form);
        }

        return $this->renderForm('@admin/person/edit.html.twig', [
            'form' => $form,
        ]);
    }

    private function handleValidForm(FormInterface $form): Response
    {
        $person = $form->getData();
        assert($person instanceof Person);

        $this->entityManager->persist($person);
        $this->entityManager->flush();

        $submitAndNew = $form->get(AbstractForm::BUTTON_SUBMIT_AND_NEW);
        assert($submitAndNew instanceof SubmitButton);

        if ($submitAndNew->isClicked()) {
            return $this->redirectToRoute('app_admin_person_create');
        }

        return $this->redirectToRoute('app_admin_person_index');
    }

    #[Route('/{person}/remove', name: 'remove')]
    public function remove(Person $person): Response
    {
        $this->entityManager->remove($person);
        $this->entityManager->flush();

        return $this->redirectToRoute('app_admin_person_index');
    }
}
