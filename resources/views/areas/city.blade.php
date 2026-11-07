@extends('layouts.app')

@section('custom_geo')
    @php
        $resolvedCoords = $area->resolved_coordinates;
        $isoRegion = \App\Services\RegionService::isoRegion($cityData['province_slug'] ?? null);
    @endphp
    <meta name="geo.region" content="{{ $isoRegion }}">
    <meta name="geo.placename" content="{{ $cityData['name'] }}, {{ $cityData['province_name'] }}">
    <meta name="geo.position" content="{{ $resolvedCoords['lat'] }};{{ $resolvedCoords['lng'] }}">
    <meta name="ICBM" content="{{ $resolvedCoords['lat'] }}, {{ $resolvedCoords['lng'] }}">

    <!-- OpenGraph Location Tags -->
    <meta property="og:latitude" content="{{ $resolvedCoords['lat'] }}">
    <meta property="og:longitude" content="{{ $resolvedCoords['lng'] }}">
    <meta property="og:locality" content="{{ $cityData['name'] }}">
    <meta property="og:region" content="{{ $cityData['province_name'] }}">
    <meta property="og:country-name" content="Indonesia">
@endsection

@push('head')
    @php
        $customHeroBg = !empty($area->hero_image) ? asset($area->hero_image) : null;
        $citySlug = $cityData['slug'] ?? \Illuminate\Support\Str::slug($cityData['name']);
        $provinceSlug = $cityData['province_slug'] ?? null;
        $heroBgImage = $customHeroBg 
            ?: (file_exists(public_path("images/areas/cities/{$citySlug}.webp"))
                ? asset("images/areas/cities/{$citySlug}.webp")
                : (file_exists(public_path("images/areas/cities/{$citySlug}.jpg"))
                    ? asset("images/areas/cities/{$citySlug}.jpg")
                    : ($provinceSlug && file_exists(public_path("images/areas/provinces/{$provinceSlug}.webp"))
                        ? asset("images/areas/provinces/{$provinceSlug}.webp")
                        : ($provinceSlug && file_exists(public_path("images/areas/provinces/{$provinceSlug}.jpg"))
                            ? asset("images/areas/provinces/{$provinceSlug}.jpg")
                            : null))));
    @endphp
    @if(!empty($heroBgImage))
    <link rel="preload" as="image" href="{{ $heroBgImage }}" fetchpriority="high">
    @endif
@endpush

@section('content')
@php
    $whatsappNumber = config('app.whatsapp_number') ?: '6285609009009';
    $customWaText = !empty($area->cta_whatsapp_text) 
        ? $area->cta_whatsapp_text 
        : "Halo Tim Drainusantara, saya membutuhkan jasa pelancaran pipa saluran mampet di area {$cityData['name']}. Mohon info estimasi biaya dan kedatangan teknisi ke lokasi.";
    $cityWaUrl = "https://wa.me/{$whatsappNumber}?text=" . urlencode($customWaText);
    
    $heroHeadline = $area->cta_headline ?: "Jasa Saluran Mampet di <span class=\"text-sky-700\">{$cityData['name']}</span>";
    $startingPriceFormatted = 'Rp ' . number_format($area->resolved_price, 0, ',', '.');
    
    // Fallback latar belakang banner kota bila tidak ada kustom dari CMS
    if (!isset($heroBgImage)) {
        $customHeroBg = !empty($area->hero_image) ? asset($area->hero_image) : null;
        $citySlug = $cityData['slug'] ?? \Illuminate\Support\Str::slug($cityData['name']);
        $provinceSlug = $cityData['province_slug'] ?? null;
        $heroBgImage = $customHeroBg 
            ?: (file_exists(public_path("images/areas/cities/{$citySlug}.webp"))
                ? asset("images/areas/cities/{$citySlug}.webp")
                : (file_exists(public_path("images/areas/cities/{$citySlug}.jpg"))
                    ? asset("images/areas/cities/{$citySlug}.jpg")
                    : ($provinceSlug && file_exists(public_path("images/areas/provinces/{$provinceSlug}.webp"))
                        ? asset("images/areas/provinces/{$provinceSlug}.webp")
                        : ($provinceSlug && file_exists(public_path("images/areas/provinces/{$provinceSlug}.jpg"))
                            ? asset("images/areas/provinces/{$provinceSlug}.jpg")
                            : null))));
    }

    $posko = $area->resolved_posko;
    $advantages = $area->resolved_advantages;
    $comparisons = $area->resolved_comparison;
    $serviceCategories = $area->resolved_service_categories;
    $articlesList = $articles ?? collect();

    $defaultProblemCatalogs = [
        [
            'title' => 'Wastafel & Cuci Piring',
            'category' => 'Dapur & Residensial',
            'desc' => "Air bak cuci piring meluap atau lambat surut karena tumpukan minyak beku, sisa masakan, dan ampas makanan yang mengeras di leher angsa sifon PVC wilayah {$cityData['name']}.",
            'specs' => [
                'Mengikis kerak lemak jenuh tanpa merusak sifon',
                'Aman untuk sambungan pipa PVC leher angsa',
                'Pengerjaan 30-45 menit rapi tanpa kotor',
                'Garansi resmi 30 hari nota tertulis',
            ],
            'price' => $area->resolved_price,
            'image' => asset('images/services/drainusantara-jasa-perbaikan-saluran-wastafel-cuci-piring-mampet.webp'),
        ],
        [
            'title' => 'Kloset & WC Meluap',
            'category' => 'Toilet & Kamar Mandi',
            'desc' => "Kloset duduk atau jongkok meluap saat disiram akibat sumbatan tisu, pembalut, kain, atau kerak kotoran pada lekukan porselen kloset di {$cityData['name']}.",
            'specs' => [
                'Metode mekanis tanpa membongkar dudukan kloset keramik',
                'Daya putar meliuk aman di leher angsa keramik',
                'Teknisi ber-APD bersih dan bersarung tangan',
                'Garansi resmi 30 hari nota tertulis',
            ],
            'price' => $area->resolved_price,
            'image' => asset('images/services/drainusantara-jasa-perbaikan-saluran-kloset-wc-toilet-mampet.webp'),
        ],
        [
            'title' => 'Floor Drain Kamar Mandi',
            'category' => 'Kamar Mandi & Lantai',
            'desc' => "Air mandi menggenang di lantai dan memicu bau got tidak sedap akibat jalinan rambut rontok dan residu busa sabun yang menebal di jalur pipa rumah Anda di {$cityData['name']}.",
            'specs' => [
                'Melilit dan menarik gumpalan rambut serta kerak sabun',
                'Menghilangkan bau got dan melancarkan aliran air',
                'Melayani pipa diameter 2 hingga 4 inch',
                'Garansi resmi 30 hari nota tertulis',
            ],
            'price' => $area->resolved_price,
            'image' => asset('images/services/drainusantara-jasa-perbaikan-saluran-floor-drain-kamar-mandi-mampet.webp'),
        ],
        [
            'title' => 'Talang Rooftop & Pipa Atap',
            'category' => 'Rooftop & Eksterior Gedung',
            'desc' => "Pipa pembuangan talang atap meluap oleh endapan lumut tebal, pasir dak semen, dan dedaunan kering yang memicu kebocoran plafon hunian di {$cityData['name']}.",
            'specs' => [
                'Jangkauan kabel panjang menembus pipa vertikal',
                'Membersihkan endapan lumpur, lumut, dan dedaunan',
                'Mencegah rembesan air hujan ke plafon hunian',
                'Garansi resmi 30 hari nota tertulis',
            ],
            'price' => $area->resolved_price,
            'image' => asset('images/services/drainusantara-jasa-perbaikan-saluran-talang-rooftop-pipa-atap-mampet.webp'),
        ],
        [
            'title' => 'Kuras Grease Trap & Lemak',
            'category' => 'Komersial F&B & Restoran',
            'desc' => "Bak perangkap lemak (grease trap) dapur resto, kafe, atau rumah makan di {$cityData['name']} penuh kerak minyak padat berbau menyengat dan mengancam operasional.",
            'specs' => [
                'Pembersihan lemak jenuh dan sisa minyak komersial',
                'Perawatan berkala bebas bau untuk dapur usaha',
                'Tersedia dokumen invoice resmi untuk B2B',
                'Garansi resmi 30 hari nota tertulis',
            ],
            'price' => $area->resolved_price,
            'image' => asset('images/services/drainusantara-jasa-perbaikan-kuras-grease-trap-lemak-restoran.webp'),
        ],
        [
            'title' => 'Inspeksi Kamera CCTV Pipa IP68',
            'category' => 'Diagnostik & Jalur Pipa',
            'desc' => "Pemeriksaan visual jalur internal pipa pembuangan dengan kamera endoskopi anti-air untuk mendeteksi posisi retakan, sambungan lepas, atau sumbatan pipa di bawah lantai cor {$cityData['name']}.",
            'specs' => [
                'Kamera fleksibel jangkauan hingga 30 meter',
                'Monitor digital resolusi tinggi langsung di lokasi',
                'Pembuktian visual sebelum dan sesudah pengerjaan',
                'Garansi resmi 30 hari nota tertulis',
            ],
            'price' => 500000,
            'image' => asset('images/services/drainusantara-jasa-inspeksi-kamera-cctv-saluran-pipa-endoskopi.webp'),
        ],
    ];

    $itemsCityServices = (isset($services) && $services->isNotEmpty()) ? $services : collect($defaultProblemCatalogs);
    $displayGalleries = ($galleries ?? collect())->take(3);
