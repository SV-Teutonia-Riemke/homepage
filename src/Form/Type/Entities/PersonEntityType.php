<?php

declare(strict_types=1);

namespace App\Form\Type\Entities;

use App\Storage\Entity\Person;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;

final class PersonEntityType extends AbstractType
{
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'class' => Person::class,
        ]);
    }

    public function getParent(): string
    {
        return EntityType::class;
    }
}
