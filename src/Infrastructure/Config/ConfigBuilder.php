<?php

declare(strict_types=1);

namespace App\Infrastructure\Config;

use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

final class ConfigBuilder
{
    public function build(): ConfigTreeCollection
    {
        return ConfigTreeCollection::create()->add(
            ConfigTree::create('general')->addItem(
                new ConfigItem(
                    'handball_net_club_id',
                    TextType::class,
                ),
            ),
            ConfigTree::create('tracking')->addItem(
                new ConfigItem(
                    'matomo_enable',
                    ChoiceType::class,
                    [
                        'required' => true,
                        'expanded' => true,
                        'choices'  => [
                            'Nein' => 0,
                            'Ja'   => 1,
                        ],
                    ],
                    default: 0,
                ),
                new ConfigItem(
                    'matomo_url',
                    TextType::class,
                ),
                new ConfigItem(
                    'matomo_id',
                    IntegerType::class,
                ),
            ),
            ConfigTree::create('legal')->addItem(
                new ConfigItem(
                    'imprint',
                    CKEditorType::class,
                ),
                new ConfigItem(
                    'copyright',
                    CKEditorType::class,
                ),
                new ConfigItem(
                    'disclaimer',
                    CKEditorType::class,
                ),
            ),
            ConfigTree::create('privacy')->addItem(
                new ConfigItem(
                    'cookie_consent_enable',
                    ChoiceType::class,
                    [
                        'required' => true,
                        'expanded' => true,
                        'choices'  => [
                            'Nein' => 0,
                            'Ja'   => 1,
                        ],
                    ],
                    default: 1,
                ),
                new ConfigItem(
                    'privacy_polices',
                    CKEditorType::class,
                ),
            ),
            ConfigTree::create('social_media')->addItem(
                new ConfigItem(
                    'facebook',
                    TextType::class,
                ),
                new ConfigItem(
                    'instagram',
                    TextType::class,
                ),
            ),
        );
    }
}
