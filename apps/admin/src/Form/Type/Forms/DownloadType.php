<?php

declare(strict_types=1);

namespace App\Admin\Form\Type\Forms;

use App\Form\Type\Entities\FileEntityType;
use App\Storage\Entity\Download;
use Override;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Callback;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Url;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

/** @extends AbstractType<Download> */
final class DownloadType extends AbstractType
{
    /** @inheritDoc */
    public function buildForm(
        FormBuilderInterface $builder,
        array $options,
    ): void {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Name',
                'constraints' => [
                    new NotBlank(),
                ],
            ])
            ->add('enabled', CheckboxType::class, [
                'label' => 'Aktiviert',
                'required' => false,
            ])
            ->add('file', FileEntityType::class, [
                'label' => 'Datei',
                'required' => false,
            ])
            ->add('uri', UrlType::class, [
                'label' => 'URL',
                'required' => false,
                'constraints' => [
                    new Url(),
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Download::class,
            'empty_data' => static fn (FormInterface $form): Download => new Download(
                $form->get('name')->getData() ?? '',
                $form->get('uri')->getData(),
                $form->get('file')->getData(),
            ),
            'constraints' => [
                new Callback(static function (Download $object, ExecutionContextInterface $context, $payload): void {
                    if ($object->getUri() !== null || $object->getFile() !== null) {
                        return;
                    }

                    $context->buildViolation('Du musst entweder eine URL angeben oder eine Datei auswählen')
                        ->atPath('file')
                        ->addViolation();
                }),
            ],
        ]);
    }

    #[Override]
    public function getParent(): string
    {
        return AbstractForm::class;
    }
}
