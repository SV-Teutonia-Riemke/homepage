<?php

declare(strict_types=1);

namespace App\Twig\Components\Bootstrap;

use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;
use Symfony\UX\TwigComponent\Attribute\PostMount;
use Symfony\UX\TwigComponent\Attribute\PreMount;

use function array_keys;
use function ksort;

#[AsTwigComponent(
    name: 'bs:badge',
    template: 'components/bootstrap/badge.html.twig',
)]
final class BadgeComponent
{
    public string|null $label = null;

    public string|null $visuallyHiddenLabel = null;

    /**  @var "inline" | "top-end" */
    public string $position = 'inline';

    /**
     * @param array<string, string> $data
     *
     * @return array<string, string>
     */
    #[PreMount]
    public function validate(array $data): array
    {
        $resolver = new OptionsResolver();
        $resolver->setDefined(array_keys($data));

        $resolver->setDefaults([
            'position' => 'inline',
        ]);

        $resolver->setAllowedValues('position', ['inline', 'top-end']);

        return [
            ...$data,
            ...$resolver->resolve($data),
        ];
    }

    /**
     * @param array<string, string> $data
     *
     * @return array<string, string>
     */
    #[PostMount]
    public function configureAttributes(array $data): array
    {
        if ($this->label !== null) {
            $class = 'badge';
        } else {
            $class = 'p-2 rounded-circle'; // spacing to display generic indicator
        }

        // predefined styling
        if ($this->position === 'top-end') {
            $class .= ' position-absolute top-0 start-100 translate-middle';
        }

        $data = [
            ...$data,
            'class' => $class . ($data['class'] !== '' ? ' ' . $data['class'] : ''),
        ];
        ksort($data);

        return $data;
    }
}
