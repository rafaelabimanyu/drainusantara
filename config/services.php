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
        'legal_name' => 'PT Jawa Jaya Rooter',
        'trade_name' => 'Drainusantara',
        'full_name' => 'Drainusantara - Jasa Saluran Pipa Mampet',
        'phone' => env('COMPANY_PHONE', '+6285609009009'),
        'whatsapp' => env('WHATSAPP_NUMBER', '6285609009009'),
        'email' => env('COMPANY_OFFICE_EMAIL', 'drainusantara@gmail.com'),
        'google_maps_url' => env('GOOGLE_MAPS_URL', 'https://maps.google.com/?cid=drainusantara'),
        'address' => [
            'full' => env('COMPANY_OFFICE_ADDRESS', 'Jl. Manunggal XVII No. 104, RT.5/RW.11, Lubang Buaya, Kec. Cipayung, Kota Jakarta Timur, DKI Jakarta 13810'),
            'street' => 'Jl. Manunggal XVII No. 104, RT.5/RW.11, Lubang Buaya, Kec. Cipayung',
            'locality' => 'Kota Jakarta Timur',
            'region' => 'DKI Jakarta',
            'postal_code' => '13810',
            'country' => 'ID',
        ],
        'geo' => [
            'latitude' => -6.2906,
            'longitude' => 106.8974,
        ],
    ],

];
