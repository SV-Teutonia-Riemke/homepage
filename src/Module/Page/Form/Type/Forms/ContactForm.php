<?php

declare(strict_types=1);

namespace App\Module\Page\Form\Type\Forms;

use App\Module\Page\Form\Model\Contact;
use Misd\PhoneNumberBundle\Form\Type\PhoneNumberType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class ContactForm extends AbstractType
{
    public function buildForm(
        FormBuilderInterface $builder,
        array $options,
    ): void {
        $builder
            ->add('firstName', TextType::class, [
                'label' => 'Vorname',
                'constraints' => [
                    new NotBlank(),
                    new Length(['max' => 100]),
                ],
            ])
            ->add('lastName', TextType::class, [
                'label' => 'Nachname',
                'constraints' => [
                    new NotBlank(),
                    new Length(['max' => 100]),
                ],
            ])
            ->add('email', EmailType::class, [
                'label' => 'E-Mail-Adresse',
                'constraints' => [
                    new NotBlank(),
                    new Email(),
                    new Length(['max' => 250]),
                ],
            ])
            ->add('phoneNumber', PhoneNumberType::class, [
                'label' => 'Telefonnummer',
                'default_region' => 'DE',
                'required' => false,
                'widget' => PhoneNumberType::WIDGET_SINGLE_TEXT,
                'country_display_type' => PhoneNumberType::DISPLAY_COUNTRY_SHORT,
                'country_display_emoji_flag' => true,
                'preferred_country_choices' => ['DE'],
                'constraints' => [
                    new NotBlank(),
                ],
            ])
            ->add('content', TextareaType::class, [
                'label' => 'Dein Anliegen',
                'constraints' => [
                    new NotBlank(),
                    new Length(['min' => 10, 'max' => 50000]),
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Contact::class,
        ]);
    }
}
