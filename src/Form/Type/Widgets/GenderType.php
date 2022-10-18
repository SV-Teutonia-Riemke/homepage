<?php

declare(strict_types=1);

namespace App\Form\Type\Widgets;

use App\Domain\Gender;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EnumType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Translation\TranslatableMessage;

final class GenderType extends AbstractType
{
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'class'        => Gender::class,
            'choice_label' => static fn (Gender $gender): TranslatableMessage => $gender->getTranslatable(),
        ]);
    }

    public function getParent(): string
    {
        return EnumType::class;
    }
}
