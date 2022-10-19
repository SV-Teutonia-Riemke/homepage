<?php

declare(strict_types=1);

namespace App\Form\Type\Widgets;

use App\Domain\StaffPosition;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EnumType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Translation\TranslatableMessage;

final class StaffPositionType extends AbstractType
{
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'class'        => StaffPosition::class,
            'choice_label' => static fn (StaffPosition $staffPosition): TranslatableMessage => $staffPosition->getTranslatable(),
        ]);
    }

    public function getParent(): string
    {
        return EnumType::class;
    }
}
