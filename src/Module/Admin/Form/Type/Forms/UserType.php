<?php

declare(strict_types=1);

namespace App\Module\Admin\Form\Type\Forms;

use App\Form\Type\Widgets\RoleType;
use App\Storage\Entity\User;
use Override;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

/** @extends AbstractType<User> */
final class UserType extends AbstractType
{
    public const string FIELD_EMAIL    = 'email';
    public const string FIELD_PASSWORD = 'password';

    /** @inheritDoc */
    public function buildForm(
        FormBuilderInterface $builder,
        array $options,
    ): void {
        $builder
            ->add(self::FIELD_EMAIL, EmailType::class, [
                'label' => 'E-Mail-Adresse',
                'constraints' => [
                    new NotBlank(),
                ],
            ])
            ->add(self::FIELD_PASSWORD, PasswordType::class, [
                'label' => 'Passwort',
                'required' => false,
                'mapped' => false,
            ])
            ->add('roles', RoleType::class, [
                'label' => 'Berechtigungen',
                'required' => false,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
            'empty_data' => static fn (FormInterface $form): User => new User(
                $form->get(self::FIELD_EMAIL)->getData() !== null ? (string) $form->get(self::FIELD_EMAIL)->getData() : '',
            ),
        ]);
    }

    #[Override]
    public function getParent(): string
    {
        return AbstractForm::class;
    }
}
