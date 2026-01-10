<?php

declare(strict_types=1);

use HWI\Bundle\OAuthBundle\HWIOAuthBundle;
use Symfony\Bundle\SecurityBundle\SecurityBundle;

return [
    SecurityBundle::class => ['all' => true],
    HWIOAuthBundle::class => ['all' => true],
];
