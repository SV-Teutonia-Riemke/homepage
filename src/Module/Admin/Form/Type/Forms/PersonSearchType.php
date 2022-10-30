<?php

declare(strict_types=1);

namespace App\Module\Admin\Form\Type\Forms;

use Lexik\Bundle\FormFilterBundle\Filter\Form\Type\TextFilterType;
use Lexik\Bundle\FormFilterBundle\Filter\Query\QueryInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use function sprintf;

final class PersonSearchType extends AbstractType
{
    /** @inheritDoc */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
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

                    $expression = 'p.firstName LIKE :name OR p.lastName LIKE :name OR p.emailAddress LIKE :name';

                    $parameters = [
                        'name' => sprintf('%%%s%%', $values['value']),
                    ];

                    return $filterQuery->createCondition($expression, $parameters);
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
