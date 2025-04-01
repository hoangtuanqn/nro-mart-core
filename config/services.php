<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
        'endpoint' => env('MAILGUN_ENDPOINT', 'api.mailgun.net'),
        'scheme' => 'https',
    ],

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],
    // 'google' => [
    //     'client_id' => config_get('login_social.google.client_id', ''),
    //     'client_secret' => config_get('login_social.google.client_secret', ''),
    //     'redirect' => config_get('login_social.google.redirect', ''),
    // ],
    // 'facebook' => [
    //     'client_id' => config_get('login_social.facebook.client_id', ''),
    //     'client_secret' => config_get('login_social.facebook.client_secret', ''),
    //     'redirect' => config_get('login_social.facebook.redirect', ''),
    // ],
    'google' => [
        'client_id' => '',
        'client_secret' => '',
        'redirect' => '',
    ],
    'facebook' => [
        'client_id' => '713944317580357',
        'client_secret' => '481beed7538a8b7318c45e94401f4e3c',
        'redirect' => 'http://localhost:8000/auth/facebook/callback',
    ],

];
