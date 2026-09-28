@extends('layouts.app')

@section('content')
@php
    $whatsappNumber = config('app.whatsapp_number', '6281234567890');
    $emergencyWaMsg = urlencode("Halo teknisi Drainusantara, saya butuh perbaikan saluran mampet di area {$area->district}, {$area->city}. Mohon info biaya dan estimasi kedatangan teknisi ke lokasi saya.");
    $emergencyWaUrl = "https://wa.me/{$whatsappNumber}?text={$emergencyWaMsg}";
@endphp

<!-- ====================================================================
     1. HERO SECTION AREA LAYANAN DINAMIS (MODERN FRIENDLY & HIGIENIS)
==================================================================== -->
<section class="relative bg-slate-50 border-b border-slate-200 pt-5 pb-8 sm:pt-8 sm:pb-14 lg:pt-12 lg:pb-18 overflow-hidden">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <!-- Breadcrumb Navigation: Compact Backlink on Mobile, Full on Desktop -->
        <div class="sm:hidden mb-3 reveal-fade">
            <a href="{{ route('area.city', ['city' => $cityData['slug'] ?? \Illuminate\Support\Str::slug($area->city)]) }}" 
               class="inline-flex items-center gap-1.5 text-xs font-semibold text-slate-600 hover:text-sky-700 transition-colors">
                <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
                <span>Area {{ $area->city }}</span>
            </a>
        </div>

        <nav class="hidden sm:flex items-center gap-2 text-xs text-slate-500 mb-6 font-medium flex-wrap reveal-fade" aria-label="Breadcrumb">
            <a href="{{ url('/') }}" class="hover:text-sky-700 transition-colors flex items-center gap-1.5">
                <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                </svg>
                <span>Beranda</span>
            </a>
            <span class="text-slate-300">/</span>
            <a href="{{ route('area.index') }}" class="hover:text-sky-700 transition-colors">Area</a>
            @if(isset($cityData) && !empty($cityData['province_slug']))
                <span class="text-slate-300">/</span>
                <a href="{{ route('area.province', ['province' => $cityData['province_slug']]) }}" class="hover:text-sky-700 transition-colors">
                    {{ $cityData['province_name'] }}
                </a>
            @endif
            <span class="text-slate-300">/</span>
            <a href="{{ route('area.city', ['city' => $cityData['slug'] ?? \Illuminate\Support\Str::slug($area->city)]) }}" class="hover:text-sky-700 transition-colors">
                {{ $area->city }}
            </a>
            <span class="text-slate-300">/</span>
            <span class="text-sky-700 font-bold">{{ $area->district }}</span>
        </nav>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 lg:gap-10 items-center">
            <!-- Hero Left: Text & CTA -->
            <div class="lg:col-span-7 space-y-4 sm:space-y-5 text-left">
                <!-- Live Response Pill / Badge -->
                <div class="inline-flex items-center gap-2 px-3 py-1 bg-white border border-slate-200 rounded-lg text-xs font-bold text-slate-800 shadow-2xs reveal-fade delay-50">
                    <span class="w-2 h-2 bg-emerald-500 rounded-full animate-pulse"></span>
                    <span class="sm:hidden">Posko Siaga &bull; Respon Cepat</span>
                    <span class="hidden sm:inline">Posko Siaga Teknisi &bull; Respon Cepat Armada</span>
                </div>

                <!-- Dynamic Main SEO Heading -->
                <h1 class="text-2xl sm:text-4xl md:text-5xl font-extrabold text-slate-900 tracking-tight leading-snug sm:leading-tight reveal-soft delay-100">
                    Jasa Pipa & Saluran Mampet <span class="text-sky-700">{{ $area->district }}, {{ $area->city }}</span>
                </h1>

                <!-- Persuasive Dynamic Subheading -->
                <p class="text-sm sm:text-base text-slate-600 leading-relaxed max-w-2xl reveal-soft delay-150">
                    Pelancaran wastafel, kloset toilet, dan saluran mampet di area <strong>{{ $area->district }}</strong>. Dikerjakan mekanis tanpa bongkar keramik lantai hunian Anda, tuntas bersih, dan bergaransi 30 hari.
                </p>

                <!-- Estimasi Respon & Highlights: 3 Compact Pills on Mobile with Stagger Delays -->
                <div class="grid grid-cols-3 gap-2 sm:gap-3 pt-1">
                    <div class="bg-white p-2.5 sm:p-3.5 rounded-lg border border-slate-200 shadow-2xs flex flex-col sm:flex-row items-center sm:items-center gap-1.5 sm:gap-3 text-center sm:text-left card-lift reveal-soft stagger-1">
                        <div class="w-8 h-8 sm:w-10 sm:h-10 rounded-md bg-sky-50 border border-sky-200 text-sky-700 flex items-center justify-center shrink-0">
                            <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <div class="min-w-0">
                            <div class="text-[10px] sm:text-[11px] text-slate-500 font-medium leading-tight">Respon WA</div>
                            <div class="text-xs sm:text-sm font-extrabold text-emerald-700 truncate">Respon Cepat</div>
                        </div>
                    </div>

                    <div class="bg-white p-2.5 sm:p-3.5 rounded-lg border border-slate-200 shadow-2xs flex flex-col sm:flex-row items-center sm:items-center gap-1.5 sm:gap-3 text-center sm:text-left card-lift reveal-soft stagger-2">
                        <div class="w-8 h-8 sm:w-10 sm:h-10 rounded-md bg-amber-50 border border-amber-200 text-amber-700 flex items-center justify-center shrink-0">
                            <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                            </svg>
                        </div>
                        <div class="min-w-0">
                            <div class="text-[10px] sm:text-[11px] text-slate-500 font-medium leading-tight">Jaminan</div>
                            <div class="text-xs sm:text-sm font-extrabold text-slate-900 truncate">Garansi 30 Hari</div>
                        </div>
                    </div>

                    <div class="bg-white p-2.5 sm:p-3.5 rounded-lg border border-slate-200 shadow-2xs flex flex-col sm:flex-row items-center sm:items-center gap-1.5 sm:gap-3 text-center sm:text-left card-lift reveal-soft stagger-3">
                        <div class="w-8 h-8 sm:w-10 sm:h-10 rounded-md bg-emerald-50 border border-emerald-200 text-emerald-700 flex items-center justify-center shrink-0">
                            <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                            </svg>
                        </div>
                        <div class="min-w-0">
                            <div class="text-[10px] sm:text-[11px] text-slate-500 font-medium leading-tight">Metode</div>
                            <div class="text-xs sm:text-sm font-extrabold text-slate-900 truncate">Tanpa Bongkar</div>
                        </div>
                    </div>
                </div>

                <!-- 2 CTA Buttons with dynamic WhatsApp destination -->
                <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-2.5 sm:gap-3 pt-1 reveal-soft delay-200">
                    <a href="{{ $emergencyWaUrl }}" target="_blank" rel="noopener noreferrer" 
                       class="min-h-[48px] inline-flex items-center justify-center gap-2.5 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-sm sm:text-base px-6 py-3 rounded-lg shadow-sm hover:shadow transition-all btn-press">
                        <svg class="w-4 h-4 fill-current shrink-0" viewBox="0 0 24 24">
                            <path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/>
                        </svg>
                        <span>Panggil Teknisi Sekarang</span>
                    </a>

                    <!-- Tombol Sekunder -->
                    <a href="#layanan-area" 
                       class="min-h-[44px] inline-flex items-center justify-center gap-2 bg-white hover:bg-slate-50 text-slate-800 font-bold text-xs sm:text-sm px-5 py-2.5 rounded-lg border border-slate-200 shadow-2xs transition-colors btn-press">
                        <span>Lihat Layanan Tersedia</span>
                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </a>
                </div>
            </div>

            <!-- Hero Right: Posko & Info Card -->
            <div class="lg:col-span-5 reveal-soft delay-150">
                <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-4 sm:p-7 space-y-3 sm:space-y-4 card-lift">
                    <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                        <div>
                            <span class="text-[11px] sm:text-xs uppercase tracking-wider text-sky-700 font-bold block">UNIT REAKSI CEPAT</span>
                            <h3 class="text-base sm:text-lg font-bold text-slate-900 tracking-tight">Posko Layanan {{ $area->city }}</h3>
                        </div>
                        <span class="px-2.5 py-1 bg-emerald-50 text-emerald-800 border border-emerald-200 text-[11px] sm:text-xs font-bold rounded-md">
                            STANDBY 24/7
                        </span>
                    </div>

                    <div class="space-y-2.5 sm:space-y-3.5 text-xs sm:text-sm text-slate-600">
                        <div class="flex items-start gap-2.5 sm:gap-3">
                            <div class="w-6 h-6 sm:w-7 sm:h-7 rounded-md bg-sky-50 border border-sky-200 text-sky-700 flex items-center justify-center shrink-0 mt-0.5">
                                <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                            </div>
                            <div class="min-w-0">
                                <strong class="text-slate-800 block font-semibold">Cakupan Wilayah:</strong>
                                <span class="leading-relaxed">Kecamatan {{ $area->district }}, {{ $area->city }} @if($area->postal_code) (Kode Pos: {{ $area->postal_code }}) @endif.</span>
                            </div>
                        </div>

                        <div class="flex items-start gap-2.5 sm:gap-3">
                            <div class="w-6 h-6 sm:w-7 sm:h-7 rounded-md bg-sky-50 border border-sky-200 text-sky-700 flex items-center justify-center shrink-0 mt-0.5">
                                <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                                </svg>
                            </div>
                            <div class="min-w-0">
                                <strong class="text-slate-800 block font-semibold">Keamanan Properti:</strong>
                                <span class="leading-relaxed">Tanpa bongkar keramik, pengerjaan steril, dan bebas zat kimia berbahaya.</span>
                            </div>
                        </div>

                        <div class="flex items-start gap-2.5 sm:gap-3">
                            <div class="w-6 h-6 sm:w-7 sm:h-7 rounded-md bg-emerald-50 border border-emerald-200 text-emerald-700 flex items-center justify-center shrink-0 mt-0.5">
                                <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                                </svg>
                            </div>
                            <div class="min-w-0">
                                <strong class="text-slate-800 block font-semibold">Transparansi Biaya:</strong>
                                <span class="leading-relaxed">Estimasi biaya jelas disepakati di awal sebelum alat bekerja.</span>
                            </div>
                        </div>
                    </div>

                    <div class="pt-2 sm:pt-3 border-t border-slate-100">
                        <a href="{{ $emergencyWaUrl }}" target="_blank" rel="noopener noreferrer" 
                           class="w-full min-h-[44px] flex items-center justify-center gap-2 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs sm:text-sm py-2.5 sm:py-3 px-4 rounded-lg shadow-xs transition-colors btn-press">
                            <svg class="w-4 h-4 fill-current shrink-0" viewBox="0 0 24 24">
                                <path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/>
                            </svg>
                            <span>Hubungi Teknisi Posko Terdekat</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ====================================================================
     2. LAYANAN POPULER DI AREA TERSEBUT (DYNAMIC FROM ADMIN + AUTO-SCROLL CAROUSEL)
