<?php

declare(strict_types=1);

use Misd\PhoneNumberBundle\Doctrine\DBAL\Types\PhoneNumberType;
use Symfony\Config\DoctrineConfig;

return static function (
    DoctrineConfig $doctrineConfig,
): void {
    $doctrineConfig->dbal()
        ->type('phone_number', PhoneNumberType::class);
};
