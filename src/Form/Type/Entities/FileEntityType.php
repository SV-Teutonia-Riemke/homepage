<?php

declare(strict_types=1);

namespace App\Form\Type\Entities;

use App\Storage\Entity\File;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\UX\Autocomplete\Form\AsEntityAutocompleteField;
use Symfony\UX\Autocomplete\Form\BaseEntityAutocompleteType;

 #[AsEntityAutocompleteField]
final class FileEntityType extends AbstractType
{
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'class'        => File::class,
            'choice_label' => static fn (File $file): string => $file->getPathName(),
        ]);
    }

    public function getParent(): string
    {
        return BaseEntityAutocompleteType::class;
    }
}
