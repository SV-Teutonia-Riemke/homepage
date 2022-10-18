<?php

declare(strict_types=1);

namespace App\Module\Admin\Form\Type\Forms;

use App\Storage\Entity\ConfigSetting;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Event\PostSetDataEvent;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

use function assert;

final class ConfigSettingType extends AbstractType
{
    /** @inheritDoc */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->addEventListener(FormEvents::POST_SET_DATA, static function (PostSetDataEvent $event): void {
            $setting = $event->getData();
            assert($setting instanceof ConfigSetting);

            $event->getForm()->add('value', $setting->getType()->getFormType(), [
                'label'    => $setting->getName(),
                'required' => false,
                'setter'   => static function (ConfigSetting $configSetting, $value): void {
                    $value = $value === null ? null : (string) $value;
                    $configSetting->setValue($value);
                },
            ]);
        });
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ConfigSetting::class,
        ]);
    }
}
