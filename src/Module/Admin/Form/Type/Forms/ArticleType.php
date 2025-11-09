<?php

declare(strict_types=1);

namespace App\Module\Admin\Form\Type\Forms;

use App\Form\Type\Entities\FileEntityType;
use App\Form\Type\Entities\PersonEntityType;
use App\Storage\Entity\Article;
use Eckinox\TinymceBundle\Form\Type\TinymceType;
use Override;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Range;

/** @extends AbstractType<Article> */
final class ArticleType extends AbstractType
{
    /** @inheritDoc */
    public function buildForm(
        FormBuilderInterface $builder,
        array $options,
    ): void {
        $builder
            ->add('title', TextType::class, [
                'label' => 'Titel',
                'constraints' => [
                    new NotBlank(),
                ],
            ])
            ->add('enabled', CheckboxType::class, [
                'label' => 'Aktiviert',
                'required' => false,
            ])
            ->add('author', PersonEntityType::class, [
                'label' => 'Author',
                'required' => false,
            ])
            ->add('truncate', CheckboxType::class, [
                'label' => 'Text verkürzen?',
                'required' => false,
            ])
            ->add('truncateMaxLength', IntegerType::class, [
                'label' => 'Wie viele Zeichen sollen angezeigt werden?',
                'required' => false,
                'constraints' => [
                    new Range(min: 50),
                ],
            ])
            ->add('publishedAt', DateType::class, [
                'label' => 'Veröffentlicht am',
                'required' => false,
            ])
            ->add('image', FileEntityType::class, [
                'label' => 'Bild',
                'required' => false,
            ])
            ->add('content', TinymceType::class, [
                'label' => 'Inhalt',
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

    #[Override]
    public function getParent(): string
    {
        return AbstractForm::class;
    }
}
