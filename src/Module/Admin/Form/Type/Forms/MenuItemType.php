<?php

declare(strict_types=1);

namespace App\Module\Admin\Form\Type\Forms;

use App\Infrastructure\Menu\MenuGroup;
use App\Infrastructure\Menu\MenuType;
use App\Storage\Entity\MenuItem;
use Override;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\EnumType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

/** @extends AbstractType<MenuItem> */
final class MenuItemType extends AbstractType
{
    /** @inheritDoc */
    public function buildForm(
        FormBuilderInterface $builder,
        array $options,
    ): void {
        $builder
            ->add('title', TextType::class, [
                'label' => 'Titel',
                'required' => false,
                'constraints' => [
                    new NotBlank(),
                ],
            ])
            ->add('icon', TextType::class, [
                'label' => 'Icon',
                'help' => 'Der Name des Icons von der Seite https://icon-sets.iconify.design/.',
                'constraints' => [
                    new NotBlank(),
                ],
            ])
            ->add('enabled', CheckboxType::class, [
                'label' => 'Aktiviert',
                'required' => false,
            ])
            ->add('type', EnumType::class, [
                'label' => 'Typ',
                'class' => MenuType::class,
                'constraints' => [
                    new NotBlank(),
                ],
            ])
            ->add('group', EnumType::class, [
                'label' => 'Gruppe',
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
            'empty_data' => static fn (FormInterface $form): MenuItem => new MenuItem(
                $form->get('title')->getData() ?? '',
                $form->get('icon')->getData() ?? '',
                $form->get('type')->getData() ?? '',
                $form->get('group')->getData() ?? '',
            ),
        ]);
    }

    #[Override]
    public function getParent(): string
    {
        return AbstractForm::class;
    }
}
