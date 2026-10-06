<?php

/**
 * @see https://github.com/artesaos/seotools
 */

return [
    'inertia' => env('SEO_TOOLS_INERTIA', false),
    'meta' => [
        /*
         * The default configurations to be used by the meta generator.
         */
        'defaults' => [
            'title' => 'Drainusantara', // set false to total remove
            'titleBefore' => false, // Put defaults.title before page title, like 'It's Over 9000! - Dashboard'
            'description' => 'Jasa pelancaran saluran pipa mampet wastafel & kloset tanpa bongkar keramik di Jabodetabek, Semarang & Lampung. Mesin spiral baja, garansi 30 hari.',
            'separator' => ' | ',
            'keywords' => ['jasa saluran mampet', 'drain cleaner rooter', 'wc mampet', 'wastafel mampet', 'cctv pipa', 'tanpa bongkar'],
            'canonical' => 'current', // Set to null or 'full' to use Url::full(), set to 'current' to use Url::current(), set false to total remove
            'robots' => 'index, follow, max-image-preview:large, max-snippet:-1, max-video-preview:-1',
        ],
        /*
         * Webmaster tags are always added.
         */
        'webmaster_tags' => [
            'google' => null,
            'bing' => null,
            'alexa' => null,
            'pinterest' => null,
            'yandex' => null,
            'norton' => null,
        ],

        'add_notranslate_class' => false,
    ],
    'opengraph' => [
        /*
         * The default configurations to be used by the opengraph generator.
         */
        'defaults' => [
            'title' => 'Drainusantara - Jasa Saluran Pipa Mampet Tanpa Bongkar',
            'description' => 'Solusi cepat saluran pipa wastafel, toilet & floor drain mampet dengan mesin spiral baja & kamera CCTV pipa. Tanpa bongkar keramik, garansi 30 hari.',
            'url' => null,
            'type' => 'website',
            'site_name' => 'Drainusantara',
            'images' => ['/images/hero-technician.webp'],
        ],
    ],
    'twitter' => [
        /*
         * The default values to be used by the twitter cards generator.
         */
        'defaults' => [
            'card' => 'summary_large_image',
            'site' => '@drainusantara',
            'images' => ['/images/hero-technician.webp'],
        ],
    ],
    'json-ld' => [
        /*
         * The default configurations to be used by the json-ld generator.
         */
        'defaults' => [
            'title' => 'Drainusantara - Jasa Saluran Pipa Mampet',
            'description' => 'Layanan pelancaran saluran mampet tanpa bongkar & inspeksi CCTV pipa.',
            'url' => null,
            'type' => 'PlumbingService',
            'images' => ['/images/hero-technician.webp'],
        ],
    ],
];