==================================================================== -->
@php
    $defaultServices = [
        [
            'name' => 'Kloset & WC Tersumbat',
            'slug' => 'kloset-wc',
            'category' => 'TOILET & KLOSET',
            'short_description' => "Atasi toilet duduk/jongkok tersumbat pembalut atau tisu tanpa mencabut kloset dan tanpa merusak ubin di {$area->district}.",
            'price_starting_from' => 400000,
            'features' => ['Tanpa bongkar kloset', 'APD steril & bebas bau', 'Garansi nota 30 hari'],
        ],
        [
            'name' => 'Wastafel & Kitchen Sink',
            'slug' => 'wastafel-cuci-piring',
            'category' => 'DAPUR & RESIDENSIAL',
            'short_description' => "Pembersihan kerak minyak dan endapan lemak beku pada bak cuci piring rumah atau dapur resto di {$area->district}.",
            'price_starting_from' => 400000,
            'features' => ['Lemak beku rontok 100%', 'Aman untuk pipa sifon PVC', 'Garansi nota 30 hari'],
        ],
        [
            'name' => 'Floor Drain & Got Mandi',
            'slug' => 'floor-drain-kamar-mandi',
            'category' => 'SALURAN LANTAI',
            'short_description' => "Menuntaskan sumbatan rambut dan residu sabun yang memicu luapan air kotor pada saluran pembuangan kamar mandi Anda.",
            'price_starting_from' => 400000,
            'features' => ['Bersihkan gumpalan rambut', 'Hilangkan bau got menguap', 'Garansi nota 30 hari'],
        ],
        [
            'name' => 'Inspeksi CCTV 30M',
            'slug' => 'inspeksi-cctv-30m',
            'category' => 'DIAGNOSTIK DIGITAL',
            'short_description' => "Mendeteksi titik pipa patah, sambungan lepas, atau intrusi akar di bawah cor dengan monitor HD berjarak hingga 30 meter.",
            'price_starting_from' => 400000,
            'features' => ['Jangkauan kabel 30 meter', 'Rekaman visual monitor HD', 'Diagnosa akurat 100%'],
        ],
    ];
    $itemsLayanan = (isset($services) && $services->isNotEmpty()) ? $services : collect($defaultServices);
