<?php

declare(strict_types=1);

namespace App\Admin\Form\Type\Widgets;

use Override;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\OptionsResolver\OptionsResolver;

/** @extends AbstractType<array> */
final class StaffCollectionType extends AbstractType
{
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'label' => 'Staff',
            'entry_type'   => StaffType::class,
            'allow_add'    => true,
            'allow_delete' => true,
            'by_reference' => false,
        ]);
    }

    #[Override]
    public function getParent(): string
    {
        return CollectionType::class;
    }
}
