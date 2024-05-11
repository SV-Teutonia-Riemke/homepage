<?php

declare(strict_types=1);

namespace App\Module\Admin\Form\Type\Forms;

use App\Storage\Entity\Page;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

final class PageType extends AbstractType
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
            ->add('subTitle', TextType::class, [
                'required' => false,
            ])
            ->add('enabled', CheckboxType::class, [
                'required' => false,
            ])
            ->add('content', TextareaType::class, [
                'attr' => [
                    'class' => 'monaco-editor',
                    'data-language' => 'twig',
                ],
                'constraints' => [
                    new NotBlank(),
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class'  => Page::class,
            'empty_data' => static fn (FormInterface $form): Page => new Page(
                $form->get('title')->getData() ?? '',
                $form->get('subTitle')->getData(),
                $form->get('content')->getData() ?? '',
            ),
        ]);
    }

    public function getParent(): string
    {
        return AbstractForm::class;
    }
}
