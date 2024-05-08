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
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
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

        $formModifier = static function (FormInterface $form, MenuType|null $menuType = null): void {
            if ($menuType !== MenuType::SIMPLE) {
                return;
            }

            $form->add('url', UrlType::class, [
                'constraints' => [
                    new NotBlank(),
                ],
            ]);
        };

        $builder->addEventListener(
            FormEvents::PRE_SET_DATA,
            static function (FormEvent $event) use ($formModifier): void {
                $form = $event->getForm();
                $data = $event->getData();

                if (! $data instanceof MenuItem\MenuItemSimple) {
                    return;
                }

                $formModifier($event->getForm(), $data->getType());

                $form->add('url', UrlType::class, [
                    'constraints' => [
                        new NotBlank(),
                    ],
                ]);
            },
        );

        $builder->get('type')->addEventListener(
            FormEvents::POST_SUBMIT,
            static function (FormEvent $event) use ($formModifier): void {
                // It's important here to fetch $event->getForm()->getData(), as
                // $event->getData() will get you the client data (that is, the ID)
                $menuItem = $event->getForm()->getData();

                // since we've added the listener to the child, we'll have to pass on
                // the parent to the callback function!
                $formModifier($event->getForm()->getParent(), $menuItem);
            },
        );
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class'  => MenuItem::class,
            'empty_data' => static function (FormInterface $form): MenuItem {
                if ($form->get('type')->getData() === MenuType::SIMPLE) {
                    return new MenuItem\MenuItemSimple(
                        $form->get('title')->getData() ?? '',
                        $form->get('icon')->getData() ?? '',
                        $form->get('url')->getData() ?? '',
                        $form->get('type')->getData() ?? MenuType::MAIN,
                        $form->get('group')->getData() ?? MenuGroup::MAIN,
                    );
                }

                return new MenuItem(
                    $form->get('title')->getData() ?? '',
                    $form->get('icon')->getData() ?? '',
                    $form->get('type')->getData() ?? MenuType::MAIN,
                    $form->get('group')->getData() ?? MenuGroup::MAIN,
                );
            },
        ]);
    }

    public function getParent(): string
    {
        return AbstractForm::class;
    }
}
