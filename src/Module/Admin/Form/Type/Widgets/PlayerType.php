<?php

declare(strict_types=1);

namespace App\Module\Admin\Form\Type\Widgets;

use App\Form\Type\Entities\FileEntityType;
use App\Form\Type\Entities\PersonEntityType;
use App\Form\Type\Widgets\GamePositionType;
use App\Storage\Entity\Player;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

/** @extends AbstractType<Player> */
final class PlayerType extends AbstractType
{
    /** @inheritDoc */
    public function buildForm(
        FormBuilderInterface $builder,
        array $options,
    ): void {
        $builder
            ->add('person', PersonEntityType::class, [
                'label' => 'Person',
                'required'    => false,
                'constraints' => [
                    new NotBlank(),
                ],
            ])
            ->add('image', FileEntityType::class, [
                'label' => 'Profilfoto',
                'required' => false,
            ])
            ->add('position', GamePositionType::class, [
                'label' => 'Position',
                'required' => false,
            ])
            ->add('number', IntegerType::class, [
                'label' => 'Rückennummer',
                'required' => false,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Player::class,
        ]);
    }
}
