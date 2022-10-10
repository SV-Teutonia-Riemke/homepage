<?php

declare(strict_types=1);

namespace App\Module\Admin\Form\Type\Forms;

use App\Storage\Entity\Directory;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\File;
use Symfony\UX\Dropzone\Form\DropzoneType;

final class FileUploadType extends AbstractType
{
    /**
     * @inheritDoc
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('directory', EntityType::class, [
                'class'    => Directory::class,
                'required' => false,
            ])
            ->add('file', DropzoneType::class, [
                'label'       => 'File',
                'mapped'      => false,
                'required'    => false,
                'constraints' => [
                    new File([
                        'maxSize' => '20M',
                    ]),
                ],
            ]);
    }

    public function getParent(): string
    {
        return AbstractForm::class;
    }
}