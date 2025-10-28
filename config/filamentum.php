<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Filament Panel Path
    |--------------------------------------------------------------------------
    |
    | This configuration sets the URL path for the Filament admin panel.
    | You can override this value in your .env file using the FILAMENTUM_ prefix.
    |
    */

    'path' => env('FILAMENTUM_PATH', 'app'),

    /*
    |--------------------------------------------------------------------------
    | Filament Features
    |--------------------------------------------------------------------------
    |
    | This configuration file is used to enable or disable various Filament
    | features. Set any feature to false to disable it.
    | You can override these values in your .env file using the FILAMENTUM_ prefix.
    |
    */

    'features' => [
        'registration' => env('FILAMENTUM_REGISTRATION', false),
        'password_reset' => env('FILAMENTUM_PASSWORD_RESET', false),
        'email_verification' => env('FILAMENTUM_EMAIL_VERIFICATION', false),
        'email_change_verification' => env('FILAMENTUM_EMAIL_CHANGE_VERIFICATION', false),
        'profile' => env('FILAMENTUM_PROFILE', true),
    ],

];
