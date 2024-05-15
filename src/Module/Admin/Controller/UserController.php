<?php

declare(strict_types=1);

namespace App\Module\Admin\Controller;

use App\Module\Admin\Crud\CrudConfigBuilder;
use App\Module\Admin\Crud\Handler\CRUDHandler;
use App\Module\Admin\Form\Type\Forms\UserType;
use App\Storage\Entity\User;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;

/** @template-extends AbstractCrudController<User> */
#[AsController]
#[Route('/user', name: 'user_')]
final class UserController extends AbstractCrudController
{
    use CRUDHandler;

    public function __construct(
        private readonly UserPasswordHasherInterface $userPasswordHasher,
    ) {
    }

    private function handleUserForm(FormInterface $form, User $user): void
    {
        $password = $form->get(UserType::FIELD_PASSWORD)->getData();
        if ($password === null) {
            return;
        }

        $user->setPassword($this->userPasswordHasher->hashPassword($user, $password));
    }

    protected function configureCrudConfig(CrudConfigBuilder $builder): void
    {
        $builder->setDefaults();
        $builder->dtoClass        = User::class;
        $builder->formType        = UserType::class;
        $builder->listTemplate    = '@admin/user/index.html.twig';
        $builder->createTemplate  = '@admin/user/create.html.twig';
        $builder->editTemplate    = '@admin/user/edit.html.twig';
        $builder->listRouteName   = 'app_admin_user_index';
        $builder->createRouteName = 'app_admin_user_create';
        $builder->handleForm      = $this->handleUserForm(...);
    }
}
