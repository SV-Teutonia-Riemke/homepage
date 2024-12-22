<?php

declare(strict_types=1);

namespace App\Form\Type\Widgets;

use App\Domain\TeamAgeCategory;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EnumType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Translation\TranslatableMessage;

/** @extends AbstractType<TeamAgeCategory> */
final class TeamAgeCategoryType extends AbstractType
{
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'class'        => TeamAgeCategory::class,
            'choice_label' => static fn (TeamAgeCategory $teamAgeCategory): TranslatableMessage => $teamAgeCategory->getTranslatable(),
        ]);
    }

    public function getParent(): string
    {
        return EnumType::class;
    }
}
