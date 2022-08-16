<?php

declare(strict_types=1);

namespace App\Module\Admin\Form\Type\Forms;

use App\Domain\Gender;
use App\Domain\TeamAgeCategory;
use App\Form\Type\Entities\FileEntityType;
use App\Module\Admin\Form\Type\Widgets\PlayerCollectionType;
use App\Storage\Entity\Team;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EnumType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

final class TeamType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'constraints' => [
                    new NotBlank(),
                ],
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
            ->add('image', FileEntityType::class, [
                'required' => false,
            ])
            ->add('players', PlayerCollectionType::class, [
                'required'     => false,
                'by_reference' => false,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Team::class,
            'empty_data' => static function (FormInterface $form): Team {
                return new Team(
                    $form->get('name')->getData() ?? '',
                    $form->get('gender')->getData() ?? Gender::MIXED,
                    $form->get('ageCategory')->getData() ?? TeamAgeCategory::JUNIOR,
                );
            },
        ]);
    }
}
