<?php

declare(strict_types=1);

namespace App\Form\Type\Widgets;

use App\Domain\Role;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\Extension\Core\Type\EnumType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use function array_filter;
use function array_map;
use function array_values;

/** @extends AbstractType<Role> */
class RoleType extends AbstractType
{
    /** @inheritDoc */
    public function buildForm(
        FormBuilderInterface $builder,
        array $options,
    ): void {
        $builder->addModelTransformer(
            new CallbackTransformer(
                $this->transform(...),
                $this->reverseTransform(...),
            ),
        );
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'class' => Role::class,
            'choice_label' => static fn (Role $role): string => $role->getTranslation(),
            'expanded' => true,
            'multiple' => true,
        ]);
    }

    public function getParent(): string
    {
        return EnumType::class;
    }

    /**
     * @param list<string>|null $roles
     *
     * @return list<Role>
     */
    private function transform(array|null $roles): array
    {
        if ($roles === null) {
            return [];
        }

        return array_values(
            array_filter(
                array_map(
                    static fn (string $role): Role|null => Role::tryFrom($role),
                    $roles,
                ),
                static fn (Role|null $role): bool => $role !== null,
            ),
        );
    }

    /**
     * @param list<Role> $roles
     *
     * @return list<string>
     */
    private function reverseTransform(array $roles): array
    {
        // transform the string back to an array
        return array_map(
            static fn (Role $role): string => $role->value,
            $roles,
        );
    }
}
