<?php

declare(strict_types=1);

namespace App\Module\Admin\Form\Type\Widgets;

use App\Form\Type\Entities\PersonEntityType;
use App\Storage\Entity\PersonGroupMember;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

final class PersonGroupMemberType extends AbstractType
{
    /** @inheritDoc */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('person', PersonEntityType::class, [
                'required'    => false,
            ])
            ->add('jobTitle', TextType::class, [
                'required' => false,
            ])
            ->add('provisional', CheckboxType::class)
            ->add('position', IntegerType::class, []);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => PersonGroupMember::class,
        ]);
    }
}
