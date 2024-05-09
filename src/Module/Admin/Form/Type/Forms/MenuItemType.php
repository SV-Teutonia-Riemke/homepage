<?php

declare(strict_types=1);

namespace App\Module\Admin\Form\Type\Forms;

use App\Infrastructure\Menu\MenuGroup;
use App\Infrastructure\Menu\MenuType;
use App\Storage\Entity\MenuItem;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\EnumType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

final class MenuItemType extends AbstractType
{
    /** @inheritDoc */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                'required' => false,
                'constraints' => [
                    new NotBlank(),
                ],
            ])
            ->add('icon', TextType::class, [
                'constraints' => [
                    new NotBlank(),
                ],
            ])
            ->add('enabled', CheckboxType::class, [
                'required' => false,
            ])
            ->add('type', EnumType::class, [
                'class' => MenuType::class,
                'constraints' => [
                    new NotBlank(),
                ],
            ])
            ->add('group', EnumType::class, [
                'class' => MenuGroup::class,
                'constraints' => [
                    new NotBlank(),
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => MenuItem::class,
            'empty_data' => static fn (FormInterface $form) => new MenuItem(
                $form->get('title')->getData() ?? '',
                $form->get('icon')->getData() ?? '',
                $form->get('type')->getData() ?? '',
                $form->get('group')->getData() ?? '',
            ),
        ]);
    }

    public function getParent(): string
    {
        return AbstractForm::class;
    }
}
