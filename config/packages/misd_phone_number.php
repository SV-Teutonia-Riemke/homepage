<?php

declare(strict_types=1);

use Misd\PhoneNumberBundle\Doctrine\DBAL\Types\PhoneNumberType;
use Symfony\Component\DependencyInjection\Loader\Configurator\App;

return App::config([
    'doctrine' => [
        'dbal' => [
            'types' => [
                'phone_number' => PhoneNumberType::class,
            ],
        ],
    ],
]);
