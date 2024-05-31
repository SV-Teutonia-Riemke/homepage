<?php

declare(strict_types=1);

namespace App\Module\Admin\Form\Type\Forms;

use App\Form\Type\Entities\DirectoryEntityType;
use App\Storage\Entity\Directory;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

final class DirectoryType extends AbstractType
{
    /** @inheritDoc */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Name',
                'constraints' => [
                    new NotBlank(),
                ],
            ])
            ->add('parent', DirectoryEntityType::class, [
                'label' => 'Übergeordnetes Verzeichnis',
                'required' => false,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Directory::class,
            'empty_data' => static function (FormInterface $form): Directory {
                return new Directory(
                    $form->get('name')->getData() ?? '',
                    $form->get('parent')->getData(),
                );
            },
        ]);
    }

    public function getParent(): string
    {
        return AbstractForm::class;
    }
}
