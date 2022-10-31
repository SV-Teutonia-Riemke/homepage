<?php

declare(strict_types=1);

namespace App\Infrastructure\Config;

use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

final class ConfigBuilder
{
    public function build(): ConfigTreeCollection
    {
        $collection = new ConfigTreeCollection();
        $collection
            ->add(
                (new ConfigTree('general'))
                    ->addItem(
                        new ConfigItem(
                            'imprint',
                            CKEditorType::class,
                        ),
                    )
                    ->addItem(
                        new ConfigItem(
                            'privacy_polices',
                            CKEditorType::class,
                        ),
                    )
                    ->addItem(
                        new ConfigItem(
                            'copyright',
                            CKEditorType::class,
                        ),
                    )
                    ->addItem(
                        new ConfigItem(
                            'disclaimer',
                            CKEditorType::class,
                        ),
                    ),
            )
            ->add(
                (new ConfigTree('social_media'))
                    ->addItem(
                        new ConfigItem(
                            'facebook',
                            TextType::class,
                        ),
                    )
                    ->addItem(
                        new ConfigItem(
                            'instagram',
                            TextType::class,
                        ),
                    ),
            );

        return $collection;
    }
}
