<?php

declare(strict_types=1);

namespace App\Module\Admin\Form\Type\Forms;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;

final class AbstractForm extends AbstractType
{
    public const BUTTON_SUBMIT         = 'submit';
    public const BUTTON_SUBMIT_AND_NEW = 'submitAndNew';

    /** @inheritDoc */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add(self::BUTTON_SUBMIT, SubmitType::class)
            ->add(self::BUTTON_SUBMIT_AND_NEW, SubmitType::class);
    }
}
