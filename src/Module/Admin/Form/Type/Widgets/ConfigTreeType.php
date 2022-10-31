<?php

declare(strict_types=1);

namespace App\Module\Admin\Form\Type\Widgets;

use App\Infrastructure\Config\ConfigSettingProvider;
use App\Infrastructure\Config\ConfigTree;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use function assert;

final class ConfigTreeType extends AbstractType
{
    public function __construct(
        private readonly ConfigSettingProvider $configSettingProvider,
    ) {
    }

    /** @inheritDoc */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $tree = $options['tree'];
        assert($tree instanceof ConfigTree);

        $children = $builder->create('children', FormType::class, ['label' => false]);
        $items    = $builder->create('items', FormType::class, ['label' => false]);

        foreach ($tree->getChildren() as $child) {
            $form = $builder->create($child->getName(), self::class, [
                'tree' => $child,
            ]);

            $children->add($form);
        }

        foreach ($tree->getItems() as $configItem) {
            $setting = $this->configSettingProvider->get($configItem->name);

            $form = $builder->create($configItem->name, ConfigSettingType::class, [
                'config_item' => $configItem,
            ]);
            $form->setData($setting);

            $items->add($form);
        }

        $builder
            ->add($children)
            ->add($items);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'label'    => false,
        ]);

        $resolver->define('tree')->allowedTypes(ConfigTree::class)->required();
    }
}