@endphp
<section id="layanan-area" class="py-12 sm:py-18 bg-white border-b border-slate-200" x-data="mobileCarousel({{ count($itemsLayanan) }}, 4000)">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-3xl mx-auto mb-8 sm:mb-12 reveal-soft">
            <h2 class="text-2xl sm:text-4xl font-extrabold text-slate-900 tracking-tight">
                Layanan Pipa Mampet Area {{ $area->district }}, {{ $area->city }}
            </h2>
            <p class="text-slate-600 text-xs sm:text-base mt-2 leading-relaxed">
                Pengerjaan mekanis di lokasi oleh teknisi tersertifikasi tanpa bongkar keramik dan bergaransi 30 hari kalender.
            </p>
            <!-- Mobile Swipe Hint -->
            <div class="flex md:hidden items-center justify-center gap-1.5 text-xs text-sky-700 font-medium mt-2.5">
                <svg class="w-4 h-4 animate-bounce-x" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                </svg>
                <span>Geser pilihan layanan &bull; Auto-scroll aktif</span>
            </div>
        </div>

        <!-- Carousel on Mobile, Grid on Desktop -->
        <div x-ref="slider"
             @scroll.passive="onScroll()"
             @touchstart="pause()"
             @touchend="resume()"
             @mouseenter="pause()"
             @mouseleave="resume()"
             class="flex md:grid md:grid-cols-2 lg:grid-cols-4 overflow-x-auto md:overflow-visible snap-x snap-mandatory no-scrollbar gap-4 lg:gap-6 pb-4 pt-1 px-4 -mx-4 sm:mx-0 sm:px-0">
            @foreach($itemsLayanan as $catalog)
                @php
                    $isModel = $catalog instanceof \App\Models\Service;
                    $title = $isModel ? $catalog->name : $catalog['name'];
                    $slug = $isModel ? $catalog->slug : $catalog['slug'];
                    $desc = $isModel ? ($catalog->short_description ?: ($catalog->description ?: 'Pelancaran saluran pipa mampet tanpa bongkar keramik.')) : $catalog['short_description'];
                    $price = $isModel ? ($catalog->price_starting_from ?: 400000) : $catalog['price_starting_from'];
                    $features = $isModel ? ($catalog->features ?: ['Tanpa bongkar keramik', 'Teknisi profesional berseragam', 'Garansi nota 30 hari']) : ($catalog['features'] ?? []);
                    
                    // Smart Category Tag
                    $category = 'LAYANAN SPESIALIS';
                    $lowerName = strtolower($title);
                    if (str_contains($lowerName, 'wastafel') || str_contains($lowerName, 'dapur') || str_contains($lowerName, 'sink')) {
                        $category = 'DAPUR & RESIDENSIAL';
                    } elseif (str_contains($lowerName, 'kloset') || str_contains($lowerName, 'wc') || str_contains($lowerName, 'toilet')) {
                        $category = 'TOILET & KLOSET';
                    } elseif (str_contains($lowerName, 'floor drain') || str_contains($lowerName, 'kamar mandi') || str_contains($lowerName, 'got')) {
                        $category = 'SALURAN LANTAI';
                    } elseif (str_contains($lowerName, 'cctv') || str_contains($lowerName, 'kamera')) {
                        $category = 'DIAGNOSTIK DIGITAL';
                    } elseif (!$isModel && isset($catalog['category'])) {
                        $category = strtoupper($catalog['category']);
                    }

                    $waMsg = urlencode("Halo teknisi Drainusantara, saya butuh perbaikan {$title} di area {$area->district}, {$area->city}. Mohon info estimasi biaya dan jadwal.");
                    $itemWaUrl = "https://wa.me/{$whatsappNumber}?text={$waMsg}";
                @endphp
                <div class="w-[84vw] sm:w-[320px] md:w-auto shrink-0 snap-center bg-white rounded-xl border border-slate-200 p-5 sm:p-6 flex flex-col justify-between shadow-2xs hover:shadow-md hover:border-sky-300 transition-all duration-200 group card-lift reveal-soft delay-{{ min($loop->iteration * 60, 240) }}">
                    <div>
                        <div class="w-11 h-11 rounded-lg bg-sky-50 border border-sky-200 text-sky-700 flex items-center justify-center mb-3.5 group-hover:bg-sky-700 group-hover:text-white transition-colors shadow-2xs">
                            @if(str_contains(strtolower($title), 'wastafel') || str_contains(strtolower($title), 'sink'))
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/>
                                </svg>
                            @elseif(str_contains(strtolower($title), 'cctv') || str_contains(strtolower($title), 'kamera'))
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                                </svg>
                            @elseif(str_contains(strtolower($title), 'floor drain') || str_contains(strtolower($title), 'kamar mandi') || str_contains($lowerName, 'got'))
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/>
                                </svg>
                            @else
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                                </svg>
                            @endif
                        </div>
                        <span class="text-[10px] font-bold text-sky-700 bg-sky-50 px-2.5 py-0.5 rounded-md border border-sky-200 block w-fit mb-2">
                            {{ $category }}
                        </span>
                        <h3 class="text-base font-bold text-slate-900 mb-1.5 tracking-tight group-hover:text-sky-700 transition-colors">
                            {{ $title }}
                        </h3>
                        <p class="text-xs text-slate-600 leading-relaxed line-clamp-3">
                            {{ $desc }}
                        </p>
                        @if(!empty($features))
                            <ul class="mt-3.5 pt-3 border-t border-slate-100 space-y-1.5 text-xs text-slate-700 font-medium">
                                @foreach(array_slice($features, 0, 3) as $feature)
                                    <li class="flex items-center gap-2">
                                        <svg class="w-3.5 h-3.5 text-emerald-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                                        </svg>
                                        <span class="truncate">{{ $feature }}</span>
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                    </div>
                    <div class="mt-5 pt-3.5 border-t border-slate-100">
                        <div class="text-[11px] text-slate-500">Estimasi Biaya:</div>
                        <div class="text-base sm:text-lg font-extrabold text-slate-900 mb-2.5 tracking-tight">
                            Mulai Rp {{ number_format($price, 0, ',', '.') }}
                        </div>
                        <a href="{{ $itemWaUrl }}" target="_blank" rel="noopener noreferrer" 
                           class="w-full min-h-[42px] flex items-center justify-center gap-2 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs py-2.5 px-3 rounded-lg shadow-2xs transition-all btn-press">
                            <svg class="w-4 h-4 fill-current shrink-0" viewBox="0 0 24 24">
                                <path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/>
                            </svg>
                            <span>Pesan via WhatsApp</span>
                        </a>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Mobile Carousel Dots Indicator -->
        <div class="flex md:hidden justify-center items-center gap-1.5 mt-3">
            @for($i = 0; $i < count($itemsLayanan); $i++)
                <button type="button" 
                        @click="goTo({{ $i }})"
                        class="h-1.5 rounded-full transition-all duration-300 ease-out cursor-pointer active:scale-75"
                        :class="active === {{ $i }} ? 'w-5 bg-sky-700' : 'w-1.5 bg-slate-300 hover:bg-slate-400'"
                        aria-label="Layanan {{ $i + 1 }}">
                </button>
            @endfor
        </div>
    </div>
