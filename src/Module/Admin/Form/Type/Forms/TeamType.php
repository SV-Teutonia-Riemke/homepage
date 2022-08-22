<?php

declare(strict_types=1);

namespace App\Module\Admin\Form\Type\Forms;

use App\Domain\Gender;
use App\Domain\TeamAgeCategory;
use App\Form\Type\Entities\FileEntityType;
use App\Module\Admin\Form\Type\Widgets\PlayerCollectionType;
use App\Module\Admin\Form\Type\Widgets\StaffCollectionType;
use App\Storage\Entity\Team;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\EnumType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Url;

final class TeamType extends AbstractType
{
    /**
     * @inheritDoc
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'constraints' => [
                    new NotBlank(),
                ],
            ])
            ->add('enabled', CheckboxType::class, [
                'required' => false,
            ])
            ->add('gender', EnumType::class, [
                'class'       => Gender::class,
                'constraints' => [
                    new NotBlank(),
                ],
            ])
            ->add('ageCategory', EnumType::class, [
                'class'       => TeamAgeCategory::class,
                'constraints' => [
                    new NotBlank(),
                ],
            ])
            ->add('currentMatchday', TextType::class, [
                'required'    => false,
                'constraints' => [
                    new Url(protocols: ['https']),
                ],
            ])
            ->add('handballNetId', TextType::class, [
                'required'    => false,
            ])
            ->add('facebook', TextType::class, [
                'required' => false,
            ])
            ->add('instagram', TextType::class, [
                'required' => false,
            ])
            ->add('image', FileEntityType::class, [
                'required' => false,
            ])
            ->add('players', PlayerCollectionType::class, [
                'required'     => false,
                'by_reference' => false,
            ])
            ->add('staffs', StaffCollectionType::class, [
                'required'     => false,
                'by_reference' => false,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Team::class,
        ]);
    }
}
