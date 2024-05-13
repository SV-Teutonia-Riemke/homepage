<?php

declare(strict_types=1);

namespace App\Module\Admin\Controller;

use App\Module\Admin\Crud\CrudConfig;
use App\Module\Admin\Form\Type\Forms\UserType;
use App\Storage\Entity\User;
use App\Storage\Repository\UserRepository;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;

/** @template-extends AbstractCrudController<User> */
#[AsController]
#[Route('/user', name: 'user_')]
final class UserController extends AbstractCrudController
{
    public function __construct(
        private readonly UserRepository $userRepository,
        private readonly UserPasswordHasherInterface $userPasswordHasher,
    ) {
    }

    #[Route('', name: 'index')]
    public function index(Request $request): Response
    {
        return $this->handleList($request);
    }

    #[Route('/create', name: 'create')]
    public function create(Request $request): Response
    {
        return $this->handleCreate($request);
    }

    #[Route('/{user}/edit', name: 'edit')]
    public function edit(Request $request, User $user): Response
    {
        return $this->handleEdit($request, $user);
    }

    #[Route('/{user}/remove', name: 'remove')]
    public function remove(User $user): Response
    {
        return $this->handleRemove($user);
    }

    private function handleUserForm(FormInterface $form, User $user): void
    {
        $password = $form->get(UserType::FIELD_PASSWORD)->getData();
        if ($password === null) {
            return;
        }

        $user->setPassword($this->userPasswordHasher->hashPassword($user, $password));
    }

    protected function getCrudConfig(): CrudConfig
    {
        return new CrudConfig(
            $this->userRepository,
            '@admin/user/index.html.twig',
            '@admin/user/create.html.twig',
            '@admin/user/edit.html.twig',
            'app_admin_user_index',
            'app_admin_user_create',
            UserType::class,
            handleForm: $this->handleUserForm(...),
        );
    }
}
