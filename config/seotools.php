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
        'defaults'       => [
            'title'        => "Drainusantara", // set false to total remove
            'titleBefore'  => false, // Put defaults.title before page title, like 'It's Over 9000! - Dashboard'
            'description'  => 'Jasa pelancaran saluran pipa mampet profesional tanpa bongkar keramik di Jabodetabek, Semarang, dan Bandar Lampung. Garansi 30 hari.',
            'separator'    => ' | ',
            'keywords'     => ['jasa saluran mampet', 'drain cleaner rooter', 'wc mampet', 'wastafel mampet', 'cctv pipa'],
            'canonical'    => false, // Set to null or 'full' to use Url::full(), set to 'current' to use Url::current(), set false to total remove
            'robots'       => 'all', // Set to 'all', 'none' or any combination of index/noindex and follow/nofollow
        ],
        /*
         * Webmaster tags are always added.
         */
        'webmaster_tags' => [
            'google'    => null,
            'bing'      => null,
            'alexa'     => null,
            'pinterest' => null,
            'yandex'    => null,
            'norton'    => null,
        ],

        'add_notranslate_class' => false,
    ],
    'opengraph' => [
        /*
         * The default configurations to be used by the opengraph generator.
         */
        'defaults' => [
            'title'       => 'Drainusantara - Jasa Saluran Pipa Mampet Tanpa Bongkar',
            'description' => 'Solusi cepat tuntas wastafel, toilet, dan floor drain mampet dengan mesin spiral & CCTV pipa 30M bergaransi 30 hari.',
            'url'         => null,
            'type'        => 'website',
            'site_name'   => 'Drainusantara',
            'images'      => [],
        ],
    ],
    'twitter' => [
        /*
         * The default values to be used by the twitter cards generator.
         */
        'defaults' => [
            //'card'        => 'summary',
            //'site'        => '@Drainusantara',
        ],
    ],
    'json-ld' => [
        /*
         * The default configurations to be used by the json-ld generator.
         */
        'defaults' => [
            'title'       => 'Drainusantara - Jasa Saluran Pipa Mampet',
            'description' => 'Layanan pelancaran saluran mampet tanpa bongkar & inspeksi CCTV pipa.',
            'url'         => null,
            'type'        => 'HomeAndConstructionBusiness',
            'images'      => [],
        ],
    ],
];
