<?php

return [
    /*
     * |--------------------------------------------------------------------------
     * | Third Party Services
     * |--------------------------------------------------------------------------
     * |
     * | This file is for storing the credentials for third party services such
     * | as Resend, Postmark, AWS, and more. This file provides the de facto
     * | location for this type of information, allowing packages to have
     * | a conventional file to locate the various service credentials.
     * |
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
    'slack' => [
        'notifications' => [
            'bot_user_oauth_token' => env('SLACK_BOT_USER_OAUTH_TOKEN'),
            'channel' => env('SLACK_BOT_USER_DEFAULT_CHANNEL'),
        ],
    ],
    'google' => [
        'site_verification' => env('GOOGLE_SITE_VERIFICATION'),
    ],
    'gtm' => [
        'id' => env('GTM_CONTAINER_ID'),
    ],
    'social' => [
        'instagram' => env('SOCIAL_INSTAGRAM', 'https://instagram.com/drainusantara'),
        'tiktok' => env('SOCIAL_TIKTOK', 'https://tiktok.com/@drainusantara'),
        'youtube' => env('SOCIAL_YOUTUBE', 'https://youtube.com/@drainusantara'),
        'facebook' => env('SOCIAL_FACEBOOK', 'https://facebook.com/drainusantara'),
        'linkedin' => env('SOCIAL_LINKEDIN', 'https://linkedin.com/company/drainusantara'),
        'whatsapp' => env('SOCIAL_WHATSAPP', 'https://wa.me/6285609009009'),
    ],
    'company' => [
        'address' => env('COMPANY_OFFICE_ADDRESS', null),
    ],

];
