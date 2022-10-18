<?php

declare(strict_types=1);

namespace App\Module\Admin\Form\Type\Forms;

use App\Domain\ConfigType;
use App\Storage\Entity\ConfigSetting;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EnumType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

final class ConfigAddType extends AbstractType
{
    /** @inheritDoc */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'constraints' => [
                    new NotBlank(),
                ],
            ])
            ->add('type', EnumType::class, [
                'class'       => ConfigType::class,
                'constraints' => [
                    new NotBlank(),
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ConfigSetting::class,
            'empty_data' => static function (FormInterface $form): ConfigSetting {
                return new ConfigSetting(
                    $form->get('name')->getData(),
                    $form->get('type')->getData(),
                );
            },
        ]);
    }
}
