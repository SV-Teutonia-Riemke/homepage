<?php

declare(strict_types=1);

namespace App\Module\Admin\Form\Type\Forms;

use App\Form\Type\Entities\FileEntityType;
use App\Storage\Entity\Person;
use Misd\PhoneNumberBundle\Form\Type\PhoneNumberType;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

/** @extends AbstractType<Person> */
final class PersonType extends AbstractType
{
    /** @inheritDoc */
    public function buildForm(
        FormBuilderInterface $builder,
        array $options,
    ): void {
        $builder
            ->add('firstName', TextType::class, [
                'label' => 'Vorname',
                'constraints' => [
                    new NotBlank(),
                ],
            ])
            ->add('lastName', TextType::class, [
                'label' => 'Nachname',
                'constraints' => [
                    new NotBlank(),
                ],
            ])
            ->add('anonymizeLastName', CheckboxType::class, [
                'label' => 'Nachname anonymisieren',
                'required' => false,
            ])
            ->add('image', FileEntityType::class, [
                'label' => 'Profilbild',
                'required' => false,
            ])
            ->add('phoneNumber', PhoneNumberType::class, [
                'label' => 'Telefonnummer',
                'required' => false,
            ])
            ->add('emailAddress', EmailType::class, [
                'label' => 'E-Mail-Adresse',
                'required' => false,
            ])
            ->add('facebook', TextType::class, [
                'label' => 'Facebook URL',
                'required' => false,
            ])
            ->add('instagram', TextType::class, [
                'label' => 'Instagram URL',
                'required' => false,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class'  => Person::class,
            'constraints' => [
                new UniqueEntity(fields: ['firstName', 'lastName']),
            ],
        ]);
    }

    public function getParent(): string
    {
        return AbstractForm::class;
    }
}
