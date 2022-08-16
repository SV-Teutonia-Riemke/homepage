<?php

declare(strict_types=1);

namespace App\Module\Admin\Form\Type\Widgets;

use App\Domain\GamePosition;
use App\Form\Type\Entities\PersonEntityType;
use App\Storage\Entity\Player;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EnumType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

final class PlayerType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('person', PersonEntityType::class, [
                'required' => false,
                'constraints' => [
                    new NotBlank(),
                ],
            ])
            ->add('position', EnumType::class, [
                'class'    => GamePosition::class,
                'required' => false,
            ])
            ->add('number', IntegerType::class, [
                'required' => false,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Player::class,
            'empty_data' => static function (FormInterface $form): Player {
                return new Player(
                    $form->get('person')->getData()
                );
            },
        ]);
    }
}
