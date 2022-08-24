<?php

declare(strict_types=1);

namespace App\Module\Admin\Form\Type\Forms;

use App\Form\Type\Entities\FileEntityType;
use App\Storage\Entity\Person;
use Misd\PhoneNumberBundle\Form\Type\PhoneNumberType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

final class PersonType extends AbstractType
{
    /**
     * @inheritDoc
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('firstName', TextType::class, [
                'constraints' => [
                    new NotBlank(),
                ],
            ])
            ->add('lastName', TextType::class, [
                'required' => false,
            ])
            ->add('anonymizeLastName', CheckboxType::class, [
                'required' => false,
            ])
            ->add('image', FileEntityType::class, [
                'required' => false,
            ])
            ->add('phoneNumber', PhoneNumberType::class, [
                'required' => false,
            ])
            ->add('emailAddress', EmailType::class, [
                'required' => false,
            ])
            ->add('facebook', TextType::class, [
                'required' => false,
            ])
            ->add('instagram', TextType::class, [
                'required' => false,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Person::class,
        ]);
    }

    public function getParent(): string
    {
        return AbstractForm::class;
    }
}
