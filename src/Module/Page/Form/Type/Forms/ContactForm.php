<?php

declare(strict_types=1);

namespace App\Module\Page\Form\Type\Forms;

use App\Module\Page\Form\Model\Contact;
use EWZ\Bundle\RecaptchaBundle\Form\Type\EWZRecaptchaV3Type;
use EWZ\Bundle\RecaptchaBundle\Validator\Constraints\IsTrueV3;
use Misd\PhoneNumberBundle\Form\Type\PhoneNumberType;
use Misd\PhoneNumberBundle\Validator\Constraints\PhoneNumber;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

/** @extends AbstractType<Contact> */
class ContactForm extends AbstractType
{
    /** @inheritDoc */
    public function buildForm(
        FormBuilderInterface $builder,
        array $options,
    ): void {
        $builder
            ->add('subject', ChoiceType::class, [
                'label' => 'Anliegen',
                'placeholder' => 'Bitte wählen',
                'choices' => [
                    'Allgemeine Anfrage' => 'Allgemeine Anfrage',
                    'Fragen zur Mitgliedschaft' => 'Fragen zur Mitgliedschaft',
                    'Daten der Mitgliedschaft ändern' => 'Daten der Mitgliedschaft ändern',
                    'Kündigen' => 'Kündigen',
                    'Sponsoring' => 'Sponsoring',
                ],
                'constraints' => [
                    new NotBlank(),
                ],
            ])
            ->add('firstName', TextType::class, [
                'label' => 'Vorname',
                'constraints' => [
                    new NotBlank(),
                    new Length(min: 2, max: 100),
                ],
                'attr' => [
                    'placeholder' => 'Alex',
                ],
            ])
            ->add('lastName', TextType::class, [
                'label' => 'Nachname',
                'constraints' => [
                    new NotBlank(),
                    new Length(min: 2, max: 100),
                ],
                'attr' => [
                    'placeholder' => 'Muster',
                ],
            ])
            ->add('email', EmailType::class, [
                'label' => 'E-Mail-Adresse',
                'help' => 'Wir benötigen deine E-Mail-Adresse, um dir antworten zu können.',
                'constraints' => [
                    new NotBlank(),
                    new Email(),
                    new Length(max: 100),
                ],
                'attr' => [
                    'placeholder' => 'deine-adresse@anbieter.tld',
                ],
            ])
            ->add('phoneNumber', PhoneNumberType::class, [
                'label' => 'Telefonnummer',
                'help' => 'Optional, wenn du auch telefonisch erreichbar sein möchtest.',
                'default_region' => 'DE',
                'required' => false,
                'widget' => PhoneNumberType::WIDGET_SINGLE_TEXT,
                'attr' => [
                    'placeholder' => '+49 123 456789',
                ],
                'constraints' => [
                    new PhoneNumber(),
                ],
            ])
            ->add('content', TextareaType::class, [
                'label' => 'Dein Anliegen',
                'constraints' => [
                    new NotBlank(),
                    new Length(min: 2, max: 50000),
                ],
                'attr' => [
                    'placeholder' => 'Deine Nachricht an uns...',
                ],
            ])
            ->add('recaptcha', EWZRecaptchaV3Type::class, [
                'mapped' => false,
                'constraints' => [
                    new IsTrueV3(),
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
