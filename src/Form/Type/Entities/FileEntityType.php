<?php

declare(strict_types=1);

namespace App\Form\Type\Entities;

use App\Storage\Entity\File;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;

final class FileEntityType extends AbstractType
{
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'class' => File::class,
        ]);
    }

    public function getParent(): string
    {
        return EntityType::class;
    }
}
