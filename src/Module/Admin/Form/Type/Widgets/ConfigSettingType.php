<?php

declare(strict_types=1);

namespace App\Module\Admin\Form\Type\Widgets;

use App\Infrastructure\Config\ConfigItem;
use App\Storage\Entity\ConfigSetting;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Event\PostSetDataEvent;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

use function assert;

/** @extends AbstractType<ConfigSetting> */
final class ConfigSettingType extends AbstractType
{
    /** @inheritDoc */
    public function buildForm(
        FormBuilderInterface $builder,
        array $options,
    ): void {
        $configItem = $options['config_item'];
        assert($configItem instanceof ConfigItem);

        $builder->addEventListener(FormEvents::POST_SET_DATA, static function (PostSetDataEvent $event) use ($configItem): void {
            $setting = $event->getData();
            assert($setting instanceof ConfigSetting);

            $formOptions = $configItem->formOptions + [
                'label'    => $configItem->getLabel(),
                'required' => false,
                'setter'   => static function (ConfigSetting $configSetting, $value): void {
                        $value = $value === null ? null : (string) $value;
                        $configSetting->setValue($value);
                },
            ];

            $event->getForm()->add('value', $configItem->formType, $formOptions);
        });
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'label'      => false,
            'data_class' => ConfigSetting::class,
        ]);

        $resolver->define('config_item')->allowedTypes(ConfigItem::class)->required();
    }
}
