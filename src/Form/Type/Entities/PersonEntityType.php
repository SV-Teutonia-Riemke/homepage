<?php

declare(strict_types=1);

namespace App\Form\Type\Entities;

use App\Storage\Entity\Person;
use App\Storage\Repository\PersonRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\UX\Autocomplete\Form\AsEntityAutocompleteField;

#[AsEntityAutocompleteField]
final class PersonEntityType extends AbstractType
{
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'class'         => Person::class,
            'choice_label'  => static fn (Person $person): string => $person->__toString(),
            'query_builder' => static function (PersonRepository $repository) {
                return $repository->createQueryBuilder('p')
                    ->orderBy('p.firstName', 'ASC')
                    ->addOrderBy('p.lastName', 'ASC');
            },
//            'autocomplete' => true
        ]);
    }

    public function getParent(): string
    {
        return EntityType::class;
//        return ParentEntityAutocompleteType::class;
    }
}