@endphp

@push('styles')
<style>
    .area-city-page .area-hero {
        background: #f8fafc;
        border-bottom-color: #cbd5e1;
    }
    .area-city-page .area-hero h1 { max-width: 15ch; letter-spacing: -0.045em; }
    .area-city-page .area-hero p { max-width: 58ch; }
    .area-city-page .area-hero .hero-proof {
        border-left: 3px solid #0369a1;
        padding-left: 1rem;
    }
    .area-city-page .service-card,
    .area-city-page .city-card {
        border-radius: 0.5rem;
        box-shadow: none;
    }
    .area-city-page .service-card:hover,
    .area-city-page .city-card:hover {
        border-color: #0369a1;
        box-shadow: 0 8px 24px rgb(15 23 42 / 0.08);
    }
    @media (max-width: 639px) {
        .area-city-page .area-hero h1 { max-width: 15ch; }
        .area-city-page .area-hero .hero-proof { padding-left: 0.75rem; }
    }
    .no-scrollbar::-webkit-scrollbar { display: none; }
    .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
</style>
@endpush

<div class="area-city-page">
    <!-- 1. HERO SECTION KOTA -->
    <section class="relative area-hero bg-slate-50 border-b border-slate-200 pt-6 pb-12 sm:pt-10 sm:pb-16 lg:pt-14 lg:pb-20 overflow-hidden">
        @if(!empty($heroBgImage))
            <div class="absolute inset-0 z-0 pointer-events-none overflow-hidden" aria-hidden="true">
                <img src="{{ $heroBgImage }}" 
                     alt="Latar Belakang Wilayah {{ $cityData['name'] }}" 
                     loading="eager"
                     decoding="async"
                     class="w-full h-full object-cover object-center opacity-60 md:opacity-75 scale-105 transition-transform duration-700">
                <div class="absolute inset-0 bg-linear-to-r from-slate-50/40 via-slate-50/80 to-slate-50/45"></div>
                <div class="absolute inset-0 bg-linear-to-b from-transparent via-slate-50/40 to-slate-50"></div>
            </div>
        @endif

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <!-- Breadcrumbs Navigasi -->
            <nav class="flex items-center gap-1.5 text-xs text-slate-500 mb-6 flex-wrap reveal-soft" aria-label="Breadcrumb">
                <a href="{{ route('home') }}" class="hover:text-sky-700 transition-colors">Beranda</a>
                <span class="text-slate-400" aria-hidden="true">/</span>
                <a href="{{ route('area.index') }}" class="hover:text-sky-700 transition-colors">Area Layanan</a>
                <span class="text-slate-400" aria-hidden="true">/</span>
                <a href="{{ route('area.province', ['province' => $cityData['province_slug']]) }}" class="hover:text-sky-700 transition-colors">
                    {{ $cityData['province_name'] }}
                </a>
                <span class="text-slate-400" aria-hidden="true">/</span>
                <span class="text-slate-900 font-bold" aria-current="page">{{ $cityData['name'] }}</span>
            </nav>

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-12 items-center">
                <div class="lg:col-span-8 space-y-5 sm:space-y-6">
                    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-sky-50 border border-sky-200 text-sky-800 text-xs font-bold uppercase tracking-wider reveal-soft">
                        <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                        <span>POSKO ARMADA SIAGA 24 JAM WILAYAH {{ strtoupper($cityData['name']) }}</span>
                    </div>

                    <h1 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold text-slate-900 tracking-tight leading-tight reveal-soft delay-75">
                        {!! $heroHeadline !!}
                    </h1>

                    <p class="text-sm sm:text-base lg:text-lg text-slate-700 leading-relaxed max-w-2xl reveal-soft delay-100">
                        {{ $area->meta_description ?: "Spesialis pelancaran pipa mampet wastafel, kloset toilet, bak kontrol, dan talang air di {$cityData['name']}. Metode mekanis modern tanpa bongkar lantai keramik dengan garansi resmi 30 hari." }}
                    </p>

                    <!-- Quick Area Chips (Diferensiasi Karakter Lokal Kota) -->
                    <div class="flex flex-wrap items-center gap-1.5 pt-1 text-xs text-slate-600 reveal-soft delay-125">
                        <span class="font-bold text-slate-800 text-[11px] sm:text-xs">Titik Siaga {{ $cityData['name'] }}:</span>
                        @foreach(array_slice($cityData['districts'] ?? [], 0, 5) as $dName)
                            <a href="{{ route('area.detail', ['city' => $cityData['slug'], 'district' => Str::slug($dName)]) }}" class="inline-flex items-center px-2 py-0.5 rounded-md bg-white hover:bg-sky-50 hover:text-sky-800 border border-slate-200 transition-colors text-[10px] sm:text-[11px] font-medium text-slate-700 shadow-2xs">
                                {{ $dName }}
                            </a>
                        @endforeach
                        @if(count($cityData['districts'] ?? []) > 5)
                            <a href="#daftar-kecamatan" class="inline-flex items-center px-1.5 py-0.5 text-[10px] sm:text-[11px] font-semibold text-sky-800 hover:text-sky-900 underline">
                                +{{ count($cityData['districts']) - 5 }} area lainnya
                            </a>
                        @endif
                    </div>

                    <!-- 4-Grid Feature Badges (Sama persis seperti Provinsi) -->
                    <div class="grid grid-cols-2 sm:grid-cols-4 gap-2.5 sm:gap-3 max-w-2xl pt-1 reveal-soft delay-150">
                        <div class="bg-white p-3 sm:p-4 rounded-lg border border-slate-200 shadow-2xs flex flex-col sm:flex-row items-center sm:items-center gap-2 sm:gap-3 text-center sm:text-left">
                            <div class="w-8 h-8 sm:w-10 sm:h-10 rounded-md bg-sky-50 border border-sky-200 text-sky-700 flex items-center justify-center shrink-0">
                                <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                            <div class="min-w-0">
                                <div class="text-[10px] sm:text-xs text-slate-500 font-medium leading-tight">Biaya Mulai</div>
                                <div class="text-xs sm:text-sm font-extrabold text-sky-900 truncate">{{ $startingPriceFormatted }}</div>
                            </div>
                        </div>

                        <div class="bg-white p-3 sm:p-4 rounded-lg border border-slate-200 shadow-2xs flex flex-col sm:flex-row items-center sm:items-center gap-2 sm:gap-3 text-center sm:text-left">
                            <div class="w-8 h-8 sm:w-10 sm:h-10 rounded-md bg-emerald-50 border border-emerald-200 text-emerald-700 flex items-center justify-center shrink-0">
                                <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                            <div class="min-w-0">
                                <div class="text-[10px] sm:text-xs text-slate-500 font-medium leading-tight">Respon WA</div>
                                <div class="text-xs sm:text-sm font-extrabold text-emerald-800 truncate">Respon Cepat</div>
                            </div>
                        </div>

                        <div class="bg-white p-3 sm:p-4 rounded-lg border border-slate-200 shadow-2xs flex flex-col sm:flex-row items-center sm:items-center gap-2 sm:gap-3 text-center sm:text-left">
                            <div class="w-8 h-8 sm:w-10 sm:h-10 rounded-md bg-amber-50 border border-amber-200 text-amber-700 flex items-center justify-center shrink-0">
                                <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                                </svg>
                            </div>
                            <div class="min-w-0">
                                <div class="text-[10px] sm:text-xs text-slate-500 font-medium leading-tight">Perlindungan</div>
                                <div class="text-xs sm:text-sm font-extrabold text-slate-900 truncate">Garansi 30 Hari</div>
                            </div>
                        </div>

                        <div class="bg-white p-3 sm:p-4 rounded-lg border border-slate-200 shadow-2xs flex flex-col sm:flex-row items-center sm:items-center gap-2 sm:gap-3 text-center sm:text-left">
                            <div class="w-8 h-8 sm:w-10 sm:h-10 rounded-md bg-sky-50 border border-sky-200 text-sky-700 flex items-center justify-center shrink-0">
                                <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                                </svg>
                            </div>
                            <div class="min-w-0">
                                <div class="text-[10px] sm:text-xs text-slate-500 font-medium leading-tight">Metode Kerja</div>
                                <div class="text-xs sm:text-sm font-extrabold text-slate-900 truncate">Tanpa Bongkar</div>
                            </div>
                        </div>
                    </div>

                    <!-- Direct Action Buttons: WhatsApp + Telepon Hotline + Daftar Wilayah -->
                    <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3 pt-2 hero-proof reveal-soft delay-200">
                        <a href="{{ $cityWaUrl }}" target="_blank" rel="noopener noreferrer" 
                           class="min-h-12 inline-flex items-center justify-center gap-2.5 bg-emerald-700 hover:bg-emerald-800 text-white font-bold text-sm sm:text-base px-6 py-3 rounded-lg shadow-xs hover:shadow transition-all focus-visible:outline-hidden focus-visible:ring-2 focus-visible:ring-emerald-500 btn-press">
                            <svg class="w-4 h-4 fill-current shrink-0" viewBox="0 0 24 24" aria-hidden="true">
                                <path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/>
                            </svg>
                            <span>{{ $area->cta_button_text ?: "WhatsApp Teknisi {$cityData['name']}" }}</span>
                        </a>

                        <a href="tel:085609009009" 
                           class="min-h-12 inline-flex items-center justify-center gap-2 bg-slate-900 hover:bg-slate-800 text-white font-bold text-xs sm:text-sm px-5 py-3 rounded-lg border border-slate-700 shadow-2xs transition-colors focus-visible:outline-hidden focus-visible:ring-2 focus-visible:ring-sky-600 btn-press">
                            <svg class="w-4 h-4 text-emerald-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                            </svg>
                            <span>Telepon: 0856-0900-9009</span>
                        </a>

                        <a href="#daftar-kecamatan" 
                           class="min-h-12 inline-flex items-center justify-center gap-2 bg-white hover:bg-slate-100 text-slate-800 font-bold text-xs sm:text-sm px-5 py-3 rounded-lg border border-slate-300 shadow-2xs transition-colors focus-visible:outline-hidden focus-visible:ring-2 focus-visible:ring-sky-600 btn-press">
                            <span>Pilih Kecamatan ({{ count($cityData['districts'] ?? []) }})</span>
                            <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </a>
                    </div>
                </div>

                <!-- Kolom Ringkasan Posko Siaga Lokal (Sama persis seperti Provinsi) -->
                <div class="hidden lg:block lg:col-span-4 reveal-soft delay-150">
                    <div class="bg-white rounded-xl p-3 sm:p-4 border border-slate-200 shadow-xs space-y-3 card-lift">
                        <div class="relative rounded-lg overflow-hidden aspect-4/3 bg-slate-900 border border-slate-200">
                            <img 
                                src="{{ !empty($area->hero_image) ? asset($area->hero_image) : asset('images/drainusantara-jasa-saluran-pipa-mampet-teknisi-profesional.webp') }}" 
                                alt="Teknisi Drainusantara Penanganan Saluran Mampet di {{ $cityData['name'] }}" 
                                width="600" 
                                height="450" 
                                loading="eager"
                                fetchpriority="high"
                                decoding="async"
                                class="w-full h-full object-cover"
                            >
                            <div class="absolute bottom-2 left-2 bg-slate-950/85 backdrop-blur-xs text-white text-[11px] font-bold px-2.5 py-1 rounded">
                                Posko Armada {{ $cityData['name'] }}
                            </div>
                        </div>

                        <div class="space-y-2 text-xs">
                            <div class="flex items-center gap-2 text-slate-600">
                                <svg class="w-4 h-4 text-sky-700 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                <span>Mencakup {{ count($cityData['districts'] ?? []) }} Kecamatan di {{ $cityData['name'] }}</span>
                            </div>
                            <div class="flex items-center gap-2 text-slate-600">
                                <svg class="w-4 h-4 text-emerald-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                <span>Unit Reaksi Cepat Siaga di Posko Terdekat</span>
                            </div>
                            <div class="flex items-center gap-2 text-slate-600">
                                <svg class="w-4 h-4 text-sky-700 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                                <span>Garansi 30 Hari Pekerjaan Ulang Bebas Biaya</span>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- 2. SECTION DRAINUSANTARA HADIR DI KOTA (TANPA CTA DAN HOTLINE) -->
    @php
        $presenceImg = !empty($area->presence_image) 
            ? (filter_var($area->presence_image, FILTER_VALIDATE_URL) ? $area->presence_image : asset($area->presence_image))
            : asset('images/drainusantara-jasa-saluran-pipa-mampet-teknisi-profesional.webp');
        $presenceText = !empty($area->presence_description)
            ? $area->presence_description
            : "Drainusantara hadir secara resmi melayani seluruh wilayah {$cityData['name']} sebagai solusi modern penanganan saluran pipa mampet tanpa pembongkaran lantai keramik maupun dinding. Didukung armada teknisi motoris dan mobil reaksi cepat yang ditempatkan pada titik-titik posko strategis, kami menjamin penanganan tuntas dengan standar alat mekanis spiral baja elastis bergaransi resmi 30 hari.";
    @endphp
    <section id="kehadiran-lokal-kota" class="py-14 sm:py-20 bg-white border-b border-slate-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-12 items-center">
                <!-- Kolom Gambar Kehadiran Lokal (CMS Uploadable) -->
                <div class="lg:col-span-5">
                    <div class="relative bg-slate-900 rounded-2xl overflow-hidden border border-slate-200 shadow-sm group">
                        <img 
                            src="{{ $presenceImg }}" 
                            alt="Posko Siaga Armada Drainusantara di {{ $cityData['name'] }}" 
                            width="640" 
                            height="480" 
                            loading="lazy" 
                            decoding="async" 
                            class="w-full h-80 sm:h-96 object-cover transition-transform duration-500 group-hover:scale-105"
                            onerror="this.onerror=null; this.src='{{ asset('images/drainusantara-jasa-saluran-pipa-mampet-teknisi-profesional.webp') }}';"
                        >
                        <div class="absolute inset-0 bg-linear-to-t from-slate-950/80 via-transparent to-transparent"></div>
                        <div class="absolute bottom-4 left-4 right-4 text-white">
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md bg-emerald-700/90 text-white text-[10px] font-bold uppercase tracking-wider mb-2">
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-pulse"></span>
                                Posko Siaga Aktif
                            </span>
                            <h4 class="text-base font-extrabold text-white">Armada Teknisi Wilayah {{ $cityData['name'] }}</h4>
                            <p class="text-xs text-slate-300 mt-0.5">Siap menjangkau {{ count($cityData['districts'] ?? []) }} kecamatan dengan unit rooter bergaransi resmi.</p>
                        </div>
                    </div>
                </div>

                <!-- Kolom Penjelasan & Poin Operasional (Tanpa CTA & Hotline) -->
                <div class="lg:col-span-7 space-y-5">
                    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-sky-50 border border-sky-200 text-sky-800 text-xs font-bold uppercase tracking-wider">
                        <svg class="w-3.5 h-3.5 text-sky-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                        <span>Cakupan Terintegrasi Wilayah {{ $cityData['name'] }}</span>
                    </div>

                    <h2 class="text-2xl sm:text-3xl lg:text-4xl font-extrabold text-slate-900 tracking-tight leading-tight">
                        Drainusantara Hadir di <span class="text-sky-700">{{ $cityData['name'] }}</span>
                    </h2>

                    <div class="text-sm sm:text-base text-slate-600 leading-relaxed space-y-3">
                        <p>{{ $presenceText }}</p>
                    </div>

                    <!-- 3 Poin Kunci Kehadiran Lokal (Carousel di Mobile) -->
                    <div class="flex md:hidden items-center justify-start gap-1 text-[11px] text-sky-700 font-medium pt-1" aria-hidden="true">
                        <svg class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                        <span>Geser poin keunggulan</span>
                    </div>

                    <div class="flex sm:grid sm:grid-cols-3 overflow-x-auto sm:overflow-visible snap-x snap-mandatory no-scrollbar gap-3 pt-1 pb-2 px-1 -mx-1 sm:mx-0 sm:px-0">
                        <div class="w-[78vw] max-w-[280px] sm:w-auto shrink-0 snap-center p-3.5 rounded-xl bg-slate-50 border border-slate-200 flex flex-col justify-between shadow-2xs">
                            <div>
                                <div class="w-7 h-7 rounded-lg bg-sky-100 text-sky-800 font-extrabold text-xs flex items-center justify-center mb-2">
                                    01
                                </div>
                                <h4 class="text-xs font-bold text-slate-900 mb-1">Cakupan Luas</h4>
                                <p class="text-[11px] text-slate-600 leading-relaxed">Melayani seluruh {{ count($cityData['districts'] ?? []) }} kecamatan di {{ $cityData['name'] }} tanpa diskriminasi jarak.</p>
                            </div>
                        </div>

                        <div class="w-[78vw] max-w-[280px] sm:w-auto shrink-0 snap-center p-3.5 rounded-xl bg-slate-50 border border-slate-200 flex flex-col justify-between shadow-2xs">
                            <div>
                                <div class="w-7 h-7 rounded-lg bg-emerald-100 text-emerald-800 font-extrabold text-xs flex items-center justify-center mb-2">
                                    02
                                </div>
                                <h4 class="text-xs font-bold text-slate-900 mb-1">Bebas Bongkar</h4>
                                <p class="text-[11px] text-slate-600 leading-relaxed">Pembersihan mekanis 100% bebas kimia korosif sehingga fitting pipa PVC tetap awet.</p>
                            </div>
                        </div>

                        <div class="w-[78vw] max-w-[280px] sm:w-auto shrink-0 snap-center p-3.5 rounded-xl bg-slate-50 border border-slate-200 flex flex-col justify-between shadow-2xs">
                            <div>
                                <div class="w-7 h-7 rounded-lg bg-amber-100 text-amber-800 font-extrabold text-xs flex items-center justify-center mb-2">
                                    03
                                </div>
                                <h4 class="text-xs font-bold text-slate-900 mb-1">Garansi 30 Hari</h4>
                                <p class="text-[11px] text-slate-600 leading-relaxed">Nota fisik resmi dan kepastian penanganan ulang gratis bila mampet berulang.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- 3. SECTION LAYANAN 1 BARIS CAROUSEL -->
    <section id="layanan-kota" class="py-14 lg:py-20 bg-slate-50 border-b border-slate-200 scroll-mt-16"
             x-data="{
                 active: 0,
                 total: {{ $itemsCityServices->count() }},
                 scrollLeft() {
                     const container = this.$refs.cityServiceCarousel;
                     if (container) {
                         container.scrollBy({ left: -340, behavior: 'smooth' });
                     }
                 },
                 scrollRight() {
                     const container = this.$refs.cityServiceCarousel;
                     if (container) {
                         container.scrollBy({ left: 340, behavior: 'smooth' });
                     }
                 },
                 onScroll() {
                     const container = this.$refs.cityServiceCarousel;
                     if (!container) return;
                     const scrollLeft = container.scrollLeft;
                     const first = container.firstElementChild;
                     const cardWidth = first ? first.offsetWidth + 20 : 340;
                     if (cardWidth > 0) {
                         this.active = Math.min(this.total - 1, Math.max(0, Math.round(scrollLeft / cardWidth)));
                     }
                 }
             }">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col sm:flex-row sm:items-end justify-between mb-8 gap-4">
                <div>
                    <p class="text-xs font-bold uppercase tracking-wider text-sky-800 mb-1">
                        KATALOG SPESIALIS MASALAH PIPA
                    </p>
                    <h2 class="text-2xl sm:text-3xl lg:text-4xl font-extrabold text-slate-900 tracking-tight">
                        Layanan Pelancaran Saluran Pipa di {{ $cityData['name'] }}
                    </h2>
                    <p class="text-slate-600 text-xs sm:text-sm mt-1 max-w-3xl leading-relaxed">
                        Pembersihan kerak minyak masakan, endapan busa sabun, dan sumbatan kotoran menggunakan mesin spiral rotary baja elastis. Dikerjakan langsung dari lubang pipa eksisting tanpa merusak keramik lantai maupun dinding.
                    </p>
                </div>
                <div class="flex items-center gap-3 self-end sm:self-auto">
                    <span class="text-xs text-slate-500 font-mono hidden sm:inline-block">
                        Layanan <span class="font-bold text-slate-900" x-text="active + 1">1</span> dari {{ $itemsCityServices->count() }}
                    </span>
                    <button type="button" @click="scrollLeft()" 
                            aria-label="Geser layanan ke kiri"
                            class="w-9 h-9 rounded-lg border border-slate-300 bg-white hover:bg-slate-50 text-slate-700 flex items-center justify-center transition-colors shadow-2xs cursor-pointer">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                    </button>
                    <button type="button" @click="scrollRight()" 
                            aria-label="Geser layanan ke kanan"
                            class="w-9 h-9 rounded-lg border border-slate-300 bg-white hover:bg-slate-50 text-slate-700 flex items-center justify-center transition-colors shadow-2xs cursor-pointer">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                    </button>
                </div>
            </div>

            <!-- 1-Row Carousel Container (Desktop & Mobile) -->
            <div x-ref="cityServiceCarousel"
                 @scroll.debounce.50ms="onScroll()"
                 tabindex="0" role="region" aria-label="Katalog layanan kota 1 baris"
                 class="flex overflow-x-auto snap-x snap-mandatory no-scrollbar pb-4 pt-1 px-4 gap-4 sm:gap-5 -mx-4 sm:mx-0 sm:px-0">
                @foreach($itemsCityServices as $catalog)
                    <div class="w-[84vw] sm:w-[275px] lg:w-[285px] shrink-0 snap-start flex flex-col">
                        <x-area.service-card 
                            :catalog="$catalog"
                            :location-name="$cityData['name']"
                            :whatsapp-number="$whatsappNumber"
                            :area-price="$area->resolved_price"
                            button-text="Pesan via WhatsApp"
                        />
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- 4. SECTION PERALATAN 1 BARIS CAROUSEL -->
    <x-area.equipment-section 
        section-id="peralatan-kota"
        :area-name="$cityData['name']"
        bg-color="bg-white"
        eyebrow="PERALATAN STANDAR ARMADA"
        :title="'Peralatan Canggih Siaga di ' . $cityData['name']"
        :description="'Armada teknisi kami di ' . $cityData['name'] . ' selalu dibekali unit mesin drain rooter mekanis dan kamera endoskopi IP68 berstandar industri. Menuntaskan sumbatan secara aman tanpa merusak pipa PVC dan tanpa bongkar keramik lantai.'"
    />

    <!-- 5. SECTION STANDAR OPERASIONAL WILAYAH (5 PILAR) -->
    <section id="keunggulan-kota" data-section="standar-operasional-kota" class="py-14 lg:py-20 bg-slate-50 border-b border-slate-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto mb-10">
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-sky-50 border border-sky-200 text-sky-800 text-xs font-bold uppercase tracking-wider mb-2.5">
                    <svg class="w-4 h-4 text-sky-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                    </svg>
                    <span>SOP TEKNISI RESMI</span>
                </div>
                <h2 class="text-2xl sm:text-3xl lg:text-4xl font-extrabold text-slate-900 tracking-tight">
                    Standar Operasional Wilayah {{ $cityData['name'] }}
                </h2>
                <p class="text-xs sm:text-sm md:text-base text-slate-600 mt-2 leading-relaxed">
                    Setiap penugasan armada teknisi Drainusantara diatur oleh 5 pilar standar teknis non-destruktif, transparansi biaya, dan kepastian garansi tertulis.
                </p>
            </div>

            <div class="flex md:hidden items-center justify-start gap-1.5 text-xs text-sky-700 font-medium mb-3 px-1" aria-hidden="true">
                <svg class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                <span>Geser untuk melihat standar SOP lain</span>
            </div>

            <div class="flex md:grid md:grid-cols-2 lg:grid-cols-3 overflow-x-auto md:overflow-visible snap-x snap-mandatory no-scrollbar gap-4 md:gap-5 pb-3 pt-1 px-4 -mx-4 md:mx-0 md:px-0">
                @foreach($advantages as $idx => $adv)
                    <div class="w-[84vw] max-w-[340px] md:w-auto shrink-0 snap-center bg-white rounded-xl border border-slate-200 border-t-2 border-t-sky-700 p-5 sm:p-6 shadow-2xs hover:border-sky-500 transition-all card-lift flex flex-col justify-between">
                        <div>
                            <div class="flex items-center justify-between mb-4">
                                <span class="px-2.5 py-1 rounded-md bg-sky-50 border border-sky-200 text-sky-800 font-extrabold text-[11px] flex items-center gap-1.5 font-mono">
                                    <svg class="w-3.5 h-3.5 text-sky-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                    {{ $adv['code'] ?? ('SOP-0' . ($idx + 1)) }}
                                </span>
                                <span class="text-[10px] font-bold uppercase tracking-wider text-emerald-800 bg-emerald-50 px-2 py-0.5 rounded border border-emerald-200">
                                    {{ $adv['badge'] ?? 'Standar Terverifikasi' }}
                                </span>
                            </div>
                            <h3 class="text-base font-extrabold text-slate-900 tracking-tight mb-2">
                                {{ $adv['title'] }}
                            </h3>
                            <p class="text-xs sm:text-sm text-slate-600 leading-relaxed mb-3">
                                {{ $adv['description'] }}
                            </p>

                            @if(!empty($adv['checkpoints']))
                            <div class="mt-4 pt-3 border-t border-slate-100 space-y-1.5 text-xs text-slate-700">
                                @foreach($adv['checkpoints'] as $cp)
                                <div class="flex items-start gap-2">
                                    <svg class="w-3.5 h-3.5 text-emerald-600 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" />
                                    </svg>
                                    <span class="text-slate-600 font-medium text-[11px] sm:text-xs leading-snug">{{ $cp }}</span>
                                </div>
                                @endforeach
                            </div>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- 6. SECTION SOLUSI PIPA UNTUK BERAGAM KATEGORI BANGUNAN -->
    <section id="sektor-layanan-kota" class="py-12 sm:py-16 bg-white border-b border-slate-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto mb-10">
                <p class="text-xs font-bold uppercase tracking-wider text-sky-800 mb-1">
                    SEKTOR PENANGANAN DI {{ strtoupper($cityData['name']) }}
                </p>
                <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">
                    Solusi Pipa untuk Beragam Kategori Bangunan
                </h2>
                <p class="text-xs sm:text-sm text-slate-600 mt-1">
                    Dari perumahan residensial, kafe &amp; restoran komersial, hingga gedung bertingkat dan kawasan industri.
                </p>
            </div>

            <div class="flex md:hidden items-center justify-start gap-1.5 text-xs text-sky-700 font-medium mb-3 px-1" aria-hidden="true">
                <svg class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                <span>Geser untuk melihat sektor lain</span>
            </div>

            <div class="flex md:grid md:grid-cols-2 lg:grid-cols-3 overflow-x-auto md:overflow-visible snap-x snap-mandatory no-scrollbar gap-4 md:gap-5 pb-3 pt-1 px-4 -mx-4 md:mx-0 md:px-0">
                @foreach($serviceCategories as $sector)
                    @php
                        $secKey = strtolower($sector['key'] ?? $sector['title'] ?? '');
                        $badgeStyle = match(true) {
                            str_contains($secKey, 'resto') || str_contains($secKey, 'fnb') || str_contains($secKey, 'kafe') => [
                                'bg' => 'bg-amber-50',
                                'border' => 'border-amber-200',
                                'text' => 'text-amber-800',
                                'badge' => 'bg-amber-100 text-amber-900 border-amber-200',
                            ],
                            str_contains($secKey, 'gedung') || str_contains($secKey, 'kantor') || str_contains($secKey, 'office') => [
                                'bg' => 'bg-slate-100',
                                'border' => 'border-slate-300',
                                'text' => 'text-slate-800',
                                'badge' => 'bg-slate-200 text-slate-900 border-slate-300',
                            ],
                            str_contains($secKey, 'pabrik') || str_contains($secKey, 'industri') || str_contains($secKey, 'gudang') => [
                                'bg' => 'bg-emerald-50',
                                'border' => 'border-emerald-200',
                                'text' => 'text-emerald-800',
                                'badge' => 'bg-emerald-100 text-emerald-900 border-emerald-200',
                            ],
                            str_contains($secKey, 'ruko') || str_contains($secKey, 'komersial') || str_contains($secKey, 'toko') => [
                                'bg' => 'bg-indigo-50',
                                'border' => 'border-indigo-200',
                                'text' => 'text-indigo-800',
                                'badge' => 'bg-indigo-100 text-indigo-900 border-indigo-200',
                            ],
                            default => [
                                'bg' => 'bg-sky-50',
                                'border' => 'border-sky-200',
                                'text' => 'text-sky-800',
                                'badge' => 'bg-sky-100 text-sky-900 border-sky-200',
                            ],
                        };
                    @endphp
                    <div class="w-[82vw] max-w-[340px] md:w-auto shrink-0 snap-center bg-slate-50 rounded-lg border border-slate-200 p-5 space-y-3 shadow-2xs hover:border-sky-300 transition-colors flex flex-col justify-between group">
                        <div>
                            <div class="flex items-center justify-between gap-3 mb-3 pb-3 border-b border-slate-200/70">
                                <div class="flex items-center gap-2.5">
                                    <div class="w-9 h-9 rounded-md {{ $badgeStyle['bg'] }} {{ $badgeStyle['border'] }} {{ $badgeStyle['text'] }} border flex items-center justify-center shrink-0 shadow-2xs">
                                        <x-area.building-category-icon :category="$secKey" class="w-5 h-5 {{ $badgeStyle['text'] }}" />
                                    </div>
                                    <span class="px-2.5 py-0.5 rounded text-[11px] font-bold {{ $badgeStyle['badge'] }} border">
                                        {{ $sector['title'] }}
                                    </span>
                                </div>
                                <span class="text-[11px] text-slate-400 font-semibold uppercase shrink-0">{{ $cityData['name'] }}</span>
                            </div>
                            <h3 class="text-base font-bold text-slate-900 tracking-tight leading-snug">
                                {{ $sector['scope'] }}
                            </h3>
                            <div class="mt-3 space-y-2 text-xs">
                                <div class="bg-white p-2.5 rounded-md border border-slate-200">
                                    <div class="text-[11px] font-bold text-rose-700">Kendala Umum:</div>
                                    <p class="text-slate-600 mt-0.5 leading-relaxed">{{ $sector['problem'] }}</p>
                                </div>
                                <div class="bg-white p-2.5 rounded-md border border-slate-200">
                                    <div class="text-[11px] font-bold text-emerald-700">Penanganan Teknisi:</div>
                                    <p class="text-slate-600 mt-0.5 leading-relaxed">{{ $sector['solution'] }}</p>
                                </div>
                            </div>
                        </div>

                        <div class="pt-3 border-t border-slate-200/60 mt-3">
                            <a href="{{ $cityWaUrl }}" target="_blank" rel="noopener noreferrer"
                               class="text-xs font-bold text-sky-800 hover:text-sky-950 flex items-center gap-1.5 transition-colors">
                                <span>Konsultasi Sektor {{ $sector['title'] }}</span>
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- 7. SECTION GALERI DOKUMENTASI PENGERJAAN -->
    <section id="galeri-kota" data-section="dokumentasi" class="py-14 lg:py-20 bg-slate-50 border-b border-slate-200" x-data="{ activeCategory: 'all' }">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row items-start md:items-end justify-between gap-4 mb-8 md:mb-12">
                <div>
                    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-sky-50 border border-sky-200 text-sky-800 text-xs font-bold uppercase tracking-wider mb-2">
                        <span>BUKTI RIIL LAPANGAN</span>
                    </div>
                    <h2 class="text-2xl sm:text-3xl lg:text-4xl font-extrabold text-slate-900 tracking-tight">
                        Hasil Pengerjaan Teknisi di Lapangan
                    </h2>
                    <p class="text-slate-600 text-xs sm:text-sm mt-1 max-w-2xl leading-relaxed">
                        Dokumentasi riil penanganan saluran pipa tersumbat pada sektor hunian residensial dan tempat usaha komersial di {{ $cityData['name'] }} menggunakan mesin rooter spiral elektrik serta inspeksi kamera endoskopi.
                    </p>
                </div>

                <div class="flex items-center gap-2 self-stretch sm:self-auto justify-end">
                    <a href="{{ url('/galeri') }}" 
                       class="inline-flex items-center gap-2 text-xs sm:text-sm font-bold text-sky-700 hover:text-sky-800 bg-white border border-slate-300 hover:bg-slate-50 px-4 py-2.5 rounded-lg transition-colors shadow-2xs btn-press">
                        <span>Lihat Semua Dokumentasi</span>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                        </svg>
                    </a>
                </div>
            </div>

            <div class="flex md:hidden items-center justify-start gap-1.5 text-xs text-sky-700 font-medium mb-3 px-1" aria-hidden="true">
                <svg class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                <span>Geser dokumentasi</span>
            </div>

            @if($displayGalleries->isNotEmpty())
                <div class="flex md:grid md:grid-cols-3 overflow-x-auto md:overflow-visible snap-x snap-mandatory no-scrollbar gap-4 md:gap-6 pb-3 pt-1 px-4 -mx-4 md:mx-0 md:px-0">
                    @foreach($displayGalleries as $galleryItem)
                        @php
                            $galleryPhoto = !empty($galleryItem->image) ? asset($galleryItem->image) : asset('assets/placeholders/service.svg');
                            $hasComparison = !empty($galleryItem->before_image) && !empty($galleryItem->after_image);
                        @endphp
                        <div class="w-[82vw] max-w-[340px] md:w-auto shrink-0 snap-center rounded-lg border border-slate-200 overflow-hidden bg-white shadow-2xs hover:border-sky-300 transition-colors flex flex-col justify-between">
                            <div>
                                <div class="relative aspect-16/10 bg-slate-900 overflow-hidden">
                                    <img src="{{ $galleryPhoto }}" alt="{{ $galleryItem->title }}" class="w-full h-full object-cover">
                                    @if($hasComparison)
                                        <span class="absolute top-2 left-2 bg-emerald-700 text-white text-[10px] font-bold px-2 py-0.5 rounded shadow-2xs">
                                            Foto Before - After
                                        </span>
                                    @endif
                                </div>
                                <div class="p-4 space-y-2">
                                    <span class="text-[11px] font-bold text-sky-700 uppercase tracking-wider block">
                                        {{ $galleryItem->location ?: $cityData['name'] }}
                                    </span>
                                    <h3 class="text-sm font-bold text-slate-900 tracking-tight line-clamp-1">
                                        {{ $galleryItem->title }}
                                    </h3>
                                    <p class="text-xs text-slate-600 line-clamp-2 leading-relaxed">
                                        {{ $galleryItem->description ?: 'Pelancaran saluran mampet tuntas dengan metode spiral rotary mekanis.' }}
                                    </p>
                                </div>
                            </div>
                            <div class="p-4 pt-0">
                                <a href="{{ route('case-study.show', $galleryItem->slug) }}" class="text-xs font-semibold text-sky-700 hover:underline flex items-center gap-1">
                                    <span>Lihat Detail Kasus</span>
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </section>

    <!-- 8. SECTION KOMPARASI: TUKANG VS DRAINUSANTARA -->
    <section id="perbandingan-kota" class="py-12 sm:py-18 bg-white border-b border-slate-200">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-2xl mx-auto mb-10">
                <p class="text-xs font-bold uppercase tracking-wider text-sky-800 mb-1">
                    KOMPARASI TRANSPARAN METODE KERJA
                </p>
                <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">
                    Tukang Konvensional vs Standar Drainusantara
                </h2>
                <p class="text-xs sm:text-sm text-slate-600 mt-1">
                    Hindari risiko pembongkaran lantai dan bahaya pipa PVC rapuh akibat cairan kimia keras.
                </p>
            </div>

            <div class="rounded-lg border border-slate-200 overflow-hidden shadow-2xs">
                <div class="grid grid-cols-1 md:grid-cols-12 bg-slate-900 text-white text-xs font-bold uppercase tracking-wider p-3.5 border-b border-slate-800">
                    <div class="md:col-span-3">Aspek Penanganan</div>
                    <div class="md:col-span-4 text-rose-300">Tukang Konvensional</div>
                    <div class="md:col-span-5 text-emerald-300">Standar Drainusantara</div>
                </div>

                <div class="divide-y divide-slate-200 bg-white">
                    @foreach($comparisons as $comp)
                        <div class="grid grid-cols-1 md:grid-cols-12 p-4 text-xs gap-3 items-start hover:bg-slate-50 transition-colors">
                            <div class="md:col-span-3 font-bold text-slate-900 flex items-center gap-1.5">
                                <span class="font-mono text-slate-400 font-bold">&bull;</span>
                                <span>{{ $comp['aspect'] }}</span>
                            </div>
                            <div class="md:col-span-4 text-slate-600 leading-relaxed bg-rose-50/50 p-2.5 rounded-md border border-rose-100">
                                <span class="font-bold text-rose-800 block mb-0.5">Metode Konvensional:</span>
                                {{ $comp['tukang'] }}
                            </div>
                            <div class="md:col-span-5 text-slate-700 leading-relaxed bg-emerald-50/50 p-2.5 rounded-md border border-emerald-100">
                                <span class="font-bold text-emerald-800 block mb-0.5">SOP Drainusantara:</span>
                                {{ $comp['drainusantara'] }}
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Trust Emblem / Jaminan Kepercayaan -->
            <div class="mt-6 flex flex-wrap items-center justify-between gap-4 p-4 rounded-xl bg-slate-50 border border-slate-200 shadow-2xs">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-lg bg-emerald-100 text-emerald-800 flex items-center justify-center shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                    </div>
                    <div>
                        <div class="text-xs sm:text-sm font-extrabold text-slate-900">Garansi Pengerjaan Resmi 30 Hari</div>
                        <div class="text-[11px] text-slate-600">Dilindungi nota bukti fisik. Saluran kembali mampet dalam 30 hari? Teknisi datang ulang bebas biaya.</div>
                    </div>
                </div>
                <div class="flex items-center gap-2">
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[11px] font-bold bg-white text-emerald-800 border border-emerald-300 shadow-2xs">
                        <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                        100% Non-Destruktif
                    </span>
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[11px] font-bold bg-white text-sky-800 border border-sky-300 shadow-2xs">
                        No Cure No Pay
                    </span>
                </div>
            </div>
        </div>
    </section>

    <!-- 9. SECTION ARTIKEL & PANDUAN AIR BERSIH -->
    <section id="artikel-kota" class="py-12 sm:py-16 bg-slate-50 border-b border-slate-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <p class="text-xs font-bold uppercase tracking-wider text-sky-800">EDUKASI PERPIPAAN</p>
                    <h2 class="text-xl sm:text-2xl font-extrabold text-slate-900 tracking-tight">
                        Artikel &amp; Panduan Saluran Air Bersih
                    </h2>
                </div>
                <a href="{{ route('articles.index') }}" class="text-xs font-bold text-sky-700 hover:text-sky-900 flex items-center gap-1">
                    <span>Lihat Semua Blog</span>
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                </a>
            </div>

            <div class="flex md:hidden items-center justify-start gap-1.5 text-xs text-sky-700 font-medium mb-3 px-1" aria-hidden="true">
                <svg class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                <span>Geser artikel</span>
            </div>

            <div class="flex md:grid md:grid-cols-3 overflow-x-auto md:overflow-visible snap-x snap-mandatory no-scrollbar gap-4 md:gap-5 pb-3 pt-1 px-4 -mx-4 md:mx-0 md:px-0">
                @forelse($articlesList as $post)
                    @php
                        $rawThumb = $post->thumbnail;
                        $coverImg = !empty($rawThumb) 
                            ? (filter_var($rawThumb, FILTER_VALIDATE_URL) ? $rawThumb : asset(ltrim($rawThumb, '/'))) 
                            : asset('images/drainusantara-jasa-saluran-pipa-mampet-teknisi-profesional.webp');
                        $catBadge = $post->category_label ?? $post->category ?? 'Edukasi';
                    @endphp
                    <div class="w-[82vw] max-w-[340px] md:w-auto shrink-0 snap-center rounded-lg border border-slate-200 overflow-hidden bg-white shadow-2xs hover:border-sky-300 transition-colors flex flex-col justify-between group">
                        <div>
                            <div class="relative aspect-16/10 bg-slate-100 overflow-hidden">
                                <img src="{{ $coverImg }}" alt="{{ $post->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300" loading="lazy">
                                <div class="absolute top-2.5 left-2.5">
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-md text-[10px] font-bold bg-slate-900/80 text-white backdrop-blur-xs border border-white/20">
                                        {{ $catBadge }}
                                    </span>
                                </div>
                            </div>
                            <div class="p-4 space-y-2">
                                <div class="flex items-center gap-2 text-[11px] text-slate-500 font-medium">
                                    <span>{{ $post->published_at ? $post->published_at->format('d M Y') : 'Terbaru' }}</span>
                                    <span>•</span>
                                    <span>{{ $post->reading_time ?? 3 }} mnt baca</span>
                                    <span>•</span>
                                    <span>{{ number_format($post->views_count ?? 0, 0, ',', '.') }} views</span>
                                </div>
                                <h3 class="text-sm font-bold text-slate-900 tracking-tight line-clamp-2">
                                    <a href="{{ route('articles.show', $post->slug) }}" class="hover:text-sky-700 transition-colors">
                                        {{ $post->title }}
                                    </a>
                                </h3>
                                <p class="text-xs text-slate-600 line-clamp-2 leading-relaxed">
                                    {{ $post->excerpt ?: Str::limit(strip_tags($post->content), 90) }}
                                </p>
                            </div>
                        </div>
                        <div class="p-4 pt-0">
                            <a href="{{ route('articles.show', $post->slug) }}" class="text-xs font-semibold text-sky-700 hover:underline flex items-center gap-1">
                                <span>Baca Selengkapnya</span>
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="col-span-3 text-center py-8 px-4 bg-slate-50 rounded-lg border border-slate-200 w-full">
                        <p class="text-xs text-slate-500">Artikel edukasi dan panduan saluran pipa akan segera diperbarui.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    <!-- 10. SECTION CAKUPAN DAERAH OPERASIONAL DRAINUSANTARA -->
    <x-area.regional-coverage :current-city="$cityData['name']" />

    <!-- 11. SECTION POSKO & DAFTAR AREA LAYANAN KECAMATAN -->
    <section id="posko-kota" class="py-14 lg:py-20 bg-white border-b border-slate-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="max-w-5xl mx-auto mb-10">
                <div class="bg-slate-50 rounded-xl border border-slate-200 p-6 sm:p-8 shadow-2xs">
                    <div class="grid grid-cols-1 md:grid-cols-12 gap-6 items-center">
                        <div class="md:col-span-8 space-y-3">
                            <div class="flex items-center gap-2">
                                <span class="text-xs font-bold uppercase tracking-wider text-sky-800">POSKO UTAMA ARMADA</span>
                            </div>
                            <h3 class="text-xl sm:text-2xl font-extrabold text-slate-900 tracking-tight">
                                {{ $posko['name'] }}
                            </h3>
                            <p class="text-xs sm:text-sm text-slate-600 leading-relaxed">
                                {{ $posko['address'] }}
                            </p>
                            <div class="inline-flex items-center gap-2 text-xs font-semibold text-slate-700 bg-white px-3 py-1.5 rounded-md border border-slate-200">
                                <svg class="w-4 h-4 text-sky-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                <span>{{ $posko['radius'] }}</span>
                            </div>
                        </div>
                        <div class="md:col-span-4 flex flex-col gap-2.5">
                            <a href="{{ $cityWaUrl }}" target="_blank" rel="noopener noreferrer"
                               class="min-h-11 inline-flex items-center justify-center gap-2 bg-emerald-700 hover:bg-emerald-800 text-white font-bold text-xs sm:text-sm px-5 py-2.5 rounded-lg shadow-2xs transition-all">
                                <svg class="w-4 h-4 fill-current shrink-0" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/></svg>
                                <span>Panggil Armada Siaga</span>
                            </a>
                            <span class="text-[11px] text-slate-500 text-center">Mobil operasional respon cepat</span>
                        </div>
                    </div>
                </div>
            </div>

            <div id="daftar-kecamatan" class="pt-4">
                <div class="max-w-3xl mb-8">
                    <p class="text-xs font-bold uppercase tracking-wider text-sky-800 mb-2">
                        DAFTAR AREA LAYANAN
                    </p>
                    <h2 class="text-2xl sm:text-3xl lg:text-4xl font-extrabold text-slate-900 tracking-tight">
                        Daftar Area Layanan di {{ $cityData['name'] }}
                    </h2>
                    <p class="text-slate-600 text-sm sm:text-base mt-2 leading-relaxed">
                        Area yang Dilayani di {{ $cityData['name'] }} mencakup seluruh kawasan posko siaga teknisi, estimasi kedatangan cepat, dan penawaran langsung dari armada terdekat.
                    </p>
                </div>

                <!-- Grid Area -->
                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-3">
                    @foreach($cityData['districts'] as $dist)
                        @php
                            $districtSlug = Str::slug($dist);
                            $districtUrl = route('area.detail', ['city' => $cityData['slug'], 'district' => $districtSlug]);
                            $distType = \App\Services\RegionService::districtType($cityData, $dist);
                        @endphp
                        <div class="p-3 rounded-lg border border-slate-200 bg-slate-50 hover:bg-sky-50 hover:border-sky-300 transition-all flex flex-col justify-between shadow-2xs card-lift min-h-14">
                            <span class="text-[10px] text-slate-500 font-bold uppercase tracking-wider mb-1">{{ $distType }}</span>
                            <h3 class="text-xs sm:text-sm font-bold text-slate-800 hover:text-sky-800 truncate">
                                <a href="{{ $districtUrl }}" class="hover:underline">
                                    {{ $dist }}
                                </a>
                            </h3>
                            <span class="text-[10px] text-slate-500 mt-1">Armada Siaga</span>
                        </div>
                    @endforeach
                </div>

                <!-- Tag SEO Pendukung -->
                @if(!empty($area->supporting_tags))
                    <div class="mt-8 pt-6 border-t border-slate-200">
                        <p class="text-xs font-bold uppercase tracking-wider text-slate-500 mb-2">
                            Area Kelurahan &amp; Titik Layanan Terkait di {{ $cityData['name'] }}:
                        </p>
                        <div class="flex flex-wrap gap-1.5">
                            @foreach($area->supporting_tags as $tag)
                                <span class="inline-block bg-slate-100 text-slate-700 text-xs px-2.5 py-1 rounded-md border border-slate-200">
                                    {{ $tag }}
                                </span>
                            @endforeach
                        </div>
                    </div>
                @endif

                @php
                    $allProvincesData = \App\Services\RegionService::all();
                    $currentProvData = $allProvincesData[$cityData['province_slug']] ?? null;
                    $siblingCities = collect($currentProvData['cities'] ?? [])
                        ->reject(fn($c) => ($c['slug'] ?? '') === $cityData['slug']);
                @endphp

                @if($siblingCities->isNotEmpty())
                    <div class="mt-8 pt-6 border-t border-slate-200">
                        <div class="flex items-center justify-between mb-3">
                            <span class="text-xs font-bold uppercase tracking-wider text-sky-800">
                                Posko Kota Terkait di {{ $cityData['province_name'] }}
                            </span>
                            @if(!empty($cityData['province_slug']))
                                <a href="{{ route('area.province', ['province' => $cityData['province_slug']]) }}" class="text-xs font-semibold text-sky-700 hover:underline">
                                    Semua {{ $cityData['province_name'] }} &rarr;
                                </a>
                            @endif
                        </div>
                        <div class="flex flex-wrap gap-2 text-xs">
                            @foreach($siblingCities as $sibling)
                                <a href="{{ route('area.city', ['city' => $sibling['slug']]) }}" 
                                   class="px-3 py-1.5 rounded-md bg-slate-50 hover:bg-sky-50 text-slate-800 hover:text-sky-700 font-semibold border border-slate-200 hover:border-sky-300 transition-all">
                                    {{ $sibling['name'] }}
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </section>

    <!-- 12. SECTION DYNAMIC FAQ KOTA -->
    @if(!empty($faqs) && count($faqs) > 0)
    <section id="faq-kota" class="py-14 lg:py-20 bg-slate-50 border-b border-slate-200">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-2xl mx-auto mb-10">
                <p class="text-xs font-bold uppercase tracking-wider text-sky-800 mb-1">
                    KONSULTASI &amp; PERTANYAAN
                </p>
                <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">
                    Tanya Jawab Layanan di {{ $cityData['name'] }}
                </h2>
                <p class="text-xs sm:text-sm text-slate-600 mt-1">
                    Pertanyaan yang sering diajukan seputar penanganan mekanis tanpa bongkar, kecepatan respon teknisi, dan garansi resmi 30 hari di {{ $cityData['name'] }}.
                </p>
            </div>

            <div x-data="{ active: null }" class="space-y-3">
                @foreach($faqs as $idx => $faq)
                    <div class="bg-white rounded-lg border border-slate-200 overflow-hidden shadow-2xs hover:border-sky-300 transition-colors">
                        <button type="button" 
                                @click="active = (active === {{ $idx }} ? null : {{ $idx }})"
                                aria-expanded="false"
                                :aria-expanded="active === {{ $idx }} ? 'true' : 'false'"
                                aria-controls="city-faq-ans-{{ $idx }}"
                                class="w-full py-4 px-4 sm:px-5 text-left font-semibold text-slate-900 flex items-center justify-between gap-3 focus-visible:outline-hidden focus-visible:ring-2 focus-visible:ring-sky-600 cursor-pointer">
                            <div class="flex items-center gap-3">
                                <span class="w-6 h-6 rounded-md bg-slate-100 text-slate-600 border border-slate-200 text-xs font-bold flex items-center justify-center shrink-0">
                                    {{ $idx + 1 }}
                                </span>
                                <span class="text-sm sm:text-base font-bold tracking-tight">{{ $faq['question'] }}</span>
                            </div>
                            <svg class="w-4 h-4 shrink-0 transform transition-transform duration-200 text-slate-400" 
                                 :class="{ 'rotate-180 text-sky-700': active === {{ $idx }} }" 
                                 fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </button>
                        <div id="city-faq-ans-{{ $idx }}" x-show="active === {{ $idx }}" x-cloak class="px-4 pb-4 text-xs sm:text-sm text-slate-600 leading-relaxed border-t border-slate-100 pt-3 pl-12 sm:pl-13">
                            <p>{{ $faq['answer'] }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    <!-- 13. FINAL CLOSING CTA -->
    <section id="kontak-kota" class="pt-12 pb-10 sm:pt-16 sm:pb-14 bg-slate-900 text-white relative overflow-hidden">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <p class="text-xs font-bold uppercase tracking-wider text-sky-400 mb-2">
                RESPON CEPAT WILAYAH {{ strtoupper($cityData['name']) }}
            </p>
            <h2 class="text-2xl sm:text-3xl lg:text-4xl font-extrabold text-white tracking-tight">
                Saluran Pipa di Lokasi Anda Tersumbat Hari Ini?
            </h2>
            <p class="text-slate-300 text-sm sm:text-base mt-3 max-w-xl mx-auto leading-relaxed">
                Tim teknisi kami siap merespon konsultasi dan menjadwalkan kedatangan armada ke seluruh penjuru {{ $cityData['name'] }}. Pengerjaan mekanis tanpa membongkar lantai keramik dan dilindungi garansi tertulis 30 hari kalender.
            </p>
            <div class="mt-6 sm:mt-8 flex flex-col sm:flex-row items-stretch sm:items-center justify-center gap-3 sm:gap-4 max-w-md sm:max-w-none mx-auto">
                <a href="{{ $cityWaUrl }}" target="_blank" rel="noopener noreferrer" 
                   class="w-full sm:w-auto min-h-12 inline-flex items-center justify-center gap-2.5 bg-emerald-700 hover:bg-emerald-800 text-white font-bold text-sm sm:text-base px-7 py-3.5 rounded-lg shadow-sm transition-all focus-visible:outline-hidden focus-visible:ring-2 focus-visible:ring-emerald-500">
                    <svg class="w-4 h-4 fill-current shrink-0" viewBox="0 0 24 24" aria-hidden="true">
                        <path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/>
                    </svg>
                    <span>Panggil Teknisi via WhatsApp</span>
                </a>
                <a href="#daftar-kecamatan" 
                   class="w-full sm:w-auto min-h-12 inline-flex items-center justify-center gap-2 bg-slate-800 hover:bg-slate-700 text-slate-200 border border-slate-700 font-bold text-sm px-6 py-3.5 rounded-lg transition-colors focus-visible:outline-hidden focus-visible:ring-2 focus-visible:ring-sky-500">
                    <span>Lihat Daftar Kecamatan</span>
                </a>
            </div>
            
            <div class="mt-6 flex flex-wrap items-center justify-center gap-2 sm:gap-4 text-xs text-slate-400">
                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-slate-800/60 border border-slate-700/60 text-[11px] sm:text-xs">
                    <svg class="w-3.5 h-3.5 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    Respon Cepat Armada
                </span>
                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-slate-800/60 border border-slate-700/60 text-[11px] sm:text-xs">
                    <svg class="w-3.5 h-3.5 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    Metode Tanpa Bongkar Keramik
                </span>
                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-slate-800/60 border border-slate-700/60 text-[11px] sm:text-xs">
                    <svg class="w-3.5 h-3.5 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    Garansi Tertulis 30 Hari
                </span>
            </div>
        </div>
    </section>
</div>
@endsection
