<?php

declare(strict_types=1);

namespace App\Module\Admin\Form\Type\Forms;

use Shlinkio\Shlink\SDK\ShortUrls\Model\ShortUrl;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

final class ShortUrlType extends AbstractType
{
    /** @inheritDoc */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('shortUrl', UrlType::class, [
                'constraints' => [
                    new NotBlank(),
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
//            'data_class' => ShortUrl::class,
        ]);
    }

    public function getParent(): string
    {
        return AbstractForm::class;
    }
}
