<?php

declare(strict_types=1);

namespace App\Module\Admin\Form\Type\Forms;

use App\Form\Type\Entities\FileEntityType;
use App\Storage\Entity\Article;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

final class ArticleType extends AbstractType
{
    /**
     * @inheritDoc
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                'constraints' => [
                    new NotBlank(),
                ],
            ])
            ->add('enabled', CheckboxType::class, [
                'required' => false,
            ])
            ->add('image', FileEntityType::class, [
                'required' => false,
            ])
            ->add('content', CKEditorType::class, [
                'constraints' => [
                    new NotBlank(),
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Article::class,
            'empty_data' => static fn (FormInterface $form): Article => new Article(
                $form->get('title')->getData() ?? '',
                $form->get('content')->getData() ?? '',
            ),
        ]);
    }

    public function getParent(): string
    {
        return AbstractForm::class;
    }
}
