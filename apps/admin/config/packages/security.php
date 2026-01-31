<?php

declare(strict_types=1);

use App\Security\UserProvider;
use Symfony\Component\DependencyInjection\Loader\Configurator\App;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;

return App::config([
    'security' => [
        'password_hashers' => [
            PasswordAuthenticatedUserInterface::class => 'auto',
        ],
        'providers' => [
            'your_custom_user_provider' => [
                'id' => UserProvider::class,
            ],
        ],
        'firewalls' => [
            'dev' => [
                'pattern' => '^/(_(profiler|wdt)|css|images|js|media)/',
                'security' => false,
            ],
            'image_resolver' => [
                'pattern' => '^/media/cache/resolve',
                'security' => false,
            ],
            'main' => [
                'form_login' => [
                    'login_path' => 'admin_login',
                    'check_path' => 'admin_login',
                    'enable_csrf' => true,
                    'default_target_path' => 'admin_index',
                ],
                'oauth' => [
                    'resource_owners' => [
                        'azure' => 'azure_login',
                    ],
                    'login_path' => 'admin_login',
                    'use_forward' => false,
                    'failure_path' => 'admin_login',
                    'default_target_path' => 'admin_index',
                    'oauth_user_provider' => [
                        'service' => UserProvider::class,
                    ],
                ],
                'entry_point' => 'form_login',
                'logout' => [
                    'path' => 'admin_logout',
                    'target' => 'admin_login',
                ],
            ],
        ],
        'access_control' => [
            [
                'path' => '^/login',
                'roles' => 'PUBLIC_ACCESS',
            ],
            [
                'path' => '^/',
                'roles' => 'ROLE_USER',
            ],
            [
                'path' => '^/oauth',
                'roles' => 'PUBLIC_ACCESS',
            ],
        ],
    ],
]);