</section>

<!-- ====================================================================
     3. EDUKASI KHUSUS AREA (BAHAYA SODA API VS SOLUSI MEKANIS)
==================================================================== -->
<section class="py-14 sm:py-20 bg-slate-50 border-b border-slate-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-10 items-stretch">
            <!-- Left: Warning Alert Card -->
            <div class="lg:col-span-5 reveal-soft stagger-1">
                <div class="h-full rounded-xl bg-red-50/60 border border-red-200 p-7 sm:p-8 flex flex-col justify-between shadow-xs card-lift">
                    <div>
                        <div class="inline-flex items-center gap-2 px-3 py-1 rounded-md bg-red-700 text-white text-xs font-bold mb-4 shadow-2xs">
                            <span>PERINGATAN TEKNIS DRAINASE</span>
                        </div>

                        <h3 class="text-xl font-bold text-slate-900 leading-snug tracking-tight mb-3">
                            Bahaya Fatal Menggunakan Soda Api pada Pipa Tersumbat
                        </h3>

                        <p class="text-sm text-slate-700 leading-relaxed mb-4">
                            Menuangkan soda api atau cairan kimia korosif ke dalam saluran sering kali justru memperparah kerusakan secara permanen:
                        </p>

                        <div class="space-y-3 text-xs text-slate-700">
                            <div class="p-3.5 bg-white rounded-xl border border-red-200 flex items-start gap-3">
                                <svg class="w-4 h-4 text-red-600 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/></svg>
                                <div>
                                    <strong class="text-slate-900 block font-bold mb-0.5">Saponifikasi (Lemak Mengeras Menjadi Batu)</strong>
                                    Lemak dapur yang bereaksi dengan soda api akan mengalami proses saponifikasi dan mengkristal jadi gumpalan sabun padat yang mengunci pipa secara permanen.
                                </div>
                            </div>
                            <div class="p-3.5 bg-white rounded-xl border border-red-200 flex items-start gap-3">
                                <svg class="w-4 h-4 text-red-600 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/></svg>
                                <div>
                                    <strong class="text-slate-900 block font-bold mb-0.5">Panas >90°C Melelehkan Sambungan Paralon</strong>
                                    Hawa panas ekstrem melunakkan paralon PVC dan melelehkan lem sambungan knee di bawah lantai, memicu kebocoran air limbah ke struktur bangunan.
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-6 p-4 rounded-xl bg-white border border-red-200 text-xs text-red-900 leading-relaxed font-medium">
                        <strong>Peringatan Biaya:</strong> Membongkar keramik lantai cor untuk mengganti pipa PVC pecah memerlukan biaya jutaan rupiah.
                    </div>
                </div>
            </div>

            <!-- Right: Solusi Aman Mekanis Drainusantara -->
            <div class="lg:col-span-7 reveal-soft stagger-2">
                <div class="h-full rounded-xl bg-white border border-emerald-500 shadow-sm p-7 sm:p-8 flex flex-col justify-between card-lift">
                    <div>
                        <div class="inline-flex items-center gap-2 px-3 py-1 rounded-md bg-emerald-700 text-white text-xs font-bold mb-4 shadow-2xs">
                            <span>METODE MODERN</span>
                        </div>
                        <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight mb-3">
                            Solusi Mekanis Tanpa Merusak Pipa
                        </h2>
                        <p class="text-slate-600 text-sm sm:text-base leading-relaxed mb-6">
                            Armada Drainusantara hadir dengan unit rooter spiral baja elektrik dan kamera inspeksi yang aman untuk seluruh instalasi pipa bangunan baru maupun lama di wilayah {{ $area->city }}.
                        </p>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3.5">
                            <div class="flex items-start gap-3 p-4 rounded-xl bg-slate-50 border border-slate-200">
                                <div class="w-9 h-9 rounded-lg bg-sky-50 border border-sky-200 text-sky-700 flex items-center justify-center shrink-0">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 12c0-4.418 3.582-8 8-8s8 3.582 8 8c0 3.314-2.686 6-6 6s-6-2.686-6-6c0-2.209 1.791-4 4-4s4 1.791 4 4-1.791 4-4 4"/>
                                    </svg>
                                </div>
                                <div>
                                    <h4 class="font-bold text-slate-900 text-sm">Kabel Spiral Baja Lentur</h4>
                                    <p class="text-xs text-slate-600 mt-0.5">Mengikuti belokan pipa knee tanpa menggores dinding sifon PVC.</p>
                                </div>
                            </div>

                            <div class="flex items-start gap-3 p-4 rounded-xl bg-slate-50 border border-slate-200">
                                <div class="w-9 h-9 rounded-lg bg-sky-50 border border-sky-200 text-sky-700 flex items-center justify-center shrink-0">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                                    </svg>
                                </div>
                                <div>
                                    <h4 class="font-bold text-slate-900 text-sm">Inspeksi Kamera Endoskopik</h4>
                                    <p class="text-xs text-slate-600 mt-0.5">Melihat kondisi dalam pipa secara langsung di monitor HD.</p>
                                </div>
                            </div>

                            <div class="flex items-start gap-3 p-4 rounded-xl bg-slate-50 border border-slate-200">
                                <div class="w-9 h-9 rounded-lg bg-amber-50 border border-amber-200 text-amber-700 flex items-center justify-center shrink-0">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                                    </svg>
                                </div>
                                <div>
                                    <h4 class="font-bold text-slate-900 text-sm">Garansi Resmi 30 Hari</h4>
                                    <p class="text-xs text-slate-600 mt-0.5">Mampet lagi di titik yang sama? Teknisi datang kembali gratis!</p>
                                </div>
                            </div>

                            <div class="flex items-start gap-3 p-4 rounded-xl bg-slate-50 border border-slate-200">
                                <div class="w-9 h-9 rounded-lg bg-emerald-50 border border-emerald-200 text-emerald-700 flex items-center justify-center shrink-0">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                </div>
                                <div>
                                    <h4 class="font-bold text-slate-900 text-sm">Bebas Bahan Kimia</h4>
                                    <p class="text-xs text-slate-600 mt-0.5">Aman bagi anak-anak, hewan peliharaan, dan ramah lingkungan.</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-8 pt-6 border-t border-slate-100 flex flex-col sm:flex-row items-center justify-between gap-4">
                        <div>
                            <span class="text-xs text-slate-500 block">Konsultasi Bebas Kimia:</span>
                            <span class="text-sm font-bold text-slate-900">Konsultasi teknis & estimasi gratis</span>
                        </div>
                        <a href="{{ $emergencyWaUrl }}" target="_blank" rel="noopener noreferrer" 
                           class="min-h-[44px] inline-flex items-center gap-2 bg-emerald-600 hover:bg-emerald-700 text-white text-xs sm:text-sm font-bold px-6 py-3 rounded-xl shadow-xs transition-colors btn-press">
                            <svg class="w-4 h-4 fill-current shrink-0" viewBox="0 0 24 24">
                                <path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/>
                            </svg>
                            <span>Panggil Teknisi Sekarang</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ====================================================================
     4. ALUR LAYANAN PRAKTIS 3 LANGKAH (CAROUSEL ON MOBILE)
