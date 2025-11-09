<?php

declare(strict_types=1);

namespace App\Module\Admin\Form\Type\Forms;

use App\Infrastructure\Config\ConfigBuilder;
use App\Module\Admin\Form\Type\Widgets\ConfigTreeType;
use Override;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/** @extends AbstractType<array> */
final class ConfigType extends AbstractType
{
    public function __construct(
        private readonly ConfigBuilder $configBuilder,
    ) {
    }

    /**
     * @phpstan-param FormBuilderInterface<array<mixed>|null> $builder
     *
     * @inheritDoc
     */
    public function buildForm(
        FormBuilderInterface $builder,
        array $options,
    ): void {
        $collection = $this->configBuilder->build();

        $wrapper = $builder->create('wrapper', options: ['compound' => true]);

        foreach ($collection as $child) {
            $form = $builder->create($child->getName(), ConfigTreeType::class, [
                'label' => $child->getLabel(),
                'tree' => $child,
            ]);

            $wrapper->add($form);
        }

        $builder->add($wrapper);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'label' => false,
            'submit_new_button' => false,
        ]);
    }

    #[Override]
    public function getParent(): string
    {
        return AbstractForm::class;
    }
}
