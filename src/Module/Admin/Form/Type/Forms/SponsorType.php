<?php

declare(strict_types=1);

namespace App\Module\Admin\Form\Type\Forms;

use App\Form\Type\Entities\FileEntityType;
use App\Storage\Entity\Sponsor;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Url;

final class SponsorType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'constraints' => [
                    new NotBlank(),
                ],
            ])
            ->add('url', TextType::class, [
                'required'    => false,
                'constraints' => [
                    new Url(),
                ],
            ])
            ->add('enabled', CheckboxType::class, [
                'required' => false,
            ])
            ->add('image', FileEntityType::class, [
                'required' => true,
                'constraints' => [
                    new NotBlank(),
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Sponsor::class,
        ]);
    }
}
