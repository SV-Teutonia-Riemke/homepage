<?php

declare(strict_types=1);

namespace App\Module\Admin\Controller;

use App\Module\Admin\Crud\CrudConfigBuilder;
use App\Module\Admin\Crud\Handler\CRUDHandler;
use App\Module\Admin\Form\Type\Forms\UserType;
use App\Storage\Entity\User;
use RuntimeException;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
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

    protected function configureCrudConfig(CrudConfigBuilder $builder): void
    {
        $builder->dtoClass        = User::class;
        $builder->listTemplate    = '@admin/user/index.html.twig';
        $builder->createTemplate  = '@admin/user/create.html.twig';
        $builder->editTemplate    = '@admin/user/edit.html.twig';
        $builder->listRouteName   = 'app_admin_user_index';
        $builder->createRouteName = 'app_admin_user_create';
    }

    protected function getFormType(Request $request, object|null $object = null): string
    {
        return UserType::class;
    }

    protected function doHandleValidForm(Request $request, FormInterface $form, $data): void
    {
        if (! ($data instanceof User)) {
            throw new RuntimeException('Invalid data type');
        }

        $password = $form->get(UserType::FIELD_PASSWORD)->getData();
        if ($password === null) {
            return;
        }

        $data->setPassword($this->userPasswordHasher->hashPassword($data, $password));

        parent::doHandleValidForm($request, $form, $data);
    }
}
