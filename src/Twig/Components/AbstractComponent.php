<?php

declare(strict_types=1);

namespace App\Twig\Components;

use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\UX\TwigComponent\Attribute\PreMount;

abstract class AbstractComponent
{
    /**
     * @param array<string, mixed> $data
     *
     * @return array<string, mixed>
     */
    #[PreMount]
    public function validate(array $data): array
    {
        $resolver = new OptionsResolver();
        $this->configureProps($resolver);

        $resolver->setIgnoreUndefined();

        return [
            ...$data,
            ...$resolver->resolve($data),
        ];
    }

    abstract protected function configureProps(OptionsResolver $resolver): void;
}
