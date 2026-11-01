@extends('layouts.app')

@push('head')
    @php
        $coords = $area->resolved_coordinates;
        $isoRegion = $area->iso_region;
    @endphp
    <meta name="geo.region" content="{{ $isoRegion }}">
    <meta name="geo.placename" content="{{ $cityData['name'] }}, {{ $cityData['province_name'] }}">
    <meta name="geo.position" content="{{ $coords['lat'] }};{{ $coords['lng'] }}">
    <meta name="ICBM" content="{{ $coords['lat'] }}, {{ $coords['lng'] }}">

    <!-- OpenGraph Location Tags -->
    <meta property="og:latitude" content="{{ $coords['lat'] }}">
    <meta property="og:longitude" content="{{ $coords['lng'] }}">
    <meta property="og:locality" content="{{ $cityData['name'] }}">
    <meta property="og:region" content="{{ $cityData['province_name'] }}">
    <meta property="og:country-name" content="Indonesia">
@endpush

@section('content')
@php
    $whatsappNumber = config('app.whatsapp_number') ?: '6285609009009';
    $cta = $area->resolved_cta;
    $startingPriceFormatted = 'Rp ' . number_format($area->resolved_price, 0, ',', '.');
    $cityWaMsg = urlencode($cta['whatsapp_text'] ?: "Halo teknisi Drainusantara, saya butuh layanan darurat pelancaran saluran pipa mampet di area {$cityData['name']}. Mohon info jadwal teknisi terdekat.");
    $cityWaUrl = "https://wa.me/{$whatsappNumber}?text={$cityWaMsg}";

    $customHeroBg = !empty($area->hero_image) ? (filter_var($area->hero_image, FILTER_VALIDATE_URL) ? $area->hero_image : asset($area->hero_image)) : null;
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

    $posko = $area->resolved_posko;
    $advantages = $area->resolved_advantages;
    $comparisons = $area->resolved_comparison;
    $serviceCategories = $area->resolved_service_categories;
@endphp

@push('styles')
<style>
    .no-scrollbar::-webkit-scrollbar { display: none; }
    .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
</style>
@endpush

