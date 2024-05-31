<?php

declare(strict_types=1);

namespace App\Module\Admin\Form\Type\Forms;

use App\Module\Admin\Misc\Shlink\ShortUrl;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

final class ShortUrlType extends AbstractType
{
    /** @inheritDoc */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('longUrl', UrlType::class, [
                'label' => 'URL',
                'constraints' => [
                    new NotBlank(),
                ],
            ])
            ->add('shortCode', TextType::class, [
                'label' => 'Code',
                'required' => false,
            ])
            ->add('tags', TextType::class, [
                'label' => 'Tags',
                'required' => false,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ShortUrl::class,
        ]);
    }

    public function getParent(): string
    {
        return AbstractForm::class;
    }
}
