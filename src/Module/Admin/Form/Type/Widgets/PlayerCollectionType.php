<?php

declare(strict_types=1);

namespace App\Module\Admin\Form\Type\Widgets;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\OptionsResolver\OptionsResolver;

final class PlayerCollectionType extends AbstractType
{
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'label' => 'Spieler',
            'entry_type'   => PlayerType::class,
            'allow_add'    => true,
            'allow_delete' => true,
            'by_reference' => false,
        ]);
    }

    public function getParent(): string
    {
        return CollectionType::class;
    }
}
