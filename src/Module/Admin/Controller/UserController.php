<?php

declare(strict_types=1);

namespace App\Module\Admin\Controller;

use App\Domain\Role;
use App\Module\Admin\Crud\CrudConfigBuilder;
use App\Module\Admin\Crud\Handler\CRUDHandler;
use App\Module\Admin\Form\Type\Forms\UserType;
use App\Storage\Entity\User;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

/** @template-extends AbstractCrudController<User, UserType, null> */
#[AsController]
#[IsGranted(Role::MANAGE_USERS->value)]
#[Route('/user', name: 'user_')]
final class UserController extends AbstractCrudController
{
    use CRUDHandler;

    public function __construct(
        private readonly UserPasswordHasherInterface $userPasswordHasher,
    ) {
    }

    protected function configureCrudConfig(
        CrudConfigBuilder $builder,
        Request $request,
    ): void {
        $builder->setMandatory(
            User::class,
            'user',
        );
    }

    protected function getFormType(
        Request $request,
        object|null $object = null,
    ): string {
        return UserType::class;
    }

    protected function doHandleValidForm(
        Request $request,
        FormInterface $form,
        mixed $data,
    ): void {
        $password = $form->get(UserType::FIELD_PASSWORD)->getData();
        if ($password !== null) {
            $data->setPassword($this->userPasswordHasher->hashPassword($data, $password));
        }

        parent::doHandleValidForm($request, $form, $data);
    }
}
