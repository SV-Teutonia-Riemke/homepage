<?php

declare(strict_types=1);

namespace App\Module\Admin\Form\Type\Forms;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;

final class ConfigSettingCollectionType extends AbstractType
{
    /** @inheritDoc */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->add('settings', CollectionType::class, [
            'entry_type' => ConfigSettingType::class,
        ]);
    }
}
