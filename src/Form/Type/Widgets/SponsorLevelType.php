<?php

declare(strict_types=1);

namespace App\Form\Type\Widgets;

use App\Domain\SponsorLevel;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EnumType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Translation\TranslatableMessage;

/** @extends AbstractType<SponsorLevel> */
final class SponsorLevelType extends AbstractType
{
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'class'        => SponsorLevel::class,
            'choice_label' => static fn (SponsorLevel $gamePosition): TranslatableMessage => $gamePosition->getTranslatable(),
        ]);
    }

    public function getParent(): string
    {
        return EnumType::class;
    }
}
