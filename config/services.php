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

    'postmark' => [
        'key' => env('POSTMARK_API_KEY'),
    ],

    'resend' => [
        'key' => env('RESEND_API_KEY'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    // Benin / Edo WhatsApp (existing)
    'waapi' => [
        'instance_id' => env('WAAPI_INSTANCE_ID'),
        'api_token'   => env('WAAPI_API_TOKEN'),
        'chat_id'     => env('WAAPI_CHAT_ID'),       // e.g. 2348012345678@c.us
    ],

    // Bayelsa WhatsApp (separate number)
    'waapi_bayelsa' => [
        'instance_id' => env('WAAPI_BAYELSA_INSTANCE_ID'),
        'api_token'   => env('WAAPI_BAYELSA_API_TOKEN'),
        'chat_id'     => env('WAAPI_BAYELSA_CHAT_ID'),
    ],

    // Order notification email addresses per location
    'order_mail' => [
        'benin'   => env('MAIL_BENIN_ADDRESS'),    // support mail — Benin/Edo orders
        'bayelsa' => env('MAIL_BAYELSA_ADDRESS'),  // info mail   — Bayelsa orders
    ],

    'slack' => [
        'notifications' => [
            'bot_user_oauth_token' => env('SLACK_BOT_USER_OAUTH_TOKEN'),
            'channel' => env('SLACK_BOT_USER_DEFAULT_CHANNEL'),
        ],
    ],

];
