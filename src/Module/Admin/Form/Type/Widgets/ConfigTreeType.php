<?php

declare(strict_types=1);

namespace App\Module\Admin\Form\Type\Widgets;

use App\Infrastructure\Config\ConfigSettingProvider;
use App\Infrastructure\Config\ConfigTree;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use function assert;

/** @extends AbstractType<ConfigTree> */
final class ConfigTreeType extends AbstractType
{
    public function __construct(
        private readonly ConfigSettingProvider $configSettingProvider,
    ) {
    }

    /** @inheritDoc */
    public function buildForm(
        FormBuilderInterface $builder,
        array $options,
    ): void {
        $tree = $options['tree'];
        assert($tree instanceof ConfigTree);

        $categories = $builder->create('categories', options: ['compound' => true]);
        $items      = $builder->create('items', options: ['compound' => true]);

        foreach ($tree->getChildren() as $child) {
            $form = $builder->create($child->getName(), self::class, [
                'label' => $child->getLabel(),
                'tree'  => $child,
            ]);

            $categories->add($form);
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
            ->add($categories)
            ->add($items);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->define('tree')->allowedTypes(ConfigTree::class)->required();
    }
}
