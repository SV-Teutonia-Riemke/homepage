<?php

declare(strict_types=1);

namespace App\Admin\Form\Type\Forms;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/** @extends AbstractType<array> */
final class AbstractForm extends AbstractType
{
    public const string BUTTON_SUBMIT         = 'submit';
    public const string BUTTON_SUBMIT_AND_NEW = 'submitAndNew';

    /**
     * @phpstan-param FormBuilderInterface<array<mixed>|null> $builder
     *
     * @inheritDoc
     */
    public function buildForm(
        FormBuilderInterface $builder,
        array $options,
    ): void {
        if ($options['submit_button'] === true) {
            $builder->add(self::BUTTON_SUBMIT, SubmitType::class);
        }

        if ($options['submit_new_button'] === false) {
            return;
        }

        $builder->add(self::BUTTON_SUBMIT_AND_NEW, SubmitType::class);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->define('submit_button')->default(true)->allowedTypes('bool');
        $resolver->define('submit_new_button')->default(true)->allowedTypes('bool');
    }
}
