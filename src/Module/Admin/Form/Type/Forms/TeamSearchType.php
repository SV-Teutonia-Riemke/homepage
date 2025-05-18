<?php

declare(strict_types=1);

namespace App\Module\Admin\Form\Type\Forms;

use Spiriit\Bundle\FormFilterBundle\Filter\Form\Type\TextFilterType;
use Spiriit\Bundle\FormFilterBundle\Filter\Query\QueryInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use function sprintf;

/** @extends AbstractType<array{name: string}> */
final class TeamSearchType extends AbstractType
{
    /** @inheritDoc */
    public function buildForm(
        FormBuilderInterface $builder,
        array $options,
    ): void {
        $builder
            ->add('name', TextFilterType::class, [
                'label'        => false,
                'attr'         => [
                    'placeholder'  => 'Suchen...',
                ],
                'apply_filter' => static function (QueryInterface $filterQuery, $field, $values) {
                    if ($values['value'] === null) {
                        return null;
                    }

                    return $filterQuery->createCondition('p.name LIKE :name', [
                        'name' => sprintf('%%%s%%', $values['value']),
                    ]);
                },
            ])
            ->add('season', TextFilterType::class, [
                'label'        => false,
                'attr'         => [
                    'placeholder'  => 'Saison',
                ],
                'apply_filter' => static function (QueryInterface $filterQuery, $field, $values) {
                    if ($values['value'] === null) {
                        return null;
                    }

                    return $filterQuery->createCondition('p.season LIKE :season', [
                        'season' => sprintf('%%%s%%', $values['value']),
                    ]);
                },
            ])
            ->add('ageGroup', TextFilterType::class, [
                'label'        => false,
                'attr'         => [
                    'placeholder'  => 'Altersgruppe',
                ],
                'apply_filter' => static function (QueryInterface $filterQuery, $field, $values) {
                    if ($values['value'] === null) {
                        return null;
                    }

                    return $filterQuery->createCondition('p.ageGroup LIKE :ageGroup', [
                        'ageGroup' => sprintf('%%%s%%', $values['value']),
                    ]);
                },
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'method'          => 'GET',
            'csrf_protection' => false,
        ]);
    }
}
