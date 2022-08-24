<?php

declare(strict_types=1);

namespace App\Module\Admin\Controller;

use App\Module\Admin\Form\Type\Forms\UserType;
use App\Storage\Entity\User;
use App\Storage\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

use function assert;

#[AsController]
#[Route('/user', name: 'app_admin_user_')]
final class UserController extends AbstractController
{
    public function __construct(
        private readonly UserRepository $userRepository,
        private readonly EntityManagerInterface $entityManager,
        private readonly PaginatorInterface $paginator,
        private readonly UserPasswordHasherInterface $userPasswordHasher,
    ) {
    }

    #[Route('', name: 'index')]
    public function index(Request $request): Response
    {
        $query      = $this->userRepository->createQueryBuilder('p');
        $pagination = $this->paginator->paginate(
            $query,
            $request->query->getInt('page', 1)
        );

        return $this->render('@admin/user/index.html.twig', [
            'pagination' => $pagination,
        ]);
    }

    #[Route('/create', name: 'create')]
    public function create(Request $request): Response
    {
        $form = $this->createForm(UserType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user = $form->getData();
            assert($user instanceof User);

            $password = $form->get('password')->getData();
            if ($password !== null) {
                $user->setPassword($this->userPasswordHasher->hashPassword($user, $password));
            }

            $this->entityManager->persist($user);
            $this->entityManager->flush();

            return $this->redirectToRoute('app_admin_user_index');
        }

        return $this->renderForm('@admin/user/create.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/{user}/edit', name: 'edit')]
    public function edit(Request $request, User $user): Response
    {
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $password = $form->get('password')->getData();
            if ($password !== null) {
                $user->setPassword($this->userPasswordHasher->hashPassword($user, $password));
            }

            $this->entityManager->flush();

            return $this->redirectToRoute('app_admin_user_index');
        }

        return $this->renderForm('@admin/user/edit.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/{user}/remove', name: 'remove')]
    public function remove(User $user): Response
    {
        $this->entityManager->remove($user);
        $this->entityManager->flush();

        return $this->redirectToRoute('app_admin_user_index');
    }
}
