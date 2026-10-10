@extends('layouts.app')

@section('content')
@php
    $whatsappNumber = config('app.whatsapp_number') ?: '6281234567890';
    $waMsg = urlencode("Halo Drainusantara, saya butuh penanganan pipa mampet di Provinsi {$provinceData['name']}. Mohon info armada teknisi terdekat.");
    $waUrl = "https://wa.me/{$whatsappNumber}?text={$waMsg}";

    // Set custom hero background URL here or place image in public/images/areas/provinces/{slug}.webp
    $customHeroBg = null;
    $provinceSlug = $provinceData['slug'] ?? \Illuminate\Support\Str::slug($provinceData['name']);
    $heroBgImage = $customHeroBg 
        ?: (file_exists(public_path("images/areas/provinces/{$provinceSlug}.webp"))
            ? asset("images/areas/provinces/{$provinceSlug}.webp")
            : (file_exists(public_path("images/areas/provinces/{$provinceSlug}.jpg"))
                ? asset("images/areas/provinces/{$provinceSlug}.jpg")
                : ($provinceData['hero_image'] ?? null)));

    $defaultProblemCatalogs = [
        [
            'title' => 'Wastafel & Cuci Piring',
            'category' => 'Dapur & Residensial',
            'desc' => 'Air bak cuci piring meluap atau lambat surut karena tumpukan minyak beku, sisa masakan, dan ampas makanan yang mengeras di leher angsa sifon PVC.',
            'specs' => [
                'Mengikis kerak lemak jenuh tanpa merusak sifon',
                'Aman untuk sambungan pipa PVC leher angsa',
                'Pengerjaan 30-45 menit rapi tanpa kotor',
                'Garansi resmi 30 hari nota tertulis',
            ],
            'price' => 400000,
            'image' => asset('images/services/wastafel-cuci-piring-mampet.webp'),
        ],
        [
            'title' => 'Kloset & WC Meluap',
            'category' => 'Toilet & Kamar Mandi',
            'desc' => 'Kloset duduk atau jongkok meluap saat disiram akibat sumbatan tisu, pembalut, kain, atau kerak kotoran pada lekukan porselen kloset.',
            'specs' => [
                'Metode mekanis tanpa membongkar dudukan kloset keramik',
                'Daya putar meliuk aman di leher angsa keramik',
                'Teknisi ber-APD bersih dan bersarung tangan',
                'Garansi resmi 30 hari nota tertulis',
            ],
            'price' => 400000,
            'image' => asset('images/services/kloset-wc-mampet.webp'),
        ],
        [
            'title' => 'Floor Drain Kamar Mandi',
            'category' => 'Kamar Mandi & Lantai',
            'desc' => 'Air mandi menggenang di lantai dan memicu bau got tidak sedap akibat jalinan rambut rontok dan residu busa sabun yang menebal di jalur pipa.',
            'specs' => [
                'Melilit dan menarik gumpalan rambut serta kerak sabun',
                'Menghilangkan bau got dan melancarkan aliran air',
                'Melayani pipa diameter 2 hingga 4 inch',
                'Garansi resmi 30 hari nota tertulis',
            ],
            'price' => 400000,
            'image' => asset('images/services/floor-drain-kamar-mandi.webp'),
        ],
        [
            'title' => 'Talang Rooftop & Pipa Atap',
            'category' => 'Rooftop & Eksterior Gedung',
            'desc' => 'Pipa pembuangan talang atap meluap oleh endapan lumut tebal, pasir dak semen, dan dedaunan kering yang memicu kebocoran plafon rumah.',
            'specs' => [
                'Jangkauan kabel panjang menembus pipa vertikal',
                'Membersihkan endapan lumpur, lumut, dan dedaunan',
                'Mencegah rembesan air hujan ke plafon hunian',
                'Garansi resmi 30 hari nota tertulis',
            ],
            'price' => 400000,
            'image' => asset('images/services/talang-rooftop-pipa-atap.webp'),
        ],
        [
            'title' => 'Kuras Grease Trap & Lemak',
            'category' => 'Komersial F&B & Restoran',
            'desc' => 'Bak perangkap lemak (grease trap) dapur resto, kafe, atau rumah penuh kerak minyak padat berbau menyengat dan mengancam operasional.',
            'specs' => [
                'Pembersihan lemak jenuh dan sisa minyak komersial',
                'Perawatan berkala bebas bau untuk dapur usaha',
                'Tersedia dokumen invoice resmi untuk B2B',
                'Garansi resmi 30 hari nota tertulis',
            ],
            'price' => 400000,
            'image' => asset('images/services/kuras-grease-trap-lemak.webp'),
        ],
        [
            'title' => 'Inspeksi Kamera CCTV Pipa IP68',
            'category' => 'Diagnostik & Jalur Pipa',
            'desc' => 'Pemeriksaan visual jalur internal pipa pembuangan dengan kamera endoskopi anti-air untuk mendeteksi posisi retakan, sambungan lepas, atau sumbatan batu.',
            'specs' => [
                'Kamera fleksibel jangkauan hingga 30 meter',
                'Monitor digital resolusi tinggi langsung di lokasi',
                'Pembuktian visual sebelum dan sesudah pengerjaan',
                'Garansi resmi 30 hari nota tertulis',
            ],
            'price' => 500000,
            'image' => asset('images/services/inspeksi-kamera-cctv-pipa.webp'),
        ],
    ];

    $itemsLayanan = (isset($services) && $services->isNotEmpty()) ? $services : collect($defaultProblemCatalogs);

    $displayGalleries = ($galleries ?? collect())->take(3);
    $countTotal = $displayGalleries->count();
    $countRumahan = $displayGalleries->where('category', 'rumahan')->count();
    $countB2b = $displayGalleries->where('category', 'b2b')->count();
