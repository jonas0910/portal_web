<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Laravel UI Configuration
    |--------------------------------------------------------------------------
    |
    | This file contains the configuration for Laravel UI package.
    | You can customize the authentication views and components.
    |
    */

    'auth' => [
        'views' => [
            'login' => 'auth.login',
            'register' => 'auth.register',
            'passwords' => [
                'email' => 'auth.passwords.email',
                'reset' => 'auth.passwords.reset',
            ],
            'verify' => 'auth.verify',
        ],
    ],

    'preset' => 'bootstrap',
];