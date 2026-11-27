<?php

declare(strict_types=1);

return [
    /*
    |--------------------------------------------------------------------------
    | Global Pruning Switch for Non-Priority District Pages
    |--------------------------------------------------------------------------
    |
    | Default false (Opsi 2): seluruh 239 kecamatan non-kembar tetap aktif
    | 200 OK dan masuk sitemap.xml (kecuali 7 slug kembar di bawah atau
    | kecamatan yang secara manual diset is_priority = false di CMS Admin).
    | Jika suatu saat diset true via env AREA_PRUNE_THIN_DISTRICTS=true,
    | hanya kecamatan di recommended_priority_districts yang tetap 200 OK.
    |
    */
    'prune_non_priority' => (bool) env('AREA_PRUNE_THIN_DISTRICTS', false),

    /*
    |--------------------------------------------------------------------------
    | Forced 301 Redirects for Duplicate City/District Slugs
    |--------------------------------------------------------------------------
    |
    | 7 slug kecamatan yang namanya identik/kembar dengan hub kota/kabupaten.
    | Selalu di-301 ke /area/{city} dan dikecualikan dari sitemap.xml.
    | Catatan: kabupaten-klungkung/klungkung sengaja dipertahankan aktif.
    |
    */
    'forced_city_redirects' => [
        'demak' => ['demak'],
        'bogor' => ['kota-bogor'],
        'kabupaten-gianyar' => ['gianyar'],
        'kabupaten-tabanan' => ['tabanan'],
        'kabupaten-buleleng' => ['buleleng'],
        'kabupaten-bangli' => ['bangli'],
        'kabupaten-karangasem' => ['karangasem'],
    ],

    /*
    |--------------------------------------------------------------------------
    | Recommended Priority Districts (53 Verified GSC / Case-Study Slugs)
    |--------------------------------------------------------------------------
    |
    | Referensi 53 kecamatan dengan bukti tayangan/klik GSC atau studi kasus.
    | Ditampilkan sebagai indikator "Prioritas GSC" di CMS Admin dan dipakai
    | sebagai preset jika AREA_PRUNE_THIN_DISTRICTS=true.
    |
    */
    'recommended_priority_districts' => [
        'jakarta-timur' => [
            'pulo-gadung',
            'ciracas',
            'cipayung',
            'makasar',
            'cakung',
            'pasar-rebo',
            'kramat-jati',
            'jatinegara',
            'duren-sawit',
        ],
        'jakarta-selatan' => [
            'kebayoran-baru',
            'tebet',
            'pasar-minggu',
            'cilandak',
            'mampang-prapatan',
        ],
        'jakarta-utara' => [
            'penjaringan',
            'kelapa-gading',
            'pantai-indah-kapuk',
            'pademangan',
            'sunter',
        ],
        'jakarta-pusat' => [
            'gambir',
            'senen',
            'menteng',
            'kemayoran',
        ],
        'jakarta-barat' => [
            'puri-kembangan',
            'kebon-jeruk',
            'grogol-petamburan',
        ],
        'tangerang-selatan' => [
            'bintaro',
            'bsd-city',
            'serpong',
        ],
        'depok-cinere' => [
            'cinere',
            'sukmajaya',
            'cimanggis',
        ],
        'bekasi-cikarang' => [
            'bekasi-selatan',
            'cikarang-selatan',
            'cikarang-utara',
        ],
        'bogor' => [
            'cibinong',
            'sentul-city',
        ],
        'tangerang-kota' => [
            'cipondoh',
            'pinang',
        ],
        'bandung' => [
            'dago',
            'buahbatu',
        ],
        'kabupaten-bandung' => [
            'rancaekek',
        ],
        'kota-cimahi' => [
            'cimahi-tengah',
        ],
        'semarang' => [
            'semarang-selatan',
            'banyumanik',
            'gayamsari',
            'tembalang',
            'tugu',
            'candisari',
        ],
        'kabupaten-semarang' => [
            'ungaran-barat',
        ],
        'demak' => [
            'sayung',
            'bonang',
            'mranggen',
            'dempet',
            'mijen',
        ],
        'bandar-lampung' => [
            'sukarame',
            'kedaton',
            'tanjung-karang-pusat',
        ],
        'kota-denpasar' => [
            'denpasar-selatan',
        ],
        'kabupaten-badung' => [
            'kuta-selatan',
            'canggu',
            'kuta',
            'seminyak',
        ],
        'kabupaten-gianyar' => [
            'ubud',
        ],
        'kabupaten-jembrana' => [
            'gilimanuk',
        ],
        'kabupaten-klungkung' => [
            'klungkung',
        ],
    ],
];
