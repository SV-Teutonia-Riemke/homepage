<?php

declare(strict_types=1);

namespace App\Form\Type\Widgets;

use App\Domain\YearGroup;
use Psr\Clock\ClockInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\OptionsResolver\OptionsResolver;

final class YearGroupType extends AbstractType
{
    public function __construct(
        private readonly ClockInterface $clock,
    ) {
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $year    = (int) $this->clock->now()->format('Y');
        $minYear = 2000;
        $maxYear = $year + 5;

        $years = [];

        for ($i = $minYear; $i <= $maxYear; $i++) {
            $years[] = YearGroup::fromYears($i, $i + 1);
        }

        $resolver->setDefaults([
            'choices'      => $years,
            'choice_value' => static fn (YearGroup|null $group): string|null => $group?->__toString(),
            'choice_label' => static fn (YearGroup $group): string => $group->getDisplayName(),
        ]);
    }

    public function getParent(): string
    {
        return ChoiceType::class;
    }
}