@endphp

@push('styles')
<style>
    .area-directory-page .area-hero {
        background: #f8fafc;
        border-bottom-color: #cbd5e1;
    }
    .area-directory-page .area-hero h1 { max-width: 14ch; letter-spacing: -0.045em; }
    .area-directory-page .area-hero p { max-width: 58ch; }
    .area-directory-page .area-hero .hero-proof {
        border-left: 3px solid #0369a1;
        padding-left: 1rem;
    }
    .area-directory-page .service-card,
    .area-directory-page .city-card {
        border-radius: 0.5rem;
        box-shadow: none;
    }
    .area-directory-page .service-card:hover,
    .area-directory-page .city-card:hover {
        border-color: #0369a1;
        box-shadow: 0 8px 24px rgb(15 23 42 / 0.08);
    }
    .area-directory-page .directory-heading { max-width: 44rem; }
    @media (max-width: 639px) {
        .area-directory-page .area-hero h1 { max-width: 15ch; }
        .area-directory-page .area-hero .hero-proof { padding-left: 0.75rem; }
    }
</style>
@endpush

<div class="area-directory-page pb-24 md:pb-0">
    <section class="relative area-hero bg-slate-50 border-b border-slate-200 pt-6 pb-12 sm:pt-10 sm:pb-16 lg:pt-14 lg:pb-20 overflow-hidden">
        @if(!empty($heroBgImage))
            <div class="absolute inset-0 z-0 pointer-events-none overflow-hidden" aria-hidden="true">
                <img src="{{ $heroBgImage }}" 
                     alt="Latar Belakang Wilayah {{ $provinceData['name'] }}" 
                     loading="eager"
                     decoding="async"
                     class="w-full h-full object-cover object-center opacity-60 md:opacity-75 scale-105 transition-transform duration-700">
                <div class="absolute inset-0 bg-linear-to-r from-slate-50 via-slate-50/85 to-slate-50/20"></div>
                <div class="absolute inset-0 bg-linear-to-t from-slate-50 via-transparent to-slate-50/30"></div>
            </div>
        @endif

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <nav class="flex items-center gap-2 text-xs text-slate-500 mb-6 flex-wrap font-medium reveal-fade" aria-label="Breadcrumb">
                <a href="{{ url('/') }}" class="hover:text-sky-700 transition-colors flex items-center gap-1.5 focus-visible:outline-hidden focus-visible:ring-2 focus-visible:ring-sky-600 rounded-sm">
                    <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                    </svg>
                    <span>Beranda</span>
                </a>
                <span class="text-slate-300">/</span>
                <a href="{{ route('area.index') }}" class="hover:text-sky-700 transition-colors focus-visible:outline-hidden focus-visible:ring-2 focus-visible:ring-sky-600 rounded-sm">
                    Direktori Wilayah
                </a>
                <span class="text-slate-300">/</span>
                <span class="text-sky-800 font-bold" aria-current="page">Provinsi {{ $provinceData['name'] }}</span>
            </nav>

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-12 items-start">
                <div class="lg:col-span-8 space-y-5 sm:space-y-6">
                    <div class="inline-flex items-center gap-2 px-3 py-1.5 bg-white border border-slate-200 rounded-lg text-xs font-semibold text-slate-800 shadow-2xs reveal-fade">
                        <span class="w-2 h-2 rounded-full bg-emerald-600"></span>
                        <span>Posko Wilayah Resmi: Provinsi {{ $provinceData['name'] }}</span>
                    </div>

                    <h1 class="text-2xl sm:text-4xl lg:text-5xl font-extrabold text-slate-900 tracking-tight leading-tight sm:leading-tight reveal-soft">
                        Jasa Saluran Pipa Mampet <span class="text-sky-700">Provinsi {{ $provinceData['name'] }}</span>
                    </h1>

                    <p class="text-sm sm:text-base text-slate-600 leading-relaxed max-w-2xl reveal-soft delay-100">
                        Pelancaran pipa wastafel tersumbat minyak, kloset meluap, dan floor drain berbau got di seluruh kota dan kabupaten <strong>Provinsi {{ $provinceData['name'] }}</strong>. Dikerjakan mekanis menggunakan mesin spiral rotary baja elastis, metode tanpa membongkar keramik lantai, dan dilindungi garansi resmi 30 hari kalender.
                    </p>

                    <div class="grid grid-cols-3 gap-2.5 sm:gap-3.5 pt-1 reveal-soft delay-150">
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

                    <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3 pt-2 hero-proof reveal-soft delay-200">
                        <a href="{{ $waUrl }}" target="_blank" rel="noopener noreferrer" 
                           class="min-h-12 inline-flex items-center justify-center gap-2.5 bg-emerald-700 hover:bg-emerald-800 text-white font-bold text-sm sm:text-base px-6 py-3 rounded-lg shadow-xs hover:shadow transition-all focus-visible:outline-hidden focus-visible:ring-2 focus-visible:ring-emerald-500 btn-press">
                            <svg class="w-4 h-4 fill-current shrink-0" viewBox="0 0 24 24" aria-hidden="true">
                                <path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/>
                            </svg>
                            <span>Hubungi Teknisi {{ $provinceData['name'] }}</span>
                        </a>
                        
                        <a href="#wilayah-layanan" 
                           class="min-h-12 inline-flex items-center justify-center gap-2 bg-white hover:bg-slate-100 text-slate-800 font-bold text-xs sm:text-sm px-5 py-3 rounded-lg border border-slate-300 shadow-2xs transition-colors focus-visible:outline-hidden focus-visible:ring-2 focus-visible:ring-sky-600 btn-press">
                            <span>Pilih Kota &amp; Area ({{ count($provinceData['cities']) }})</span>
                            <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </a>
                    </div>
                </div>

                <div class="hidden lg:block lg:col-span-4 reveal-soft delay-150">
                    <div class="bg-white rounded-xl p-3 sm:p-4 border border-slate-200 shadow-xs space-y-3 card-lift">
                        <div class="relative rounded-lg overflow-hidden aspect-4/3 bg-slate-900 border border-slate-200">
                            <img 
                                src="{{ asset('images/hero-technician.webp') }}" 
                                alt="Teknisi Drainusantara Penanganan Saluran Mampet di Provinsi {{ $provinceData['name'] }}" 
                                width="600" 
                                height="450" 
                                loading="eager"
                                fetchpriority="high"
                                decoding="async"
                                class="w-full h-full object-cover"
                            >
                        </div>
                        <div class="px-1 py-0.5 flex items-center justify-between text-xs text-slate-600">
                            <span class="font-medium text-slate-700">Armada Siaga &amp; Mesin Ridgid</span>
                            <span class="text-emerald-700 font-bold">Metode Tanpa Bongkar</span>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <section id="layanan" class="py-14 lg:py-20 bg-white border-b border-slate-200" x-data="mobileCarousel({{ count($itemsLayanan) }}, 4500)">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto mb-10 md:mb-14">
                <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-sky-50 border border-sky-200 text-sky-800 text-xs font-bold rounded-md uppercase tracking-wider mb-2">
                    KATALOG SPESIALIS MASALAH PIPA
                </span>
                <h2 class="text-2xl sm:text-3xl lg:text-4xl font-extrabold text-slate-900 tracking-tight">
                    Layanan Saluran Pipa Mampet di {{ $provinceData['name'] }}
                </h2>
                <p class="text-slate-600 text-sm sm:text-base mt-3 leading-relaxed">
                    Pembersihan kerak minyak masakan, endapan busa sabun, dan sumbatan kotoran menggunakan mesin spiral rotary baja elastis. Dikerjakan langsung dari lubang pipa eksisting tanpa merusak keramik lantai maupun dinding.
                </p>
                <div class="flex md:hidden items-center justify-center gap-1.5 text-xs text-sky-700 font-medium mt-3" aria-hidden="true">
                    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                    </svg>
                    <span>Geser untuk layanan lainnya &bull; Auto-scroll aktif</span>
                </div>
            </div>

            <div x-ref="slider" tabindex="0" role="region" aria-label="Layanan provinsi — geser untuk melihat lainnya"
                 @scroll.passive="onScroll()"
                 @touchstart="pause()"
                 @touchend="resume()"
             @touchcancel="resume()"
                 class="flex md:grid md:grid-cols-2 lg:grid-cols-3 overflow-x-auto md:overflow-visible snap-x snap-mandatory no-scrollbar gap-5 lg:gap-6 pb-4 pt-1 px-4 -mx-4 sm:mx-0 sm:px-0">
                @foreach($itemsLayanan as $catalog)
                    @php
                        $isModel = $catalog instanceof \App\Models\Service;
                        $title = $isModel ? $catalog->name : $catalog['title'];
                        $slug = $isModel ? $catalog->slug : \Illuminate\Support\Str::slug($catalog['title']);
                        $desc = $isModel ? ($catalog->short_description ?: ($catalog->description ?: 'Pelancaran saluran mampet tanpa bongkar keramik.')) : $catalog['desc'];
                        $price = $isModel ? $catalog->price_starting_from : $catalog['price'];
                        $features = $isModel ? ($catalog->features ?: []) : ($catalog['specs'] ?? []);

                        $category = 'Layanan Spesialis';
                        $lowerName = strtolower($title);
                        if (str_contains($lowerName, 'wastafel') || str_contains($lowerName, 'dapur') || str_contains($lowerName, 'sink')) {
                            $category = 'Dapur & Residensial';
                        } elseif (str_contains($lowerName, 'kloset') || str_contains($lowerName, 'wc') || str_contains($lowerName, 'toilet')) {
                            $category = 'Toilet & Kamar Mandi';
                        } elseif (str_contains($lowerName, 'floor drain') || str_contains($lowerName, 'kamar mandi')) {
                            $category = 'Kamar Mandi & Lantai';
                        } elseif (str_contains($lowerName, 'cctv') || str_contains($lowerName, 'kamera')) {
                            $category = 'Diagnostik & Jalur Pipa';
                        } elseif (str_contains($lowerName, 'grease') || str_contains($lowerName, 'lemak') || str_contains($lowerName, 'resto')) {
                            $category = 'Komersial F&B & Restoran';
                        } elseif (str_contains($lowerName, 'talang') || str_contains($lowerName, 'atap')) {
                            $category = 'Talang & Saluran Atap';
                        } elseif (!$isModel && isset($catalog['category'])) {
                            $category = $catalog['category'];
                        }

                        $rawImage = $isModel ? $catalog->image : ($catalog['image'] ?? null);
                        $fallbackImage = asset('assets/placeholders/service.svg');
                        if (empty($rawImage) || str_contains($rawImage, 'placehold.co') || str_contains($rawImage, 'unsplash.com')) {
                            $imageSrc = $fallbackImage;
                        } else {
                            $imageSrc = str_starts_with($rawImage, 'http://') || str_starts_with($rawImage, 'https://')
                                ? $rawImage : asset(ltrim($rawImage, '/'));
                        }

                        $waMessage = "Halo Drainusantara, saya butuh penanganan untuk {$title} di Provinsi {$provinceData['name']}. Mohon info estimasi biaya dan kedatangan teknisi.";
                        $itemWaUrl = "https://wa.me/{$whatsappNumber}?text=" . urlencode($waMessage);
                    @endphp
                    <div class="w-[84vw] sm:w-[320px] md:w-auto shrink-0 snap-center service-card bg-white rounded-lg border border-slate-200 shadow-2xs hover:border-sky-300 hover:shadow-xs transition-all duration-200 flex flex-col justify-between p-4 sm:p-5 group card-lift reveal-soft stagger-{{ ($loop->iteration % 3) + 1 }}">
                        <div>
                            <div class="relative w-full aspect-16/10 rounded-md overflow-hidden bg-slate-100 mb-4 border border-slate-100">
                                <img src="{{ $imageSrc }}" 
                                     alt="{{ $title }}" 
                                     width="600"
                                     height="375"
                                     loading="lazy" 
                                     decoding="async"
                                     class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300 ease-out"
                                     onerror="this.onerror=null; this.src='{{ $fallbackImage }}';">
                            </div>

                            <h3 class="text-lg font-bold tracking-tight text-slate-900 group-hover:text-sky-700 transition-colors mb-2">
                                {{ $title }}
                            </h3>

                            <p class="text-xs sm:text-sm text-slate-600 leading-relaxed mb-4">
                                {{ $desc }}
                            </p>

                            @if(!empty($features) && is_array($features))
                                <ul class="space-y-1.5 text-xs text-slate-600 mb-4 pt-3 border-t border-slate-100">
                                    @foreach(array_slice($features, 0, 3) as $feat)
                                        <li class="flex items-start gap-1.5">
                                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-600 mt-1.5 shrink-0"></span>
                                            <span>{{ $feat }}</span>
                                        </li>
                                    @endforeach
                                </ul>
                            @endif
                        </div>

                        <div class="pt-4 border-t border-slate-100 flex items-center justify-between gap-3 mt-2">
                            <div>
                                <span class="text-[10px] text-slate-500 font-medium block">Biaya Mulai Dari</span>
                                <span class="text-sm font-extrabold text-slate-900">{{ $price > 0 ? 'Rp '.number_format($price, 0, ',', '.') : 'Hubungi untuk harga' }}</span>
                            </div>
                            <a href="{{ $itemWaUrl }}" 
                               target="_blank" 
                               rel="noopener noreferrer" 
                               class="inline-flex items-center gap-1.5 bg-emerald-700 hover:bg-emerald-800 text-white font-bold text-xs px-3.5 py-2.5 rounded-lg shadow-2xs transition-colors min-h-11">
                                <span>Pesan Penanganan</span>
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                                </svg>
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="flex md:hidden justify-center items-center flex-wrap gap-1.5 mt-4">
                @for($i = 0; $i < count($itemsLayanan); $i++)
                    <button :aria-current="active === {{ $i }} ? 'true' : 'false'" type="button"
                            @click="goTo({{ $i }})"
                            class="carousel-dot"

                            aria-label="Layanan {{ $i + 1 }}">
                    <span aria-hidden="true" class="h-2 rounded-full transition-all duration-300 ease-out cursor-pointer active:scale-75" :class="active === {{ $i }} ? 'w-6 bg-sky-700' : 'w-2 bg-slate-300 hover:bg-slate-400'"></span></button>
                @endfor
            </div>
        </div>
    </section>

    <section id="dokumentasi" class="py-14 lg:py-20 bg-slate-50 border-b border-slate-200" x-data="{ activeCategory: 'all' }">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row items-start md:items-end justify-between gap-4 mb-8 md:mb-12">
                <div class="max-w-2xl">
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-sky-50 border border-sky-200 text-sky-800 text-xs font-bold rounded-md uppercase tracking-wider mb-2">
                        BUKTI PENGERJAAN NYATA
                    </span>
                    <h2 class="text-2xl sm:text-3xl lg:text-4xl font-extrabold text-slate-900 tracking-tight">
                        Hasil Pengerjaan Teknisi di Lapangan
                    </h2>
                    <p class="text-slate-600 text-sm sm:text-base mt-2">
                        Dokumentasi riil penanganan saluran pipa tersumbat pada sektor hunian residensial dan tempat usaha komersial menggunakan mesin rooter spiral elektrik serta inspeksi kamera endoskopi.
                    </p>
                </div>
                <div>
                    <a href="{{ url('/galeri') }}" 
                       class="inline-flex items-center gap-2 text-xs sm:text-sm font-bold text-sky-700 hover:text-sky-800 bg-white hover:bg-slate-100 border border-slate-300 px-4 py-2.5 rounded-lg shadow-2xs transition-colors min-h-11">
                        <span>Lihat Semua Galeri</span>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                        </svg>
                    </a>
                </div>
            </div>

            @if($countTotal > 0)
                <div class="flex flex-wrap items-center gap-2 mb-8">
                    <button type="button" 
                            @click="activeCategory = 'all'"
                            :class="activeCategory === 'all' ? 'bg-sky-700 text-white font-bold shadow-2xs' : 'bg-white hover:bg-slate-100 text-slate-700 font-semibold border border-slate-200'"
                            class="px-4 py-2 rounded-lg text-xs transition-colors cursor-pointer focus-visible:outline-hidden focus-visible:ring-2 focus-visible:ring-sky-600 min-h-11">
                        Semua Sektor ({{ $countTotal }})
                    </button>
                    <button type="button" 
                            @click="activeCategory = 'rumahan'"
                            :class="activeCategory === 'rumahan' ? 'bg-sky-700 text-white font-bold shadow-2xs' : 'bg-white hover:bg-slate-100 text-slate-700 font-semibold border border-slate-200'"
                            class="px-4 py-2 rounded-lg text-xs transition-colors cursor-pointer focus-visible:outline-hidden focus-visible:ring-2 focus-visible:ring-sky-600 min-h-11">
                        Rumahan / Residensial ({{ $countRumahan }})
                    </button>
                    <button type="button" 
                            @click="activeCategory = 'b2b'"
                            :class="activeCategory === 'b2b' ? 'bg-sky-700 text-white font-bold shadow-2xs' : 'bg-white hover:bg-slate-100 text-slate-700 font-semibold border border-slate-200'"
                            class="px-4 py-2 rounded-lg text-xs transition-colors cursor-pointer focus-visible:outline-hidden focus-visible:ring-2 focus-visible:ring-sky-600 min-h-11">
                        B2B / Komersial ({{ $countB2b }})
                    </button>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 lg:gap-8">
                    @foreach($displayGalleries as $item)
                        @php
                            $isB2b = ($item->category ?? 'rumahan') === 'b2b';
                            $photo = $item->image ?: ($item->after_image ?: $item->before_image);
                            $serviceTitle = is_object($item->service ?? null) ? $item->service->name : 'Pelancaran Pipa';
                            $waText = urlencode("Halo Tim Drainusantara, saya melihat dokumentasi '{$item->title}'. Saluran pipa saya di Provinsi {$provinceData['name']} ada kendala serupa, mohon info estimasi kedatangan teknisi.");
                            $itemWaUrl = "https://wa.me/{$whatsappNumber}?text={$waText}";
                        @endphp
                        <div x-show="activeCategory === 'all' || activeCategory === '{{ $item->category ?? 'rumahan' }}'"
                             class="bg-white rounded-xl border border-slate-200 overflow-hidden shadow-2xs hover:shadow-xs transition-all flex flex-col justify-between card-lift reveal-soft stagger-{{ ($loop->iteration % 3) + 1 }}">
                            <div>
                                <div class="relative aspect-16/10 bg-slate-900 overflow-hidden border-b border-slate-100">
                                    @if($photo)
                                        <img 
                                            src="{{ $photo }}" 
                                            alt="{{ $item->title }}" 
                                            class="w-full h-full object-cover transition-transform duration-300 hover:scale-105"
                                            width="600"
                                            height="375"
                                            loading="lazy"
                                            decoding="async"
                                        >
                                    @else
                                        <div class="w-full h-full flex items-center justify-center bg-slate-100 text-slate-400 text-xs">
                                            Foto Dokumentasi Pengerjaan
                                        </div>
                                    @endif

                                    @if($isB2b)
                                        <span class="absolute top-3 left-3 bg-slate-950/85 backdrop-blur-xs border border-amber-500/40 text-amber-300 text-[11px] font-bold px-2.5 py-1 rounded-md shadow-xs flex items-center gap-1.5">
                                            <svg class="w-3.5 h-3.5 fill-current" viewBox="0 0 20 20" aria-hidden="true">
                                                <path d="M4 4a2 2 0 012-2h8a2 2 0 012 2v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4zm3 1h6v2H7V5zm6 4H7v2h6V9zm-6 4h6v2H7v-2z"/>
                                            </svg>
                                            B2B Komersial
                                        </span>
                                    @else
                                        <span class="absolute top-3 left-3 bg-slate-950/85 backdrop-blur-xs border border-sky-500/40 text-sky-300 text-[11px] font-bold px-2.5 py-1 rounded-md shadow-xs flex items-center gap-1.5">
                                            <svg class="w-3.5 h-3.5 fill-current" viewBox="0 0 20 20" aria-hidden="true">
                                                <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"/>
                                            </svg>
                                            Rumahan Residensial
                                        </span>
                                    @endif
                                </div>

                                <div class="p-5 sm:p-6">
                                    <div class="flex items-center gap-2 mb-2">
                                        <span class="px-2 py-0.5 text-[11px] font-bold bg-sky-50 text-sky-800 border border-sky-200 rounded-md">
                                            {{ $serviceTitle }}
                                        </span>
                                    </div>
                                    <h3 class="text-base font-bold text-slate-900 mb-2 leading-snug line-clamp-2">
                                        {{ $item->title }}
                                    </h3>
                                    <p class="text-sm text-slate-600 leading-relaxed line-clamp-3">
                                        {{ $item->description }}
                                    </p>
                                </div>
                            </div>

                            <div class="p-5 sm:p-6 pt-3 border-t border-slate-100 flex items-center justify-end bg-slate-50/50">
                                <a href="{{ $itemWaUrl }}" 
                                   target="_blank" 
                                   rel="noopener noreferrer" 
                                   class="text-xs sm:text-sm font-bold text-sky-700 hover:text-sky-800 underline underline-offset-2 min-h-9 inline-flex items-center gap-1 group/btn">
                                    <span>Konsultasi Kasus Ini</span>
                                    <svg class="w-3.5 h-3.5 group-hover/btn:translate-x-0.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                                    </svg>
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="py-12 px-6 text-center bg-white rounded-xl border border-slate-200 text-slate-500">
                    <div class="w-12 h-12 mx-auto mb-3 rounded-full bg-slate-100 text-slate-400 flex items-center justify-center">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    <h3 class="text-base font-bold text-slate-800 mb-1">Dokumentasi Belum Ditampilkan</h3>
                    <p class="text-xs text-slate-500 max-w-md mx-auto">
                        Foto hasil pengerjaan lapangan teknisi akan otomatis tampil di sini setelah data galeri aktif ditambahkan pada sistem.
                    </p>
                </div>
            @endif

        </div>
    </section>

    <x-area.equipment-section 
        :area-name="'Provinsi ' . $provinceData['name']"
        bg-color="bg-white"
        eyebrow="PERALATAN STANDAR ARMADA"
        :title="'Peralatan Canggih Siaga di Provinsi ' . $provinceData['name']"
        :description="'Armada teknisi kami di Provinsi ' . $provinceData['name'] . ' selalu dibekali unit mesin drain rooter mekanis dan kamera endoskopi IP68 berstandar industri. Menuntaskan sumbatan secara aman tanpa merusak pipa PVC dan tanpa bongkar keramik lantai.'"
    />

    <section id="wilayah-layanan" class="py-14 lg:py-20 bg-slate-50 border-b border-slate-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="max-w-3xl mb-10">
                <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-white border border-slate-200 text-sky-800 text-xs font-bold rounded-md uppercase tracking-wider mb-2 shadow-2xs">
                    KOTA &amp; KABUPATEN YANG DILAYANI
                </span>
                <h2 class="text-2xl sm:text-3xl lg:text-4xl font-extrabold text-slate-900 tracking-tight">
                    Pilih Kota atau Kabupaten Anda di {{ $provinceData['name'] }}
                </h2>
                <p class="text-slate-600 text-sm sm:text-base mt-2 leading-relaxed">
                    Pilih kota untuk melihat posko spesifik, atau klik langsung nama area Anda di bawahnya untuk respon cepat teknisi terdekat.
                </p>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                @foreach($provinceData['cities'] as $citySlug => $city)
                    <div class="bg-white city-card rounded-lg border border-slate-200 p-6 sm:p-7 hover:border-sky-300 flex flex-col justify-between shadow-2xs card-lift reveal-soft stagger-{{ ($loop->iteration % 2) + 1 }}">
                        <div>
                            <div class="flex flex-col sm:flex-row sm:items-start justify-between gap-4 pb-5 border-b border-slate-100">
                                <div>
                                    <div class="flex items-center gap-2 mb-2">
                                        <span class="text-xs font-bold text-sky-800 bg-sky-50 px-2.5 py-0.5 rounded-md border border-sky-200">
                                            {{ $city['type'] }}
                                        </span>
                                        <span class="text-xs text-emerald-800 font-bold bg-emerald-50 px-2.5 py-0.5 rounded-md border border-emerald-200 flex items-center gap-1">
                                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-600"></span>
                                            <span>Armada Siaga &bull; Respon Cepat</span>
                                        </span>
                                    </div>
                                    <h3 class="text-xl font-bold text-slate-900 tracking-tight">
                                        <a href="{{ route('area.city', ['city' => $citySlug]) }}" class="hover:text-sky-700 transition-colors">
                                            {{ $city['name'] }}
                                        </a>
                                    </h3>
                                    <p class="text-xs text-slate-500 mt-1">
                                        {{ $city['posko_address'] }}
                                    </p>
                                </div>

                                <a href="{{ route('area.city', ['city' => $citySlug]) }}" 
                                   class="inline-flex items-center gap-1.5 text-xs font-bold text-white bg-sky-700 hover:bg-sky-800 px-4 py-2.5 rounded-lg transition-colors shrink-0 shadow-2xs min-h-11">
                                    <span>Buka Halaman Kota</span>
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                    </svg>
                                </a>
                            </div>

                            <div class="mt-5">
                                <span class="text-xs text-slate-500 uppercase font-bold tracking-wider block mb-3">
                                    PILIH AREA DI {{ strtoupper($city['name']) }}:
                                </span>
                                <div class="grid grid-cols-2 sm:grid-cols-3 gap-2 text-xs">
                                    @foreach($city['districts'] as $district)
                                        @php
                                            $districtSlug = \Illuminate\Support\Str::slug($district);
                                        @endphp
                                        <a href="{{ route('area.detail', ['city' => $citySlug, 'district' => $districtSlug]) }}" 
                                           class="p-2.5 rounded-lg bg-slate-50 hover:bg-sky-50 border border-slate-200 hover:border-sky-300 text-slate-800 hover:text-sky-700 font-semibold transition-all truncate flex items-center gap-1.5 min-h-11 focus-visible:outline-hidden focus-visible:ring-2 focus-visible:ring-sky-600">
                                            <span class="w-1.5 h-1.5 rounded-full bg-slate-300 shrink-0"></span>
                                            <span class="truncate">{{ $district }}</span>
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

        </div>
    </section>

    <section id="kontak-provinsi" class="py-14 lg:py-20 bg-slate-900 text-white relative overflow-hidden">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-slate-800 border border-slate-700 text-sky-400 text-xs font-bold rounded-md uppercase tracking-wider mb-3">
                RESPON CEPAT PROVINSI {{ strtoupper($provinceData['name']) }}
            </span>
            <h2 class="text-2xl sm:text-3xl lg:text-4xl font-extrabold text-white tracking-tight">
                Saluran Pipa di Lokasi Anda Tersumbat Hari Ini?
            </h2>
            <p class="text-slate-300 text-sm sm:text-base mt-3 max-w-xl mx-auto leading-relaxed">
                Tim teknisi kami siap merespon konsultasi dan menjadwalkan kedatangan armada ke seluruh penjuru {{ $provinceData['name'] }}. Pengerjaan mekanis tanpa membongkar lantai keramik dan dilindungi garansi tertulis 30 hari kalender.
            </p>
            <div class="mt-8 flex flex-col sm:flex-row items-center justify-center gap-4">
                <a href="{{ $waUrl }}" target="_blank" rel="noopener noreferrer" 
                   class="min-h-11 inline-flex items-center justify-center gap-2.5 bg-emerald-700 hover:bg-emerald-800 text-white font-bold text-sm px-6 py-3.5 rounded-lg shadow-sm transition-all focus-visible:outline-hidden focus-visible:ring-2 focus-visible:ring-emerald-500">
                    <svg class="w-4 h-4 fill-current shrink-0" viewBox="0 0 24 24" aria-hidden="true">
                        <path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/>
                    </svg>
                    <span>Panggil Teknisi via WhatsApp</span>
                </a>
                <a href="#wilayah-layanan" 
                   class="min-h-11 inline-flex items-center justify-center gap-2 bg-slate-800 hover:bg-slate-700 text-slate-200 border border-slate-700 font-bold text-sm px-6 py-3.5 rounded-lg transition-colors focus-visible:outline-hidden focus-visible:ring-2 focus-visible:ring-sky-500">
                    <span>Lihat Daftar Kota &amp; Area</span>
                </a>
            </div>
            
            <div class="mt-6 flex flex-wrap items-center justify-center gap-x-6 gap-y-2 text-xs text-slate-400">
                <span class="inline-flex items-center gap-1.5">
                    <svg class="w-4 h-4 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    Respon Cepat Armada
                </span>
                <span class="inline-flex items-center gap-1.5">
                    <svg class="w-4 h-4 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    Metode Tanpa Bongkar Keramik
                </span>
                <span class="inline-flex items-center gap-1.5">
                    <svg class="w-4 h-4 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    Garansi Tertulis 30 Hari
                </span>
            </div>
        </div>
    </section>
</div>
@endsection
