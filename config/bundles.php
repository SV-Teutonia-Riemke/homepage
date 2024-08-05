<?php

declare(strict_types=1);

use Doctrine\Bundle\DoctrineBundle\DoctrineBundle;
use Doctrine\Bundle\MigrationsBundle\DoctrineMigrationsBundle;
use Eckinox\TinymceBundle\TinymceBundle;
use EWZ\Bundle\RecaptchaBundle\EWZRecaptchaBundle;
use HWI\Bundle\OAuthBundle\HWIOAuthBundle;
use Knp\Bundle\MenuBundle\KnpMenuBundle;
use Knp\Bundle\PaginatorBundle\KnpPaginatorBundle;
use Liip\ImagineBundle\LiipImagineBundle;
use Misd\PhoneNumberBundle\MisdPhoneNumberBundle;
use Oneup\FlysystemBundle\OneupFlysystemBundle;
use Pentatrion\ViteBundle\PentatrionViteBundle;
use Presta\SitemapBundle\PrestaSitemapBundle;
use Sentry\SentryBundle\SentryBundle;
use Shapecode\Bundle\TwigStringLoaderBundle\ShapecodeTwigStringLoaderBundle;
use Spiriit\Bundle\FormFilterBundle\SpiriitFormFilterBundle;
use Stof\DoctrineExtensionsBundle\StofDoctrineExtensionsBundle;
use Symfony\Bundle\FrameworkBundle\FrameworkBundle;
use Symfony\Bundle\MonologBundle\MonologBundle;
use Symfony\Bundle\SecurityBundle\SecurityBundle;
use Symfony\Bundle\TwigBundle\TwigBundle;
use Symfony\Bundle\WebProfilerBundle\WebProfilerBundle;
use Symfony\UX\Autocomplete\AutocompleteBundle;
use Symfony\UX\Dropzone\DropzoneBundle;
use Symfony\UX\Icons\UXIconsBundle;
use Symfony\UX\LiveComponent\LiveComponentBundle;
use Symfony\UX\StimulusBundle\StimulusBundle;
use Symfony\UX\Turbo\TurboBundle;
use Symfony\UX\TwigComponent\TwigComponentBundle;
use Twig\Extra\TwigExtraBundle\TwigExtraBundle;

return [
    FrameworkBundle::class => ['all' => true],
    MonologBundle::class => ['all' => true],
    DoctrineBundle::class => ['all' => true],
    DoctrineMigrationsBundle::class => ['all' => true],
    TwigBundle::class => ['all' => true],
    TwigExtraBundle::class => ['all' => true],
    SecurityBundle::class => ['all' => true],
    WebProfilerBundle::class => ['dev' => true, 'test' => true],
    OneupFlysystemBundle::class => ['all' => true],
    KnpPaginatorBundle::class => ['all' => true],
    TwigComponentBundle::class => ['all' => true],
    TurboBundle::class => ['all' => true],
    KnpMenuBundle::class => ['all' => true],
    LiveComponentBundle::class => ['all' => true],
    AutocompleteBundle::class => ['all' => true],
    DropzoneBundle::class => ['all' => true],
    LiipImagineBundle::class => ['all' => true],
    MisdPhoneNumberBundle::class => ['all' => true],
    SentryBundle::class => ['all' => true],
    StofDoctrineExtensionsBundle::class => ['all' => true],
    SpiriitFormFilterBundle::class => ['all' => true],
    StimulusBundle::class => ['all' => true],
    PrestaSitemapBundle::class => ['all' => true],
    ShapecodeTwigStringLoaderBundle::class => ['all' => true],
    UXIconsBundle::class => ['all' => true],
    TinymceBundle::class => ['all' => true],
    HWIOAuthBundle::class => ['all' => true],
    PentatrionViteBundle::class => ['all' => true],
    EWZRecaptchaBundle::class => ['all' => true],
];
