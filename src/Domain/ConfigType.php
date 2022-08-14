<?php

declare(strict_types=1);

namespace App\Domain;

use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\Form\Extension\Core\Type\ColorType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

enum ConfigType: string
{
    case TEXT     = 'text';
    case TEXTAREA = 'textarea';
    case INTEGER  = 'integer';
    case NUMBER   = 'number';
    case COLOR    = 'color';
    case WYSIWYG  = 'wysiwyg';

    public function getFormType(): string
    {
        return match ($this) {
            self::TEXT => TextType::class,
            self::TEXTAREA => TextareaType::class,
            self::INTEGER => IntegerType::class,
            self::NUMBER => NumberType::class,
            self::COLOR => ColorType::class,
            self::WYSIWYG => CKEditorType::class,
        };
    }
}
