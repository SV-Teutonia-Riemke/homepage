<?php

declare(strict_types=1);

namespace App\Admin\Form\Type\Widgets;

use App\Form\Type\Entities\PersonEntityType;
use App\Form\Type\Widgets\StaffPositionType;
use App\Storage\Entity\Staff;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\NotBlank;

/** @extends AbstractType<Staff> */
final class StaffType extends AbstractType
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
//            ->add('image', FileEntityType::class, [
//                'required' => false,
//            ])
            ->add('position', StaffPositionType::class, [
                'label' => 'Position',
                'required' => false,
            ])
            ->add('emailAddress', EmailType::class, [
                'label' => 'E-Mail-Adresse',
                'constraints' => [
                    new Email(),
                ],
                'required' => false,
                'attr' => [
                    'placeholder' => 'E-Mail-Adresse der Person überschreiben',
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Staff::class,
        ]);
    }
}
