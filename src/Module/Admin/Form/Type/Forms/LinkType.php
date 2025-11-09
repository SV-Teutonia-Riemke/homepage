<?php

declare(strict_types=1);

namespace App\Module\Admin\Form\Type\Forms;

use App\Storage\Entity\Link;
use Override;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Url;

/** @extends AbstractType<Link> */
final class LinkType extends AbstractType
{
    /** @inheritDoc */
    public function buildForm(
        FormBuilderInterface $builder,
        array $options,
    ): void {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Name',
                'constraints' => [
                    new NotBlank(),
                ],
            ])
            ->add('enabled', CheckboxType::class, [
                'label' => 'Aktiviert',
                'required' => false,
            ])
            ->add('uri', UrlType::class, [
                'label' => 'URL',
                'constraints' => [
                    new NotBlank(),
                    new Url(),
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Link::class,
            'empty_data' => static fn (FormInterface $form): Link => new Link(
                $form->get('name')->getData() ?? '',
                $form->get('uri')->getData() ?? '',
            ),
        ]);
    }

    #[Override]
    public function getParent(): string
    {
        return AbstractForm::class;
    }
}
