<!-- Schema.org Plumber & Local Business JSON-LD (Google Rich Snippet Certified) -->
@php
    $schemaPlumberData = [
        '@context' => 'https://schema.org',
        '@type' => 'Plumber',
        'additionalType' => 'https://schema.org/HomeAndConstructionBusiness',
        'name' => 'DrainNusantara - Jasa Saluran Pipa Mampet Tanpa Bongkar',
        'alternateName' => 'Drainusantara Plumbing & Pipe Engineering',
        'url' => url('/'),
        'telephone' => config('app.whatsapp_number', '+6281234567890'),
        'priceRange' => 'Rp 400.000 - Rp 1.500.000',
        'image' => asset('images/hero-technician.webp'),
        'logo' => asset('images/hero-technician.webp'),
        'description' => 'Layanan spesialis pelancaran saluran pipa mampet, wastafel, kloset, dan floor drain bergaransi 30 hari tanpa membongkar lantai keramik di Jabodetabek, Semarang, & Lampung.',
        'address' => [
            '@type' => 'PostalAddress',
            'streetAddress' => 'Jl. Duren Sawit Raya No. 45',
            'addressLocality' => 'Jakarta Timur',
            'addressRegion' => 'DKI Jakarta',
            'postalCode' => '13440',
            'addressCountry' => 'ID',
        ],
        'geo' => [
            '@type' => 'GeoCoordinates',
            'latitude' => -6.225014,
            'longitude' => 106.900447,
        ],
        'openingHoursSpecification' => [
            [
                '@type' => 'OpeningHoursSpecification',
                'dayOfWeek' => [
                    'Monday',
                    'Tuesday',
                    'Wednesday',
                    'Thursday',
                    'Friday',
                    'Saturday',
                    'Sunday',
                ],
                'opens' => '00:00',
                'closes' => '23:59',
            ],
        ],
        'areaServed' => [
            'DKI Jakarta',
            'Jakarta Timur',
            'Jakarta Selatan',
            'Jakarta Barat',
            'Jakarta Utara',
            'Jakarta Pusat',
            'Bekasi',
            'Depok',
            'Tangerang',
            'Tangerang Selatan',
            'Bogor',
            'Bandung',
            'Semarang',
            'Bandar Lampung',
        ],
        'hasOfferCatalog' => [
            '@type' => 'OfferCatalog',
            'name' => 'Katalog Layanan Rekayasa Pipanisasi DrainNusantara',
            'itemListElement' => [
                [
                    '@type' => 'Offer',
                    'itemOffered' => [
                        '@type' => 'Service',
                        'name' => 'DN-01 Wastafel & Bak Cuci Piring Mampet',
                        'description' => 'Mengikis tuntas kerak lemak & sisa masakan pada wastafel dapur dengan Mesin Rotary Rigid K-50 tanpa merusak sifon PVC.',
                    ],
                    'price' => '400000',
                    'priceCurrency' => 'IDR',
                ],
                [
                    '@type' => 'Offer',
                    'itemOffered' => [
                        '@type' => 'Service',
                        'name' => 'DN-02 Kloset & WC Meluap',
                        'description' => 'Pelancaran kloset duduk/jongkok tersumbat tisu atau benda asing tanpa melepas atau membongkar porselen toilet.',
                    ],
                    'price' => '400000',
                    'priceCurrency' => 'IDR',
                ],
                [
                    '@type' => 'Offer',
                    'itemOffered' => [
                        '@type' => 'Service',
                        'name' => 'DN-03 Floor Drain Kamar Mandi',
                        'description' => 'Penarikan gumpalan rambut dan kerak busa sabun yang menyumbat floor drain kamar mandi hingga bebas bau got.',
                    ],
                    'price' => '400000',
                    'priceCurrency' => 'IDR',
                ],
                [
                    '@type' => 'Offer',
                    'itemOffered' => [
                        '@type' => 'Service',
                        'name' => 'DN-04 Talang Rooftop & Pipa Atap',
                        'description' => 'Pembersihan pipa pembuangan talang atap dari lumut, pasir dak, dan dedaunan kering dengan spiral baja jangkauan 30m.',
                    ],
                    'price' => '400000',
                    'priceCurrency' => 'IDR',
                ],
                [
                    '@type' => 'Offer',
                    'itemOffered' => [
                        '@type' => 'Service',
                        'name' => 'DN-05 Kuras Grease Trap & Lemak Resto',
                        'description' => 'Pembersihan dan pengurasan perangkap lemak jenuh dapur restoran, kafe, dan unit usaha F&B.',
                    ],
                    'price' => '400000',
                    'priceCurrency' => 'IDR',
                ],
                [
                    '@type' => 'Offer',
                    'itemOffered' => [
                        '@type' => 'Service',
                        'name' => 'DN-06 Inspeksi Kamera CCTV Pipa 30M',
                        'description' => 'Investigasi visual sonar kamera endoskopi kedap air IP68 HD 1080P untuk menemukan titik retak pipa atau akar.',
                    ],
                    'price' => '400000',
                    'priceCurrency' => 'IDR',
                ],
            ],
        ],
    ];
@endphp
<script type="application/ld+json">
{!! json_encode($schemaPlumberData, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) !!}
</script>
