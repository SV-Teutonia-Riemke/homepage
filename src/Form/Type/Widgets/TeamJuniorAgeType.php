<?php

declare(strict_types=1);

namespace App\Form\Type\Widgets;

use App\Domain\TeamJuniorAge;
use Override;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EnumType;
use Symfony\Component\OptionsResolver\OptionsResolver;

use function strtoupper;

/** @extends AbstractType<TeamJuniorAge> */
final class TeamJuniorAgeType extends AbstractType
{
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'class'        => TeamJuniorAge::class,
            'choice_label' => static fn (TeamJuniorAge $teamAgeCategory): string => strtoupper($teamAgeCategory->value),
        ]);
    }

    #[Override]
    public function getParent(): string
    {
        return EnumType::class;
    }
}
