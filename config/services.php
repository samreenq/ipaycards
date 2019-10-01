<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Stripe, Mailgun, SparkPost and others. This file provides a sane
    | default location for this type of information, allowing packages
    | to have a conventional place to find your various credentials.
    |
    */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
        'endpoint' => env('MAILGUN_ENDPOINT', 'api.mailgun.net'),
    ],

    'ses' => [
        'key' => env('SES_KEY'),
        'secret' => env('SES_SECRET'),
        'region' => env('SES_REGION', 'us-east-1'),
    ],

    'sparkpost' => [
        'secret' => env('SPARKPOST_SECRET'),
    ],

    'stripe' => [
        'model' => App\User::class,
        'key' => env('STRIPE_KEY'),
        'secret' => env('STRIPE_SECRET'),
        'webhook' => [
            'secret' => env('STRIPE_WEBHOOK_SECRET'),
            'tolerance' => env('STRIPE_WEBHOOK_TOLERANCE', 300),
        ],
    ],

    'facebook' => [
        'client_id' => '456015911874179',         // Your GitHub Client ID
        'client_secret' => 'e4435c1a490af46ec9357c6c0c1a20fb', // Your GitHub Client Secret
        'redirect' => APP_FULL_URL.'login/facebook/callback',
    ],

    'google' => [
        'client_id' => '812606195787-0b51kpjo3m57ehqge2eeq29ftsmivv4j.apps.googleusercontent.com',         // Your GitHub Client ID
        'client_secret' => '0FRtglcanl1N5YX6z0QFNyI5', // Your GitHub Client Secret
        'redirect' => APP_FULL_URL.'login/google/callback',
    ],

];
