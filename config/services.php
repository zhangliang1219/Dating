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
        'client_id' => env('GOOGLE_CLIENT_ID', '64590224812-56p1q7u6fsf6hf8m42jcacpk4joj7f9s.apps.googleusercontent.com'),
        'client_secret' => env('GOOGLE_CLIENT_SECRET', 'l9XAlNnKRuLDGWw1rA8v978G'),
        'redirect' => env('APP_URL', 'https://team10.devhostserver.com/Dating/public').'/callback/google',
    ],


];
