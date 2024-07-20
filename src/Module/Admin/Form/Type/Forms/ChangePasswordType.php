<?php

declare(strict_types=1);

namespace App\Module\Admin\Form\Type\Forms;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Security\Core\Validator\Constraints\UserPassword;
use Symfony\Component\Validator\Constraints\NotBlank;

final class ChangePasswordType extends AbstractType
{
    /** @inheritDoc */
    public function buildForm(
        FormBuilderInterface $builder,
        array $options,
    ): void {
        $builder
            ->add('currentPassword', PasswordType::class, [
                'label'       => 'Aktuelles Passwort',
                'constraints' => [
                    new UserPassword(),
                ],
            ])
            ->add('newPassword', RepeatedType::class, [
                'type'           => PasswordType::class,
                'constraints'    => [
                    new NotBlank(),
                ],
                'first_options'  => ['label' => 'Neues Passwort'],
                'second_options' => ['label' => 'Neues Passwort wiederholen'],
            ]);
    }
}