<div class="area-city-page pb-24 md:pb-0">
    <!-- 1. HERO SECTION -->
    <section class="relative bg-slate-50 border-b border-slate-200 pt-5 pb-8 sm:pt-8 sm:pb-14 lg:pt-12 lg:pb-18 overflow-hidden">
        @if(!empty($heroBgImage))
            <div class="absolute inset-0 z-0 pointer-events-none overflow-hidden" aria-hidden="true">
                <img src="{{ $heroBgImage }}" 
                     alt="Latar Belakang {{ $cityData['name'] }}" 
                     loading="eager"
                     decoding="async"
                     class="w-full h-full object-cover object-center opacity-45 md:opacity-60 scale-105 transition-transform duration-700">
                  <div class="absolute inset-0 bg-linear-to-r from-slate-50/40 via-slate-50/80 to-slate-50/45"></div>
                <div class="absolute inset-0 bg-linear-to-t from-slate-50/40 via-transparent to-slate-50/40"></div>
            </div>
        @endif

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="sm:hidden mb-3">
                <a href="{{ route('area.province', ['province' => $cityData['province_slug']]) }}" 
                   class="inline-flex items-center gap-1.5 text-xs font-semibold text-slate-600 hover:text-sky-700 transition-colors">
                    <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                    </svg>
                    <span>Provinsi {{ $cityData['province_name'] }}</span>
                </a>
            </div>

            <nav class="hidden sm:flex items-center gap-2 text-xs text-slate-500 mb-6 flex-wrap font-medium" aria-label="Breadcrumb">
                <a href="{{ url('/') }}" class="hover:text-sky-700 transition-colors flex items-center gap-1.5">
                    <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                    </svg>
                    <span>Beranda</span>
                </a>
                <span class="text-slate-300">/</span>
                <a href="{{ route('area.index') }}" class="hover:text-sky-700 transition-colors">Area</a>
                <span class="text-slate-300">/</span>
                <a href="{{ route('area.province', ['province' => $cityData['province_slug']]) }}" class="hover:text-sky-700 transition-colors">
                    Provinsi {{ $cityData['province_name'] }}
                </a>
                <span class="text-slate-300">/</span>
                <span class="text-sky-700 font-bold">{{ $cityData['name'] }}</span>
            </nav>

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 lg:gap-10 items-center">
                <div class="lg:col-span-7 space-y-4 sm:space-y-5 text-left">
                    <div class="flex items-center gap-2 flex-wrap">
                        <p class="text-xs font-bold uppercase tracking-wider text-sky-800">
                            Wilayah Layanan: {{ $cityData['name'] }}, {{ $cityData['province_name'] }}
                        </p>
                        
                       
                    </div>

                    <h1 class="text-2xl sm:text-4xl md:text-5xl font-extrabold text-slate-900 tracking-tight leading-snug sm:leading-tight">
                        Jasa Saluran Mampet di <span class="text-sky-700">{{ $cityData['name'] }}</span>
                    </h1>

                    <p class="text-sm sm:text-base text-slate-600 leading-relaxed max-w-2xl">
                        Pelancaran wastafel, kloset toilet, dan saluran mampet di seluruh wilayah <strong>{{ $cityData['name'] }}</strong> ({{ $cityData['province_name'] }}). Dikerjakan mekanis tanpa bongkar keramik, tidak merusak pipa PVC, dan bergaransi resmi 30 hari.
                    </p>

                    <div class="grid grid-cols-3 gap-2 sm:gap-3 pt-1">
                        <div class="bg-white p-2.5 sm:p-3.5 rounded-lg border border-slate-200 shadow-2xs text-center sm:text-left">
                            <div class="text-[10px] sm:text-[11px] text-slate-500 font-medium">Respon Armada</div>
                            <div class="text-xs sm:text-sm font-extrabold text-slate-900">Siaga 24 Jam</div>
                        </div>

                        <div class="bg-white p-2.5 sm:p-3.5 rounded-lg border border-slate-200 shadow-2xs text-center sm:text-left">
                            <div class="text-[10px] sm:text-[11px] text-slate-500 font-medium">Jaminan Tuntas</div>
                            <div class="text-xs sm:text-sm font-extrabold text-slate-900">Garansi 30 Hari</div>
                        </div>

                        <div class="bg-white p-2.5 sm:p-3.5 rounded-lg border border-slate-200 shadow-2xs text-center sm:text-left">
                            <div class="text-[10px] sm:text-[11px] text-slate-500 font-medium">Metode Kerja</div>
                            <div class="text-xs sm:text-sm font-extrabold text-slate-900">100% Anti-Bongkar</div>
                        </div>
                    </div>

                    <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-2.5 sm:gap-3 pt-1">
                        <a href="{{ $cityWaUrl }}" target="_blank" rel="noopener noreferrer" 
                           class="min-h-12 inline-flex items-center justify-center gap-2.5 bg-emerald-700 hover:bg-emerald-800 text-white font-bold text-sm sm:text-base px-6 py-3 rounded-lg shadow-xs hover:shadow transition-all">
                            <svg class="w-4 h-4 fill-current shrink-0" viewBox="0 0 24 24">
                                <path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/>
                            </svg>
                            <span>Panggil Teknisi {{ $cityData['name'] }}</span>
                        </a>

                        <a href="#daftar-kecamatan" 
                           class="min-h-12 inline-flex items-center justify-center gap-2 bg-white hover:bg-slate-100 text-slate-800 font-bold text-xs sm:text-sm px-5 py-2.5 rounded-lg border border-slate-300 shadow-2xs transition-colors">
                            <span>Daftar Area ({{ count($cityData['districts']) }})</span>
                            <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </a>
                    </div>
                </div>

                <div class="hidden lg:block lg:col-span-5">
                    <div class="bg-white rounded-xl p-3 sm:p-4 border border-slate-200 shadow-xs space-y-3">
                        <div class="relative rounded-lg overflow-hidden aspect-4/3 bg-slate-900 border border-slate-200">
                            <img 
                                src="{{ asset('images/drainusantara-jasa-saluran-pipa-mampet-teknisi-profesional.webp') }}" 
                                alt="Armada Teknisi Drainusantara di {{ $cityData['name'] }}" 
                                width="700" 
                                height="525" 
                                loading="eager"
                                fetchpriority="high"
                                decoding="async"
                                class="w-full h-full object-cover"
                            >
                            <div class="absolute bottom-2 left-2 right-2 bg-slate-950/80 backdrop-blur-xs px-3 py-1.5 rounded-md text-white text-[11px] flex items-center justify-between border border-white/10">
                                <span>Posko Utama {{ $cityData['name'] }}</span>
                                <span class="text-sky-300 font-bold">Siaga 24 Jam</span>
                            </div>
                        </div>
                        <div class="px-1 py-0.5 flex items-center justify-between text-xs text-slate-600">
                            <span class="font-medium text-slate-700">Unit Mesin Spiral Ridgid &amp; APD Steril</span>
                            <span class="text-emerald-700 font-bold">Metode Tanpa Bongkar</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- 2. SECTION LAYANAN CAROUSEL KE SAMPING -->
    @php
        $defaultCityServices = [
            [
                'name' => 'Kloset & WC Tersumbat',
                'slug' => 'kloset-wc',
                'category' => 'TOILET & KLOSET',
                'short_description' => "Penanganan kloset duduk atau jongkok tersumbat tanpa bongkar keramik porselen di {$cityData['name']}.",
                'price_starting_from' => $area->resolved_price,
                'image' => asset('images/services/drainusantara-jasa-perbaikan-saluran-kloset-wc-toilet-mampet.webp'),
            ],
            [
                'name' => 'Wastafel & Kitchen Sink',
                'slug' => 'wastafel-cuci-piring',
                'category' => 'DAPUR & RESIDENSIAL',
                'short_description' => "Pembersihan kerak minyak dan endapan lemak beku pada bak cuci piring rumah atau restoran di {$cityData['name']}.",
                'price_starting_from' => $area->resolved_price,
                'image' => asset('images/services/drainusantara-jasa-perbaikan-saluran-wastafel-cuci-piring-mampet.webp'),
            ],
            [
                'name' => 'Floor Drain & Got Mandi',
                'slug' => 'floor-drain-kamar-mandi',
                'category' => 'SALURAN LANTAI',
                'short_description' => "Menuntaskan sumbatan rambut dan residu sabun yang memicu luapan air kotor pada kamar mandi Anda.",
                'price_starting_from' => $area->resolved_price,
                'image' => asset('images/services/drainusantara-jasa-perbaikan-saluran-floor-drain-kamar-mandi-mampet.webp'),
            ],
            [
                'name' => 'Inspeksi CCTV 30M',
                'slug' => 'inspeksi-cctv-30m',
                'category' => 'DIAGNOSTIK DIGITAL',
                'short_description' => "Mendeteksi titik pipa patah, sambungan lepas, atau intrusi akar di bawah cor dengan monitor resolusi tinggi.",
                'price_starting_from' => $area->resolved_price,
                'image' => asset('images/services/drainusantara-jasa-inspeksi-kamera-cctv-saluran-pipa-endoskopi.webp'),
            ],
        ];
        $itemsCityServices = (isset($services) && $services->isNotEmpty()) ? $services : collect($defaultCityServices);
        $serviceChunks = $itemsCityServices->chunk(4);
    @endphp
    <section id="layanan-kota" class="py-12 sm:py-16 bg-white border-b border-slate-200"
             x-data="{
                 activeDesktop: 0,
                 totalDesktop: {{ $serviceChunks->count() }},
                 activeMobile: 0,
                 totalMobile: {{ $itemsCityServices->count() }},
                 isMobile: window.innerWidth < 640,
                 scrollLeft() {
                     if (this.isMobile) {
                         if (this.activeMobile > 0) {
                             this.activeMobile--;
                             this.scrollToMobile(this.activeMobile);
                         }
                     } else {
                         if (this.activeDesktop > 0) {
                             this.activeDesktop--;
                             this.scrollToDesktop(this.activeDesktop);
                         }
                     }
                 },
                 scrollRight() {
                     if (this.isMobile) {
                         if (this.activeMobile < this.totalMobile - 1) {
                             this.activeMobile++;
                             this.scrollToMobile(this.activeMobile);
                         }
                     } else {
                         if (this.activeDesktop < this.totalDesktop - 1) {
                             this.activeDesktop++;
                             this.scrollToDesktop(this.activeDesktop);
                         }
                     }
                 },
                 scrollToDesktop(index) {
                     const container = this.$refs.cityServiceCarousel;
                     if (!container) return;
                     const target = container.children[index];
                     if (target) {
                         target.scrollIntoView({ behavior: 'smooth', block: 'nearest', inline: 'start' });
                     }
                 },
                 scrollToMobile(index) {
                     const container = this.$refs.cityServiceCarouselMobile;
                     if (!container) return;
                     const target = container.children[index];
                     if (target) {
                         target.scrollIntoView({ behavior: 'smooth', block: 'nearest', inline: 'center' });
                     }
                 },
                 onDesktopScroll() {
                     const container = this.$refs.cityServiceCarousel;
                     if (!container) return;
                     const width = container.clientWidth;
                     if (width > 0) {
                         this.activeDesktop = Math.round(container.scrollLeft / width);
                     }
                 },
                 onMobileScroll() {
                     const container = this.$refs.cityServiceCarouselMobile;
                     if (!container) return;
                     const scrollLeft = container.scrollLeft;
                     const first = container.firstElementChild;
                     if (first) {
                         const cardWidth = first.offsetWidth + 14;
                         if (cardWidth > 0) {
                             this.activeMobile = Math.min(this.totalMobile - 1, Math.max(0, Math.round(scrollLeft / cardWidth)));
                         }
                     }
                 }
             }"
             @resize.window.debounce.100ms="isMobile = window.innerWidth < 640">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col sm:flex-row sm:items-end justify-between mb-8 gap-4">
                <div>
                    <p class="text-xs font-bold uppercase tracking-wider text-sky-800 mb-1">
                        KATALOG WILAYAH {{ strtoupper($cityData['name']) }}
                    </p>
                    <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">
                        Layanan Pelancaran Saluran Pipa di {{ $cityData['name'] }}
                    </h2>
                    <p class="text-xs sm:text-sm text-slate-600 mt-1">
                        Pilihan layanan mekanis bergaransi resmi 30 hari. Bebas bongkar lantai semen.
                    </p>
                </div>
                <div class="flex items-center gap-2 self-end sm:self-auto"
                     x-show="(isMobile && totalMobile > 1) || (!isMobile && totalDesktop > 1)">
                    <button type="button" @click="scrollLeft()" 
                            :disabled="isMobile ? activeMobile === 0 : activeDesktop === 0" 
                            aria-label="Geser layanan ke kiri"
                            :class="(isMobile ? activeMobile === 0 : activeDesktop === 0) ? 'opacity-40 cursor-not-allowed' : 'hover:bg-slate-50 cursor-pointer'"
                            class="w-9 h-9 rounded-lg border border-slate-300 bg-white text-slate-700 flex items-center justify-center transition-colors shadow-2xs">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                    </button>
                    <button type="button" @click="scrollRight()" 
                            :disabled="isMobile ? activeMobile >= totalMobile - 1 : activeDesktop >= totalDesktop - 1" 
                            aria-label="Geser layanan ke kanan"
                            :class="(isMobile ? activeMobile >= totalMobile - 1 : activeDesktop >= totalDesktop - 1) ? 'opacity-40 cursor-not-allowed' : 'hover:bg-slate-50 cursor-pointer'"
                            class="w-9 h-9 rounded-lg border border-slate-300 bg-white text-slate-700 flex items-center justify-center transition-colors shadow-2xs">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                    </button>
                </div>
            </div>

            <!-- 1-Row Mobile Carousel (< sm) -->
            <div class="block sm:hidden">
                <div x-ref="cityServiceCarouselMobile"
                     @scroll.debounce.50ms="onMobileScroll()"
                     tabindex="0" role="region" aria-label="Katalog layanan kota 1 baris"
                     class="flex overflow-x-auto snap-x snap-mandatory no-scrollbar pb-3 pt-1 px-4 gap-3.5 -mx-4">
                    @foreach($itemsCityServices as $catalog)
                        <div class="w-[82vw] max-w-[340px] shrink-0 snap-center flex flex-col">
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

                @if($itemsCityServices->count() > 1)
                    <div class="flex items-center justify-between mt-3 px-1 text-xs text-slate-500 font-mono">
                        <div class="flex items-center gap-1.5 text-[11px] text-slate-500 font-sans">
                            <svg class="w-3.5 h-3.5 text-sky-700 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                            <span>Geser untuk layanan lain</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <button type="button" @click="if (activeMobile > 0) { activeMobile--; scrollToMobile(activeMobile); }"
                                    :disabled="activeMobile === 0"
                                    :class="activeMobile === 0 ? 'opacity-40 cursor-not-allowed' : 'hover:bg-slate-100 hover:text-slate-900 cursor-pointer'"
                                    class="p-1.5 rounded-md border border-slate-200 transition-colors"
                                    aria-label="Layanan sebelumnya">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                            </button>
                            <span class="text-slate-600"><strong class="text-slate-900" x-text="activeMobile + 1">1</strong>/{{ $itemsCityServices->count() }}</span>
                            <button type="button" @click="if (activeMobile < totalMobile - 1) { activeMobile++; scrollToMobile(activeMobile); }"
                                    :disabled="activeMobile >= totalMobile - 1"
                                    :class="activeMobile >= totalMobile - 1 ? 'opacity-40 cursor-not-allowed' : 'hover:bg-slate-100 hover:text-slate-900 cursor-pointer'"
                                    class="p-1.5 rounded-md border border-slate-200 transition-colors"
                                    aria-label="Layanan berikutnya">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                            </button>
                        </div>
                    </div>
                @endif
            </div>

            <!-- 2x2 Grid Carousel Container (>= sm) -->
            <div class="hidden sm:block">
                <div x-ref="cityServiceCarousel"
                     @scroll.debounce.50ms="onDesktopScroll()"
                     tabindex="0" role="region" aria-label="Katalog layanan kota bergeser horizontal 2x2"
                     class="flex overflow-x-auto snap-x snap-mandatory no-scrollbar pb-3 pt-1 px-4">
                    @foreach($serviceChunks as $chunk)
                        <div class="w-full shrink-0 snap-start grid grid-cols-2 gap-4 lg:gap-4.5">
                            @foreach($chunk as $catalog)
                                <x-area.service-card 
                                    :catalog="$catalog"
                                    :location-name="$cityData['name']"
                                    :whatsapp-number="$whatsappNumber"
                                    :area-price="$area->resolved_price"
                                    button-text="Pesan via WhatsApp"
                                />
                            @endforeach
                        </div>
                    @endforeach
                </div>

                @if($serviceChunks->count() > 1)
                    <div class="flex items-center justify-center gap-3 mt-5 text-xs text-slate-500 font-mono">
                        <button type="button" @click="if (activeDesktop > 0) { activeDesktop--; scrollToDesktop(activeDesktop); }"
                                :disabled="activeDesktop === 0"
                                :class="activeDesktop === 0 ? 'opacity-40 cursor-not-allowed' : 'hover:bg-slate-100 hover:text-slate-900 cursor-pointer'"
                                class="p-1.5 rounded-md border border-slate-200 transition-colors"
                                aria-label="Halaman sebelumnya">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                        </button>
                        <span>Halaman <strong class="text-slate-900" x-text="activeDesktop + 1">1</strong> dari {{ $serviceChunks->count() }}</span>
                        <button type="button" @click="if (activeDesktop < totalDesktop - 1) { activeDesktop++; scrollToDesktop(activeDesktop); }"
                                :disabled="activeDesktop >= totalDesktop - 1"
                                :class="activeDesktop >= totalDesktop - 1 ? 'opacity-40 cursor-not-allowed' : 'hover:bg-slate-100 hover:text-slate-900 cursor-pointer'"
                                class="p-1.5 rounded-md border border-slate-200 transition-colors"
                                aria-label="Halaman berikutnya">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                        </button>
                    </div>
                @endif
            </div>
        </div>
    </section>

    <!-- 3. SECTION PERALATAN CAROUSEL KE SAMPING -->
    @php
        $defaultEquipments = [
            [
                'name' => 'Mesin Spiral Rotary Ridgid K-6200',
                'badge' => 'PENGHANCUR LEMAK BEKU',
                'short_description' => 'Motor torsi tinggi dengan kabel baja tempered 16mm-20mm yang meliuk fleksibel di dalam pipa PVC hingga 30 meter tanpa memecahkan sambungan fitting.',
                'image' => asset('images/equipments/mesin-spiral-rotary-ridgid-k6200.webp'),
            ],
            [
                'name' => 'Hand Rooter Ridgid K-50 Elektrik',
                'badge' => 'SPESIALIS WASTAFEL & SINK',
                'short_description' => 'Alat rotasi presisi untuk saluran diameter 2 - 3 inci seperti kitchen sink, floor drain kamar mandi, dan pipa talang sempit.',
                'image' => asset('images/equipments/hand-rooter-ridgid-k50.webp'),
            ],
            [
                'name' => 'Kamera Inspeksi CCTV Endoskopi 30M',
                'badge' => 'DIAGNOSTIK DIGITAL',
                'short_description' => 'Kamera water-proof resolusi tinggi dengan lampu LED sorot untuk melihat titik retak, akar pohon, atau pipa melorot di bawah lantai semen.',
                'image' => asset('images/equipments/kamera-inspeksi-cctv-saluran-pipa.webp'),
            ],
            [
                'name' => 'High-Pressure Hydro Jetting Unit',
                'badge' => 'PEMBERSIH TOTAL GOT & LEMAK',
                'short_description' => 'Semburan air bertekanan terarah untuk mengikis kerak minyak restoran dan lumpur got hingga dinding pipa bersih total 100%.',
                'image' => asset('images/equipments/hydro-jetting-high-pressure.webp'),
            ],
        ];
        $itemsEquipment = (isset($equipments) && $equipments->isNotEmpty()) ? $equipments : collect($defaultEquipments);
    @endphp
    <section id="peralatan-kota" class="py-12 sm:py-16 bg-slate-50 border-b border-slate-200"
             x-data="{
                 activeSlide: 0,
                 totalSlides: {{ $itemsEquipment->count() }},
                 scrollLeft() {
                     if (this.activeSlide > 0) {
                         this.activeSlide--;
                         this.scrollToSlide(this.activeSlide);
                     }
                 },
                 scrollRight() {
                     if (this.activeSlide < this.totalSlides - 1) {
                         this.activeSlide++;
                         this.scrollToSlide(this.activeSlide);
                     }
                 },
                 scrollToSlide(index) {
                     const container = this.$refs.toolCarousel;
                     const target = container.children[index];
                     if (target) {
                         target.scrollIntoView({ behavior: 'smooth', block: 'nearest', inline: 'start' });
                     }
                 },
                 onScroll() {
                     const container = this.$refs.toolCarousel;
                     const width = container.clientWidth;
                     if (width > 0) {
                         this.activeSlide = Math.round(container.scrollLeft / width);
                     }
                 }
             }">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col sm:flex-row sm:items-end justify-between mb-8 gap-4">
                <div>
                    <p class="text-xs font-bold uppercase tracking-wider text-sky-800 mb-1">
                        PERALATAN MEKANIS SIAGA {{ strtoupper($cityData['name']) }}
                    </p>
                    <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">
                        Peralatan Pelancar Pipa Standar Internasional
                    </h2>
                    <p class="text-xs sm:text-sm text-slate-600 mt-1">
                        Menuntaskan sumbatan lemak, rambut, dan endapan lumpur tanpa merusak ubin keramik hunian Anda.
                    </p>
                </div>
                <div class="flex items-center gap-2 self-end sm:self-auto">
                    <span class="text-xs font-semibold text-slate-500 mr-1">
                        Alat <span x-text="activeSlide + 1"></span> dari <span x-text="totalSlides"></span>
                    </span>
                    <button type="button" @click="scrollLeft()" :disabled="activeSlide === 0" aria-label="Geser peralatan ke kiri"
                            :class="activeSlide === 0 ? 'opacity-40 cursor-not-allowed' : 'hover:bg-slate-100 cursor-pointer'"
                            class="w-9 h-9 rounded-lg border border-slate-300 bg-white text-slate-700 flex items-center justify-center transition-colors shadow-2xs">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                    </button>
                    <button type="button" @click="scrollRight()" :disabled="activeSlide === totalSlides - 1" aria-label="Geser peralatan ke kanan"
                            :class="activeSlide === totalSlides - 1 ? 'opacity-40 cursor-not-allowed' : 'hover:bg-slate-100 cursor-pointer'"
                            class="w-9 h-9 rounded-lg border border-slate-300 bg-white text-slate-700 flex items-center justify-center transition-colors shadow-2xs">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                    </button>
                </div>
            </div>

            <!-- 1x1 Single-Item Spotlight Carousel Container -->
            <div x-ref="toolCarousel"
                 @scroll.debounce.50ms="onScroll()"
                 tabindex="0" role="region" aria-label="Katalog toolkit bergeser 1x1 horizontal"
                 class="flex overflow-x-auto snap-x snap-mandatory no-scrollbar pb-3 pt-1 px-4">
                @foreach($itemsEquipment as $tool)
                    @php
                        $toolName = is_object($tool) ? $tool->name : $tool['name'];
                        $toolBadge = is_object($tool) ? ($tool->badge ?? 'ALAT STANDAR') : ($tool['badge'] ?? 'ALAT STANDAR');
                        $toolDesc = is_object($tool) ? ($tool->short_description ?: $tool->description) : $tool['short_description'];
                        $toolImage = is_object($tool) ? $tool->image : ($tool['image'] ?? null);
                        if (empty($toolImage) || str_contains($toolImage, 'placehold.co')) {
                            $toolImageSrc = asset('assets/placeholders/service.svg');
                        } else {
                            $toolImageSrc = str_starts_with($toolImage, 'http') ? $toolImage : asset(ltrim($toolImage, '/'));
                        }
                    @endphp
                    <div class="w-full shrink-0 snap-start">
                        <div class="bg-white rounded-xl border border-slate-200 p-5 sm:p-7 md:p-8 shadow-2xs grid grid-cols-1 lg:grid-cols-12 gap-6 lg:gap-8 items-center">
                            <div class="lg:col-span-5">
                                <div class="relative w-full aspect-16/10 lg:aspect-4/3 rounded-lg overflow-hidden bg-slate-900 border border-slate-200 shadow-2xs">
                                    <img src="{{ $toolImageSrc }}" onerror="this.onerror=null; this.src='{{ asset('assets/placeholders/service.svg') }}';"
                                         alt="{{ $toolName }}" 
                                         width="600"
                                         height="450"
                                         loading="lazy" 
                                         decoding="async"
                                         class="w-full h-full object-cover">
                                    <span class="absolute top-2.5 left-2.5 bg-slate-900/85 backdrop-blur-xs text-white text-[10px] sm:text-xs font-bold px-2.5 py-1 rounded border border-white/10 uppercase tracking-wider">
                                        {{ $toolBadge }}
                                    </span>
                                    
                                </div>
                            </div>
                            <div class="lg:col-span-7 flex flex-col justify-between space-y-4">
                                <div>
                                    <div class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded text-[11px] font-bold bg-slate-100 text-slate-800 border border-slate-200 mb-2">
                                        STANDAR ALAT INDUSTRI
                                    </div>
                                    <h3 class="text-xl sm:text-2xl font-extrabold text-slate-900 tracking-tight leading-snug">
                                        {{ $toolName }}
                                    </h3>
                                    <p class="text-xs sm:text-sm text-slate-600 leading-relaxed mt-2.5">
                                        {{ $toolDesc }}
                                    </p>
                                </div>

                                <div class="grid grid-cols-3 gap-2.5 pt-2">
                                    <div class="bg-slate-50 p-2.5 sm:p-3 rounded-lg border border-slate-200 text-center sm:text-left">
                                        <div class="text-[10px] text-slate-500 font-medium">Metode Kerja</div>
                                        <div class="text-xs sm:text-sm font-extrabold text-slate-900">100% Anti-Bongkar</div>
                                    </div>
                                    <div class="bg-slate-50 p-2.5 sm:p-3 rounded-lg border border-slate-200 text-center sm:text-left">
                                        <div class="text-[10px] text-slate-500 font-medium">Keamanan Pipa</div>
                                        <div class="text-xs sm:text-sm font-extrabold text-slate-900">Aman PVC &amp; Cor</div>
                                    </div>
                                    <div class="bg-slate-50 p-2.5 sm:p-3 rounded-lg border border-slate-200 text-center sm:text-left">
                                        <div class="text-[10px] text-slate-500 font-medium">Operasional</div>
                                        <div class="text-xs sm:text-sm font-extrabold text-slate-900">Teknisi Tersertifikasi</div>
                                    </div>
                                </div>

                                <div class="pt-3 border-t border-slate-100 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2.5">
                                    <span class="text-xs text-slate-500">
                                        Unit siaga operasional di wilayah {{ $cityData['name'] }}, {{ $cityData['province_name'] }}.
                                    </span>
                                    <a href="{{ $cityWaUrl }}" target="_blank" rel="noopener noreferrer" 
                                       class="inline-flex items-center justify-center gap-2 bg-emerald-700 hover:bg-emerald-800 text-white font-bold text-xs py-2 px-3.5 rounded-lg shadow-2xs transition-all">
                                        <svg class="w-3.5 h-3.5 fill-current shrink-0" viewBox="0 0 24 24" aria-hidden="true">
                                            <path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/>
                                        </svg>
                                        <span>Konsultasi Alat</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Quick Jump Tabs (Clean, No AI Slop Pills/Dots) -->
            <div class="flex flex-wrap items-center justify-center gap-1.5 sm:gap-2 mt-5">
                @foreach($itemsEquipment as $idx => $tool)
                    @php $tName = is_object($tool) ? $tool->name : $tool['name']; @endphp
                    <button type="button" @click="activeSlide = {{ $idx }}; scrollToSlide({{ $idx }})"
                            class="px-3 py-1.5 rounded-md text-xs font-semibold transition-all cursor-pointer border"
                            :class="activeSlide === {{ $idx }} ? 'bg-slate-900 text-white border-slate-900 shadow-2xs' : 'bg-white text-slate-600 border-slate-200 hover:bg-slate-50'">
                        <span class="hidden sm:inline">{{ Str::limit($tName, 26) }}</span>
                        <span class="sm:hidden">Alat {{ $idx + 1 }}</span>
                    </button>
                @endforeach
            </div>
        </div>
    </section>
        </div>
    </section>

    <!-- 4. SECTION KATEGORI SEKTOR LAYANAN -->
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
                    Dari hunian rumah tinggal, restoran komersial dengan lemak beku, hingga fasilitas industri dan perkantoran.
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

    <!-- 5. SECTION KEUNGGULAN LOKAL -->
    <section id="keunggulan-kota" class="py-12 sm:py-16 bg-slate-50 border-b border-slate-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto mb-10">
                <p class="text-xs font-bold uppercase tracking-wider text-sky-800 mb-1">
                    STANDAR OPERASIONAL WILAYAH
                </p>
                <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">
                    Mengapa Memilih Teknisi Drainusantara di {{ $cityData['name'] }}?
                </h2>
                <p class="text-xs sm:text-sm text-slate-600 mt-1">
                    Jaringan armada terluas, peralatan rotary spiral berdaya puntir tinggi, dan kepastian biaya No Cure No Pay.
                </p>
            </div>

            <div class="flex sm:hidden items-center justify-start gap-1.5 text-xs text-sky-700 font-medium mb-3 px-1" aria-hidden="true">
                <svg class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                <span>Geser keunggulan</span>
            </div>

            <div class="flex sm:grid sm:grid-cols-2 lg:grid-cols-4 overflow-x-auto sm:overflow-visible snap-x snap-mandatory no-scrollbar gap-4 sm:gap-5 pb-3 pt-1 px-4 -mx-4 sm:mx-0 sm:px-0">
                @foreach($advantages as $adv)
                    <div class="w-[78vw] max-w-[280px] sm:w-auto shrink-0 snap-center bg-white rounded-lg border border-slate-200 p-5 space-y-2.5 shadow-2xs flex flex-col justify-between">
                        <div class="w-9 h-9 rounded-md bg-sky-50 border border-sky-200 text-sky-700 flex items-center justify-center font-bold text-sm">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        </div>
                        <h3 class="text-sm font-bold text-slate-900 tracking-tight">{{ $adv['title'] }}</h3>
                        <p class="text-xs text-slate-600 leading-relaxed">{{ $adv['description'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- 6. SECTION BANDINGKAN: TUKANG VS DRAINUSANTARA -->
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
        </div>
    </section>

    <!-- 7. SECTION POSKO ARMADA WILAYAH -->
    <section id="posko-kota" class="py-12 sm:py-16 bg-slate-50 border-b border-slate-200">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-xl border border-slate-200 p-6 sm:p-8 shadow-2xs">
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
                        <div class="inline-flex items-center gap-2 text-xs font-semibold text-slate-700 bg-slate-100 px-3 py-1.5 rounded-md border border-slate-200">
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
    </section>

    <!-- 8. SECTION GALLERY & BLOG -->
    <section id="gallery-blog-kota" class="py-12 sm:py-16 bg-white border-b border-slate-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-12">
            <div>
                <div class="flex items-center justify-between mb-6">
                    <div>
                        <p class="text-xs font-bold uppercase tracking-wider text-sky-800">BUKTI PENANGANAN REAL</p>
                        <h2 class="text-xl sm:text-2xl font-extrabold text-slate-900 tracking-tight">
                            Galeri Pengerjaan di {{ $cityData['name'] }}
                        </h2>
                    </div>
                    <a href="{{ url('/galeri') }}" class="text-xs font-bold text-sky-700 hover:text-sky-900 flex items-center gap-1">
                        <span>Lihat Semua Galeri</span>
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                    </a>
                </div>

                <div class="flex md:hidden items-center justify-start gap-1.5 text-xs text-sky-700 font-medium mb-3 px-1" aria-hidden="true">
                    <svg class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                    <span>Geser galeri</span>
                </div>

                <div class="flex md:grid md:grid-cols-3 overflow-x-auto md:overflow-visible snap-x snap-mandatory no-scrollbar gap-4 md:gap-5 pb-3 pt-1 px-4 -mx-4 md:mx-0 md:px-0">
                    @foreach($galleries as $galleryItem)
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
            </div>

            <div class="pt-8 border-t border-slate-200">
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
                    @foreach($articles as $post)
                        @php
                            $coverImg = !empty($post->image) ? asset($post->image) : asset('assets/placeholders/service.svg');
                        @endphp
                        <div class="w-[82vw] max-w-[340px] md:w-auto shrink-0 snap-center rounded-lg border border-slate-200 overflow-hidden bg-white shadow-2xs hover:border-sky-300 transition-colors flex flex-col justify-between">
                            <div>
                                <div class="relative aspect-16/10 bg-slate-100 overflow-hidden">
                                    <img src="{{ $coverImg }}" alt="{{ $post->title }}" class="w-full h-full object-cover">
                                </div>
                                <div class="p-4 space-y-2">
                                    <div class="flex items-center gap-2 text-[11px] text-slate-500 font-medium">
                                        <span>{{ $post->published_at ? $post->published_at->format('d M Y') : 'Terbaru' }}</span>
                                        <span>•</span>
                                        <span>{{ $post->reading_time ?? 3 }} mnt baca</span>
                                        <span>•</span>
                                        <span>{{ $post->views ?? 0 }} views</span>
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
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    <!-- 9. SECTION DAFTAR AREA & TAG PENDUKUNG (SECTION BAWAH) -->
    <section id="daftar-kecamatan" class="py-12 sm:py-16 bg-slate-50 border-b border-slate-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto mb-8">
                <p class="text-xs font-bold uppercase tracking-wider text-sky-800 mb-1">
                    PILIH KECAMATAN DI {{ strtoupper($cityData['name']) }}
                </p>
                <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">
                    Daftar Area Layanan di {{ $cityData['name'] }}
                </h2>
                <p class="text-xs sm:text-sm text-slate-600 mt-1">
                    Area yang Dilayani di {{ $cityData['name'] }}: Pilih area kecamatan Anda untuk melihat profil posko spesifik, nomor siaga, dan estimasi jarak tempuh armada:
                </p>
            </div>

            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-3 sm:gap-4">
                @foreach($cityData['districts'] as $district)
                    @php
                        $districtSlug = \Illuminate\Support\Str::slug($district);
                        $districtUrl = route('area.detail', ['city' => $cityData['slug'], 'district' => $districtSlug]);
                    @endphp
                    <div class="bg-white rounded-lg border border-slate-200 hover:border-sky-300 hover:shadow-2xs p-3.5 sm:p-4 transition-all flex flex-col justify-between group">
                        <div>
                            <span class="text-[10px] text-slate-500 font-bold uppercase tracking-wider block mb-1">
                                {{ \App\Services\RegionService::districtType($cityData, $district) }}
                            </span>
                            <h3 class="text-sm sm:text-base font-bold text-slate-900 group-hover:text-sky-700 transition-colors tracking-tight leading-snug">
                                <a href="{{ $districtUrl }}" class="hover:underline">
                                    {{ $district }}
                                </a>
                            </h3>
                            <p class="text-[11px] text-slate-500 mt-0.5 line-clamp-1">
                                Area {{ $district }}, {{ $cityData['name'] }}
                            </p>
                        </div>

                        <div class="mt-3 pt-2.5 border-t border-slate-100">
                            <a href="{{ $districtUrl }}" 
                               class="w-full text-xs font-bold text-sky-700 group-hover:text-white bg-sky-50 group-hover:bg-sky-700 border border-sky-200 group-hover:border-sky-700 py-1.5 px-3 rounded-md inline-flex items-center justify-center gap-1.5 transition-all">
                                <span>Lihat Area</span>
                                <svg class="w-3.5 h-3.5 shrink-0 transition-transform group-hover:translate-x-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                </svg>
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- 10. FINAL CLOSING CTA -->
    <section class="py-12 sm:py-16 bg-slate-900 text-white text-center relative overflow-hidden">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 relative">
            <p class="text-xs font-bold uppercase tracking-wider text-sky-400 mb-2">
                RESPON CEPAT WILAYAH {{ strtoupper($cityData['name']) }}
            </p>
            <h2 class="text-2xl sm:text-3xl lg:text-4xl font-extrabold tracking-tight text-white">
                Saluran Pipa Air Anda Sedang Bermasalah Hari Ini?
            </h2>
            <p class="text-slate-300 text-xs sm:text-sm mt-2 max-w-lg mx-auto leading-relaxed">
                Armada siaga teknisi kami di posko {{ $cityData['name'] }} siap meluncur ke alamat Anda. Penanganan mekanis tanpa bongkar keramik, biaya mulai {{ $startingPriceFormatted }}, dan dilindungi garansi 30 hari.
            </p>

            <div class="mt-6 flex flex-col sm:flex-row items-center justify-center gap-3">
                <a href="{{ $cityWaUrl }}" target="_blank" rel="noopener noreferrer" 
                   class="w-full sm:w-auto min-h-12 inline-flex items-center justify-center gap-2.5 bg-emerald-700 hover:bg-emerald-800 text-white font-bold text-sm sm:text-base px-8 py-3.5 rounded-lg shadow-sm transition-all focus-visible:outline-hidden focus-visible:ring-2 focus-visible:ring-emerald-500">
                    <svg class="w-5 h-5 fill-current shrink-0" viewBox="0 0 24 24" aria-hidden="true">
                        <path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/>
                    </svg>
                    <span>Hubungi Teknisi {{ $cityData['name'] }}</span>
                </a>
            </div>
        </div>
    </section>
</div>
@endsection
