<?php

declare(strict_types=1);

namespace App\Admin\Form\Type\Widgets;

use Override;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\OptionsResolver\OptionsResolver;

/** @extends AbstractType<PersonGroupMemberType> */
final class PersonGroupMemberCollectionType extends AbstractType
{
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'label' => 'Mitglieder',
            'entry_type'   => PersonGroupMemberType::class,
            'allow_add'    => true,
            'allow_delete' => true,
        ]);
    }

    #[Override]
    public function getParent(): string
    {
        return CollectionType::class;
    }
}
