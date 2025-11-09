<?php

declare(strict_types=1);

namespace App\Form\Type\Entities;

use App\Storage\Entity\Person;
use Override;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\UX\Autocomplete\Form\AsEntityAutocompleteField;
use Symfony\UX\Autocomplete\Form\BaseEntityAutocompleteType;

use function Symfony\Component\String\u;

/** @extends AbstractType<Person> */
#[AsEntityAutocompleteField]
final class PersonEntityType extends AbstractType
{
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'class'        => Person::class,
            'choice_label' => static fn (Person $person): string => $person->getFullName(),
            'group_by'     => static fn (Person $person): string => u($person->getLastName())->upper()->truncate(1)->toString(),
        ]);
    }

    #[Override]
    public function getParent(): string
    {
        return BaseEntityAutocompleteType::class;
    }
}