==================================================================== -->
<section class="py-12 sm:py-18 bg-white border-b border-slate-200" x-data="mobileCarousel(3, 4000)">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-2xl mx-auto mb-8 sm:mb-12 reveal-soft">
            <h3 class="text-2xl sm:text-4xl font-extrabold text-slate-900 tracking-tight">3 Langkah Praktis Penanganan Saluran</h3>
            <p class="text-slate-600 text-xs sm:text-base mt-2">Alur terstruktur dari konsultasi awal hingga aliran pipa lancar dan terproteksi garansi.</p>
            
            <!-- Mobile Swipe Hint -->
            <div class="flex md:hidden items-center justify-center gap-1.5 text-xs text-sky-700 font-medium mt-2.5">
                <svg class="w-4 h-4 animate-bounce-x" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                </svg>
                <span>Geser untuk langkah berikutnya</span>
            </div>
        </div>

        <div x-ref="slider" 
             @scroll.passive="onScroll()"
             @touchstart="pause()"
             @touchend="resume()"
             @mouseenter="pause()"
             @mouseleave="resume()"
             class="flex md:grid md:grid-cols-3 overflow-x-auto md:overflow-visible snap-x snap-mandatory no-scrollbar gap-4 lg:gap-6 pb-4 pt-1 px-4 -mx-4 sm:mx-0 sm:px-0">
            
            <!-- Step 1 -->
            <div class="w-[82vw] sm:w-[320px] md:w-auto shrink-0 snap-center bg-slate-50 p-6 sm:p-7 rounded-xl border border-slate-200 hover:border-sky-300 hover:shadow-md transition-all text-center space-y-3 card-lift reveal-soft stagger-1">
                <div class="w-12 h-12 rounded-xl bg-sky-50 border border-sky-200 text-sky-700 flex items-center justify-center mx-auto shadow-2xs">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                    </svg>
                </div>
                <h4 class="font-bold text-slate-900 text-base sm:text-lg">Konsultasi via WhatsApp</h4>
                <p class="text-xs sm:text-sm text-slate-600 leading-relaxed">Kirimkan pesan WhatsApp mengenai titik mampet dan lokasi hunian Anda untuk estimasi awal serta kepastian armada.</p>
            </div>

            <!-- Step 2 -->
            <div class="w-[82vw] sm:w-[320px] md:w-auto shrink-0 snap-center bg-slate-50 p-6 sm:p-7 rounded-xl border border-slate-200 hover:border-sky-300 hover:shadow-md transition-all text-center space-y-3 card-lift reveal-soft stagger-2">
                <div class="w-12 h-12 rounded-xl bg-sky-50 border border-sky-200 text-sky-700 flex items-center justify-center mx-auto shadow-2xs">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                    </svg>
                </div>
                <h4 class="font-bold text-slate-900 text-base sm:text-lg">Respon Cepat &amp; Armada Meluncur</h4>
                <p class="text-xs sm:text-sm text-slate-600 leading-relaxed">Admin kami segera mengonfirmasi dan menjadwalkan teknisi terdekat untuk langsung menuju ke lokasi Anda.</p>
            </div>

            <!-- Step 3 -->
            <div class="w-[82vw] sm:w-[320px] md:w-auto shrink-0 snap-center bg-slate-50 p-6 sm:p-7 rounded-xl border border-slate-200 hover:border-sky-300 hover:shadow-md transition-all text-center space-y-3 card-lift reveal-soft stagger-3">
                <div class="w-12 h-12 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-700 flex items-center justify-center mx-auto shadow-2xs">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                    </svg>
                </div>
                <h4 class="font-bold text-slate-900 text-base sm:text-lg">Pengerjaan Tuntas &amp; Bergaransi</h4>
                <p class="text-xs sm:text-sm text-slate-600 leading-relaxed">Pengerjaan selesai tanpa bongkar keramik, aliran air dites bersama, dan dilindungi garansi resmi nota 30 hari.</p>
            </div>
        </div>

        <!-- Mobile Carousel Dots Indicator -->
        <div class="flex md:hidden justify-center items-center gap-1.5 mt-2">
            <button type="button" 
                    @click="goTo(0)"
                    class="h-1.5 rounded-full transition-all duration-300 ease-out cursor-pointer active:scale-75"
                    :class="active === 0 ? 'w-5 bg-sky-700' : 'w-1.5 bg-slate-300 hover:bg-slate-400'"
                    aria-label="Langkah 1">
            </button>
            <button type="button" 
                    @click="goTo(1)"
                    class="h-1.5 rounded-full transition-all duration-300 ease-out cursor-pointer active:scale-75"
                    :class="active === 1 ? 'w-5 bg-sky-700' : 'w-1.5 bg-slate-300 hover:bg-slate-400'"
                    aria-label="Langkah 2">
            </button>
            <button type="button" 
                    @click="goTo(2)"
                    class="h-1.5 rounded-full transition-all duration-300 ease-out cursor-pointer active:scale-75"
                    :class="active === 2 ? 'w-5 bg-sky-700' : 'w-1.5 bg-slate-300 hover:bg-slate-400'"
                    aria-label="Langkah 3">
            </button>
        </div>
    </div>
