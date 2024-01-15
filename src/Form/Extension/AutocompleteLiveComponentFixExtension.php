<?php

declare(strict_types=1);

namespace App\Form\Extension;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EnumType;
use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\OptionsResolver\OptionsResolver;

use function uniqid;

class AutocompleteLiveComponentFixExtension extends AbstractTypeExtension
{
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setNormalizer('row_attr', static function (Options $options, $value) {
            if ($options['autocomplete']) {
                $value['data-live-id'] = uniqid('autocomplete-', true);
            }

            return $value;
        });
    }

    /** @return array<class-string> */
    public static function getExtendedTypes(): iterable
    {
        return [
            ChoiceType::class,
            EntityType::class,
            EnumType::class,
        ];
    }
}
