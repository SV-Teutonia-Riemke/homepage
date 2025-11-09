<?php

declare(strict_types=1);

namespace App\Module\Admin\Form\Type\Forms;

use App\Infrastructure\Menu\MenuGroup;
use App\Storage\Entity\MenuItem\MenuItemUrl;
use Override;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

/** @extends AbstractType<MenuItemUrl> */
final class MenuItemUrlType extends AbstractType
{
    /** @inheritDoc */
    public function buildForm(
        FormBuilderInterface $builder,
        array $options,
    ): void {
        $builder
            ->remove('type')
            ->add('url', UrlType::class, [
                'label' => 'URL',
                'constraints' => [
                    new NotBlank(),
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => MenuItemUrl::class,
            'empty_data' => static fn (FormInterface $form): MenuItemUrl => new MenuItemUrl(
                $form->get('title')->getData() ?? '',
                $form->get('icon')->getData() ?? '',
                $form->get('url')->getData() ?? '',
                $form->get('group')->getData() ?? MenuGroup::MAIN,
            ),
        ]);
    }

    #[Override]
    public function getParent(): string
    {
        return MenuItemType::class;
    }
}
