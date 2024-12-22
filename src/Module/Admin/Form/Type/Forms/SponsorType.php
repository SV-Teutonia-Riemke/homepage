<?php

declare(strict_types=1);

namespace App\Module\Admin\Form\Type\Forms;

use App\Form\Type\Entities\FileEntityType;
use App\Form\Type\Widgets\SponsorLevelType;
use App\Storage\Entity\Sponsor;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ColorType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Url;

/** @extends AbstractType<Sponsor> */
final class SponsorType extends AbstractType
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
            ->add('url', TextType::class, [
                'label' => 'URL',
                'required'    => false,
                'constraints' => [
                    new Url(),
                ],
            ])
            ->add('level', SponsorLevelType::class, [
                'label' => 'Sponsorenstufe',
                'constraints' => [
                    new NotBlank(),
                ],
            ])
            ->add('enabled', CheckboxType::class, [
                'label' => 'Aktiviert',
                'required' => false,
            ])
            ->add('image', FileEntityType::class, [
                'label' => 'Logo',
                'required'    => true,
                'constraints' => [
                    new NotBlank(),
                ],
            ])
            ->add('backgroundColor', ColorType::class, [
                'label' => 'Hintergrundfarbe des Logos',
                'required' => false,
                'html5'    => true,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Sponsor::class,
        ]);
    }

    public function getParent(): string
    {
        return AbstractForm::class;
    }
}
