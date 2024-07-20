<?php

declare(strict_types=1);

namespace App\Module\Admin\Form\Type\Forms;

use App\Form\Type\Entities\FileEntityType;
use App\Form\Type\Widgets\GenderType;
use App\Form\Type\Widgets\TeamAgeCategoryType;
use App\Form\Type\Widgets\TeamJuniorAgeType;
use App\Form\Type\Widgets\YearGroupType;
use App\Module\Admin\Form\Type\Widgets\PlayerCollectionType;
use App\Module\Admin\Form\Type\Widgets\StaffCollectionType;
use App\Storage\Entity\Team;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Url;

final class TeamType extends AbstractType
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
            ->add('portraits', CheckboxType::class, [
                'label' => 'Portrait Modus verwenden',
                'help' => 'Erfordert Bilder für Spieler und Trainer.',
                'required' => false,
            ])
            ->add('gender', GenderType::class, [
                'label' => 'Geschlecht des Teams',
                'expanded' => true,
                'constraints' => [
                    new NotBlank(),
                ],
            ])
            ->add('season', YearGroupType::class, [
                'label' => 'Saison',
                'placeholder' => '',
                'required'    => false,
            ])
            ->add('league', TextType::class, [
                'label' => 'Liga',
                'required'    => false,
            ])
            ->add('ageGroup', YearGroupType::class, [
                'label' => 'Altersgruppe',
                'required'    => false,
                'placeholder' => '',
            ])
            ->add('juniorAge', TeamJuniorAgeType::class, [
                'label' => 'Junioren Alterskategorie',
                'required'    => false,
                'placeholder' => '',
            ])
            ->add('ageCategory', TeamAgeCategoryType::class, [
                'label' => 'Alterskategorie',
                'constraints' => [
                    new NotBlank(),
                ],
            ])
            ->add('currentMatchday', TextType::class, [
                'label' => 'Handball4All Link',
                'required'    => false,
                'constraints' => [
                    new Url(protocols: ['https']),
                ],
            ])
            ->add('handballNetId', TextType::class, [
                'label' => 'handball.net ID',
                'required'    => false,
            ])
            ->add('facebook', TextType::class, [
                'label' => 'Facebook URL',
                'required' => false,
            ])
            ->add('instagram', TextType::class, [
                'label' => 'Instagram URL',
                'required' => false,
            ])
            ->add('emailAddress', EmailType::class, [
                'label' => 'E-Mail Adresse',
                'required' => false,
            ])
            ->add('image', FileEntityType::class, [
                'label' => 'Teamfoto',
                'required' => false,
            ])
            ->add('players', PlayerCollectionType::class, [
                'required'     => false,
            ])
            ->add('staffs', StaffCollectionType::class, [
                'required'     => false,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Team::class,
        ]);
    }

    public function getParent(): string
    {
        return AbstractForm::class;
    }
}