</section>

<!-- ====================================================================
     5. WILAYAH JANGKAUAN LAINNYA
==================================================================== -->
<section class="py-14 sm:py-20 bg-slate-50 border-b border-slate-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-3xl mx-auto mb-10 reveal-soft">
            <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-white border border-slate-200 text-slate-800 text-xs font-bold rounded-md uppercase tracking-wider mb-2 shadow-2xs">
                POSKO STRATEGIS
            </span>
            <h3 class="text-2xl sm:text-3xl font-extrabold text-slate-900 mt-2 tracking-tight">Area Layanan Drainusantara Lainnya</h3>
            <p class="text-xs sm:text-sm text-slate-600 mt-1">Teknisi kami juga siaga di seluruh wilayah Jabodetabek, Semarang, dan Lampung.</p>
        </div>

        @php
            $currentDistrict = $area->district;
            $currentCitySlug = $cityData['slug'] ?? \Illuminate\Support\Str::slug($area->city);
            $cityName = $cityData['name'] ?? $area->city;
            
            // Neighboring districts in the current city (excluding current district)
            $neighboringDistricts = collect($cityData['districts'] ?? [])
                ->reject(fn($d) => strcasecmp($d, $currentDistrict) === 0);

            // Other cities across all provinces (excluding current city)
            $allProvinces = \App\Services\RegionService::all();
            $otherCities = collect($allProvinces)
                ->flatMap(fn($prov) => $prov['cities'])
                ->reject(fn($c) => ($c['slug'] ?? '') === $currentCitySlug);
        @endphp

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Card 1: Neighboring Districts in the same City -->
            <div class="p-6 rounded-xl bg-white border border-slate-200 shadow-sm card-lift reveal-soft delay-100">
                <div class="flex items-center justify-between mb-4">
                    <div class="flex items-center gap-2">
                        <span class="text-xs font-bold uppercase text-sky-800 bg-sky-50 px-3 py-1 rounded-md border border-sky-200">KECAMATAN SEKITAR</span>
                        <span class="text-xs text-slate-500 font-medium">{{ $cityName }}</span>
                    </div>
                    <span class="text-[11px] text-emerald-700 font-semibold bg-emerald-50 px-2 py-0.5 rounded-md border border-emerald-200">Armada Meluncur</span>
                </div>
                
                @if($neighboringDistricts->isNotEmpty())
                    <div class="flex flex-wrap gap-2 text-xs">
                        @foreach($neighboringDistricts as $neighbor)
                            @php
                                $neighborSlug = \Illuminate\Support\Str::slug($neighbor);
                            @endphp
                            <a href="{{ route('area.detail', ['city' => $currentCitySlug, 'district' => $neighborSlug]) }}" 
                               class="px-3.5 py-2 rounded-lg bg-slate-50 hover:bg-white text-slate-800 hover:text-sky-700 font-semibold border border-slate-200 hover:border-sky-300 hover:shadow-2xs transition-all btn-press flex items-center gap-1.5">
                                <span class="w-1.5 h-1.5 rounded-full bg-slate-300"></span>
                                <span>{{ $neighbor }}</span>
                            </a>
                        @endforeach
                    </div>
                @else
                    <p class="text-xs text-slate-500">Seluruh area kelurahan dan jalan utama di {{ $cityName }} dalam radius posko kami.</p>
                @endif
            </div>

            <!-- Card 2: Other Cities & Posko Armada -->
            <div class="p-6 rounded-xl bg-white border border-slate-200 shadow-sm card-lift reveal-soft delay-200">
                <div class="flex items-center justify-between mb-4">
                    <div class="flex items-center gap-2">
                        <span class="text-xs font-bold uppercase text-sky-800 bg-sky-50 px-3 py-1 rounded-md border border-sky-200">POSKO KOTA LAIN</span>
                        <span class="text-xs text-slate-500 font-medium">Jaringan Armada Siaga</span>
                    </div>
                    <a href="{{ route('area.index') }}" class="text-[11px] text-sky-700 hover:underline font-semibold flex items-center gap-1">
                        <span>Semua Area</span>
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                    </a>
                </div>
                <div class="flex flex-wrap gap-2 text-xs">
                    @foreach($otherCities->take(10) as $otherCity)
                        @php
                            $firstDistrict = $otherCity['districts'][0] ?? null;
                            $targetUrl = $firstDistrict 
                                ? route('area.detail', ['city' => $otherCity['slug'], 'district' => \Illuminate\Support\Str::slug($firstDistrict)])
                                : route('area.city', ['city' => $otherCity['slug']]);
                        @endphp
                        <a href="{{ $targetUrl }}" 
                           class="px-3.5 py-2 rounded-lg bg-slate-50 hover:bg-white text-slate-800 hover:text-sky-700 font-semibold border border-slate-200 hover:border-sky-300 hover:shadow-2xs transition-all btn-press">
                            {{ $otherCity['name'] }}
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ====================================================================
     6. BOTTOM EMERGENCY STICKY CTA (DENSE & WHATSAPP-FOCUSED)
