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
            'title' => "Drainusantara - Jasa Saluran Mampet & Pipa Bocor Jabodetabek ", // set false to total remove
            'titleBefore' => 'Drainusantara', // Put defaults.title before page title, like 'It's Over 9000! - Dashboard'
            'description' => 'Jasa pelancaran saluran mampet & deteksi pipa bocor tanpa bongkar di Jabodetabek. Bergaransi 30 hari, respon cepat 24 jam. Hubungi teknisi sekarang!', // set false to total remove
            'separator' => ' - ',
            'keywords' => ['jasa perpipaan, saluran mampet, perbaikan drainase, deteksi pipa bocor, cuci saluran, drainusantara, drainusantara jakarta'],
            'canonical' => 'current', // Set to null or 'full' to use Url::full(), set to 'current' to use Url::current(), set false to total remove
            'robots' => 'all', // Set to 'all', 'none' or any combination of index/noindex and follow/nofollow
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
            'title' => 'Drainusantara - Spesialis Perpipaan & Drainase Modern', // set false to total remove
            'description' => 'Solusi cepat dan terbersih untuk atasi saluran mampet, pipa bocor, serta perawatan drainase tanpa bongkar bergaransi 30 hari', // set false to total remove
            'url' => false, // Set null for using Url::current(), set false to total remove
            'type' => 'website',
            'site_name' => 'Drainusantara',
            'images' => [],
            'locale' => 'id_ID'
        ],
    ],
    'twitter' => [
        /*
         * The default values to be used by the twitter cards generator.
         */
        'defaults' => [
            //'card'        => 'summary',
            //'site'        => '@LuizVinicius73',
        ],
    ],
    'json-ld' => [
        /*
         * The default configurations to be used by the json-ld generator.
         */
        'defaults' => [
            'title' => 'Drainusantara - Spesialis Perpipaan & Drainase Modern', // set false to total remove
            'description' => 'Jasa perpipaan & perbaikan drainase siaga 24 jam bergaransi.', // set false to total remove
            'url' => 'current', // Set to null or 'full' to use Url::full(), set to 'current' to use Url::current(), set false to total remove
            'type' => 'LocalBusiness',
            'images' => [],
        ],
    ],
];
