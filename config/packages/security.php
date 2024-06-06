<?php

declare(strict_types=1);

use App\Security\UserProvider;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;

return static function (ContainerConfigurator $containerConfigurator): void {
    $containerConfigurator->extension('security', [
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
            'main' => [
                'form_login' => [
                    'login_path' => 'app_admin_login',
                    'check_path' => 'app_admin_login',
                    'enable_csrf' => true,
                    'default_target_path' => 'app_admin_index',
                ],
                'oauth' => [
                    'resource_owners' => [
                        'azure' => 'azure_login',
                    ],
                    'login_path' => 'app_admin_login',
                    'use_forward' => false,
                    'failure_path' => 'app_admin_login',
                    'default_target_path' => 'app_admin_index',
                    'oauth_user_provider' => [
                        'service' => UserProvider::class,
                    ],
                ],
                'entry_point' => 'form_login',
                'logout' => [
                    'path' => 'app_admin_logout',
                    'target' => 'app_admin_login',
                ],
            ],
        ],
        'access_control' => [
            [
                'path' => '^/admin/login',
                'roles' => 'PUBLIC_ACCESS',
            ],
            [
                'path' => '^/admin',
                'roles' => 'ROLE_USER',
            ],
            [
                'path' => '^/connect',
                'roles' => 'PUBLIC_ACCESS',
            ],
        ],
    ]);

    if ($containerConfigurator->env() !== 'test') {
        return;
    }

    $containerConfigurator->extension('security', [
        'password_hashers' => [
            PasswordAuthenticatedUserInterface::class => [
                'algorithm' => 'auto',
                'cost' => 4,
                'time_cost' => 3,
                'memory_cost' => 10,
            ],
        ],
    ]);
};
