<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, SparkPost and others. This file provides a sane default
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
        'endpoint' => env('MAILGUN_ENDPOINT', 'api.mailgun.net'),
    ],

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'sparkpost' => [
        'secret' => env('SPARKPOST_SECRET'),
    ],
    
    
    'facebook' => [
        'client_id' => env('FACEBOOK_CLIENT_ID','1512881845563188'),  // Your Facebook App ID
        'client_secret' => env('FACEBOOK_CLIENT_SECRET','c2f9607594857cb187f68f5bf209ceb7'), // Your Facebook App Secret
        'redirect' => env('APP_URL', 'https://team10.devhostserver.com/Dating/public').'/callback/facebook',
    ],
        
    'google' => [
        'client_id' => env('GOOGLE_CLIENT_ID', '580929387209-7lqhafnegskcema1ucdm739o75iiagtf.apps.googleusercontent.com'),
        'client_secret' => env('GOOGLE_CLIENT_SECRET', '7uGrX7rQZteyq8DtAarhhjAD'),
        'redirect' => env('APP_URL', 'https://team10.devhostserver.com/Dating/public').'/callback/google',
    ],


];
