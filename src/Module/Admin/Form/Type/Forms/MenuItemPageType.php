<?php

declare(strict_types=1);

namespace App\Module\Admin\Form\Type\Forms;

use App\Infrastructure\Menu\MenuGroup;
use App\Storage\Entity\MenuItem\MenuItemPage;
use App\Storage\Entity\Page;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

final class MenuItemPageType extends AbstractType
{
    /** @inheritDoc */
    public function buildForm(
        FormBuilderInterface $builder,
        array $options,
    ): void {
        $builder
            ->remove('type')
            ->add('page', EntityType::class, [
                'label' => 'Seite',
                'class' => Page::class,
                'constraints' => [
                    new NotBlank(),
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => MenuItemPage::class,
            'empty_data' => static fn (FormInterface $form) => new MenuItemPage(
                $form->get('title')->getData() ?? '',
                $form->get('icon')->getData() ?? '',
                $form->get('page')->getData() ?? '',
                $form->get('group')->getData() ?? MenuGroup::MAIN,
            ),
        ]);
    }

    public function getParent(): string
    {
        return MenuItemType::class;
    }
}
