<?php

declare(strict_types=1);

namespace App\Module\Admin\Form\Type\Forms;

use App\Infrastructure\Config\ConfigBuilder;
use App\Module\Admin\Form\Type\Widgets\ConfigTreeType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

final class ConfigType extends AbstractType
{
    public function __construct(
        private readonly ConfigBuilder $configBuilder,
    ) {
    }

    /** @inheritDoc */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $collection = $this->configBuilder->build();

        $children = $builder->create('children', FormType::class, ['label' => false]);

        foreach ($collection as $child) {
            $form = $builder->create($child->getName(), ConfigTreeType::class, [
                'tree' => $child,
            ]);

            $children->add($form);
        }

        $builder->add($children);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'label' => false,
        ]);
    }
}
