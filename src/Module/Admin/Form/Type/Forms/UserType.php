<?php

declare(strict_types=1);

namespace App\Module\Admin\Form\Type\Forms;

use App\Form\Type\Widgets\RoleType;
use App\Storage\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

final class UserType extends AbstractType
{
    public const string FIELD_EMAIL    = 'email';
    public const string FIELD_PASSWORD = 'password';

    /** @inheritDoc */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add(self::FIELD_EMAIL, EmailType::class, [
                'constraints' => [
                    new NotBlank(),
                ],
            ])
            ->add(self::FIELD_PASSWORD, PasswordType::class, [
                'required' => false,
                'mapped' => false,
            ])
            ->add('roles', RoleType::class, [
                'required' => false,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
            'empty_data' => static function (FormInterface $form): User {
                return new User(
                    $form->get(self::FIELD_EMAIL)->getData() ?? '',
                );
            },
        ]);
    }

    public function getParent(): string
    {
        return AbstractForm::class;
    }
}
