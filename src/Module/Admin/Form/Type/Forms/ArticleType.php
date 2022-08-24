<?php

declare(strict_types=1);

namespace App\Module\Admin\Form\Type\Forms;

use App\Form\Type\Entities\FileEntityType;
use App\Storage\Entity\Article;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\DataMapperInterface;
use Symfony\Component\Form\Exception\UnexpectedTypeException;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;
use Traversable;

use function iterator_to_array;

final class ArticleType extends AbstractType implements DataMapperInterface
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
            ])
            ->setDataMapper($this);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Article::class,
            'empty_data' => null,
        ]);
    }

    /**
     * @param Article|null               $viewData
     * @param Traversable<FormInterface> $forms
     */
    public function mapDataToForms(mixed $viewData, Traversable $forms): void
    {
        $formData = iterator_to_array($forms);

        if ($viewData === null) {
            $formData['enabled']->setData(true);

            return;
        }

        // invalid data type
        if (! $viewData instanceof Article) {
            throw new UnexpectedTypeException($viewData, Article::class);
        }

        $formData['title']->setData($viewData->getTitle());
        $formData['content']->setData($viewData->getContent());
        $formData['enabled']->setData($viewData->isEnabled());
        $formData['image']->setData($viewData->getImage());
    }

    /**
     * @param Traversable<FormInterface> $forms
     * @param Article|null               $viewData
     */
    public function mapFormsToData(Traversable $forms, mixed &$viewData): void
    {
        $formData = iterator_to_array($forms);

        if ($viewData === null) {
            $viewData = new Article(
                $formData['title']->getData() ?? '',
                $formData['content']->getData() ?? '',
            );
        }

        $viewData->setTitle($formData['title']->getData());
        $viewData->setContent($formData['content']->getData());
        $viewData->setImage($formData['image']->getData());
        $viewData->setEnabled($formData['enabled']->getData());
    }
}