==================================================================== -->
<section class="py-10 sm:py-14 bg-slate-900 text-white text-center border-t border-slate-800 relative overflow-hidden reveal-soft">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 relative reveal-scale delay-100">
        <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-slate-800 border border-slate-700 text-sky-400 text-xs font-bold rounded-md uppercase tracking-wider mb-2.5">
            RESPON CEPAT WILAYAH {{ strtoupper($area->district) }}
        </span>
        <h2 class="text-2xl sm:text-3xl lg:text-4xl font-extrabold tracking-tight">
            Saluran Air di Lokasi Anda Tersumbat Hari Ini?
        </h2>
        <p class="text-slate-400 text-xs sm:text-sm mt-2 max-w-lg mx-auto leading-relaxed">
            Teknisi siaga kami siap menuju titik lokasi Anda di {{ $area->district }}, {{ $area->city }}. 100% tanpa bongkar keramik dan dilindungi garansi resmi 30 hari.
        </p>

        <div class="mt-6 flex flex-col items-center justify-center gap-3">
            <a href="{{ $emergencyWaUrl }}" target="_blank" rel="noopener noreferrer" 
               class="w-full sm:w-auto min-h-[46px] inline-flex items-center justify-center gap-2.5 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-sm sm:text-base px-8 py-3.5 rounded-lg shadow-sm transition-all btn-press">
                <svg class="w-5 h-5 fill-current shrink-0" viewBox="0 0 24 24">
                    <path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/>
                </svg>
                <span>Panggil Teknisi Sekarang</span>
            </a>

            <div class="flex flex-wrap items-center justify-center gap-x-4 gap-y-1 text-slate-400 text-[11px] sm:text-xs">
                <span class="inline-flex items-center gap-1">
                    <svg class="w-3.5 h-3.5 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    Respon Cepat
                </span>
                <span class="inline-flex items-center gap-1">
                    <svg class="w-3.5 h-3.5 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    100% Tanpa Bongkar
                </span>
                <span class="inline-flex items-center gap-1">
                    <svg class="w-3.5 h-3.5 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    Garansi Nota 30 Hari
                </span>
            </div>
        </div>
    </div>
</section>
@endsection
