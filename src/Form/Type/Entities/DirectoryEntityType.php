<?php

declare(strict_types=1);

namespace App\Form\Type\Entities;

use App\Storage\Entity\Directory;
use Override;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\UX\Autocomplete\Form\AsEntityAutocompleteField;
use Symfony\UX\Autocomplete\Form\BaseEntityAutocompleteType;

/** @extends AbstractType<Directory> */
#[AsEntityAutocompleteField]
final class DirectoryEntityType extends AbstractType
{
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'class'        => Directory::class,
            'choice_label' => static fn (Directory $directory): string => $directory->getPathName(),
        ]);
    }

    #[Override]
    public function getParent(): string
    {
        return BaseEntityAutocompleteType::class;
    }
}
