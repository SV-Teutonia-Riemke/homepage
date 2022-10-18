<?php

declare(strict_types=1);

namespace App\Module\Admin\Form\Type\Forms;

use App\Module\Admin\Form\Type\Widgets\PersonGroupMemberCollectionType;
use App\Storage\Entity\PersonGroup;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

final class PersonGroupType extends AbstractType
{
    /** @inheritDoc */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'constraints' => [
                    new NotBlank(),
                ],
            ])
            ->add('members', PersonGroupMemberCollectionType::class, [
                'required'     => false,
                'by_reference' => false,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => PersonGroup::class,
        ]);
    }

    public function getParent(): string
    {
        return AbstractForm::class;
    }
}
