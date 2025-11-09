<?php

declare(strict_types=1);

namespace App\Module\Admin\Form\Type\Forms;

use App\Form\Type\Entities\DirectoryEntityType;
use App\Storage\Entity\Directory;
use Override;
use Symfony\Bridge\PsrHttpMessage\Factory\UploadedFile;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\All;
use Symfony\Component\Validator\Constraints\File;

/** @extends AbstractType<array{directory: Directory, files: list<UploadedFile>}> */
final class FileUploadType extends AbstractType
{
    /** @inheritDoc */
    public function buildForm(
        FormBuilderInterface $builder,
        array $options,
    ): void {
        $builder
            ->add('directory', DirectoryEntityType::class, [
                'label'    => 'Ordner',
                'required' => false,
            ])
            ->add('files', FileType::class, [
                'label'       => 'Dateien',
                'mapped'      => false,
                'required'    => false,
                'multiple'    => true,
                'constraints' => [
                    new All([
                        new File(maxSize: '20M'),
                    ]),
                ],
            ]);
    }

    #[Override]
    public function getParent(): string
    {
        return AbstractForm::class;
    }
}
