@extends('layouts.app')

@section('custom_geo')
    @php
        $coords = $area->resolved_coordinates;
        $isoRegion = $area->iso_region;
        $provinceName = $cityData['province_name'] ?? 'Indonesia';
    @endphp
    <meta name="geo.region" content="{{ $isoRegion }}">
    <meta name="geo.placename" content="{{ $area->district }}, {{ $area->city }}">
    <meta name="geo.position" content="{{ $coords['lat'] }};{{ $coords['lng'] }}">
    <meta name="ICBM" content="{{ $coords['lat'] }}, {{ $coords['lng'] }}">

    <!-- OpenGraph Location Tags -->
    <meta property="og:latitude" content="{{ $coords['lat'] }}">
    <meta property="og:longitude" content="{{ $coords['lng'] }}">
    <meta property="og:locality" content="{{ $area->district }}">
    <meta property="og:region" content="{{ $area->city }}">
    <meta property="og:country-name" content="Indonesia">
@endsection

@section('content')
@php
    $whatsappNumber = config('app.whatsapp_number', '6285609009009');
    $cta = $area->resolved_cta;
    $startingPriceFormatted = 'Rp ' . number_format($area->resolved_price, 0, ',', '.');
    $emergencyWaMsg = urlencode($cta['whatsapp_text']);
    $emergencyWaUrl = "https://wa.me/{$whatsappNumber}?text={$emergencyWaMsg}";

    $customHeroBg = null;
    $districtSlug = \Illuminate\Support\Str::slug($area->district);
    $citySlug = $cityData['slug'] ?? \Illuminate\Support\Str::slug($area->city);
    $provinceSlug = $cityData['province_slug'] ?? null;
    $districtType = \App\Services\RegionService::districtType($cityData ?? [], $area->district);
    $districtLabel = str_starts_with($area->district, $districtType.' ') ? $area->district : $districtType.' '.$area->district;

    $heroBgImage = $resolvedAreaImage ?? $area->resolved_hero_image;
    $presencePhoto = $area->resolved_presence_image;

    $areaFaqs = $area->resolved_faqs;
    $posko = $area->resolved_posko;
    $advantages = $area->resolved_advantages;
    $comparisons = $area->resolved_comparison;
    $serviceCategories = $area->resolved_service_categories;
    $displayGalleries = ($galleries ?? collect())->take(3);
    $analysis = $area->resolved_district_analysis;
    $districtHeroHeadline = $area->cta_headline ?: "Jasa Saluran Pipa Mampet <span class=\"text-sky-700\">{$area->district}</span>, {$area->city} — Tukang Pipa &amp; WC Mampet Terdekat";
@endphp

@push('styles')
<style>
    .area-detail-page .area-hero { background: #f8fafc; border-bottom-color: #cbd5e1; }
    .area-detail-page .area-hero h1 { max-width: 15ch; letter-spacing: -0.045em; }
    .area-detail-page .hero-proof { border-left: 3px solid #0369a1; padding-left: 1rem; }
    .area-detail-page .service-card { border-radius: 0.5rem; }
    .no-scrollbar::-webkit-scrollbar { display: none; }
    .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
</style>
@endpush

<div class="area-detail-page">
    <!-- 1. HERO SECTION KECAMATAN -->
    <section class="relative area-hero bg-slate-50 border-b border-slate-200 pt-5 pb-10 sm:pt-8 sm:pb-14 lg:pt-12 lg:pb-18 overflow-hidden">
        @if(!empty($heroBgImage))
            <div class="absolute inset-0 z-0 pointer-events-none overflow-hidden" aria-hidden="true">
                <img src="{{ $heroBgImage }}" 
                     alt="Latar Belakang {{ $area->district }}" 
                     loading="eager"
                     decoding="async"
                     class="w-full h-full object-cover object-center opacity-45 md:opacity-60 scale-105 transition-transform duration-700">
                <div class="absolute inset-0 bg-linear-to-r from-slate-50/40 via-slate-50/80 to-slate-50/45"></div>
                <div class="absolute inset-0 bg-linear-to-t from-slate-50/40 via-transparent to-slate-50/40"></div>
            </div>
        @endif

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="sm:hidden mb-3">
                <a href="{{ route('area.city', ['city' => $cityData['slug'] ?? \Illuminate\Support\Str::slug($area->city)]) }}" 
                   class="inline-flex items-center gap-1.5 text-xs font-semibold text-slate-600 hover:text-sky-700 transition-colors">
                    <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                    </svg>
                    <span>Area {{ $area->city }}</span>
                </a>
            </div>

            <nav class="hidden sm:flex items-center gap-2 text-xs text-slate-500 mb-6 font-medium flex-wrap" aria-label="Breadcrumb">
                <a href="{{ url('/') }}" class="hover:text-sky-700 transition-colors flex items-center gap-1.5">
                    <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
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
                <span class="text-sky-800 font-bold" aria-current="page">{{ $area->district }}</span>
            </nav>

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-10 items-start">
                <div class="lg:col-span-7 space-y-4 sm:space-y-5 text-left">
                    <div class="flex items-center gap-2 flex-wrap">
                        <p class="text-xs font-bold uppercase tracking-wider text-sky-800">
                            Wilayah Layanan: {{ $districtLabel }}, {{ $area->city }}
                        </p>
                    </div>

                    <h1 class="text-2xl sm:text-4xl md:text-5xl font-extrabold text-slate-900 tracking-tight leading-snug sm:leading-tight">
                        {!! $districtHeroHeadline !!}
                    </h1>

                    <p class="text-sm sm:text-base text-slate-600 leading-relaxed max-w-2xl">
                        Jasa saluran pipa mampet di <strong>{{ $area->district }}, {{ $area->city }}</strong> &amp; tukang pipa tersumbat terdekat. Pelancar wastafel cuci piring, kloset toilet meluap, dan floor drain kamar mandi tanpa bongkar keramik lantai, bebas bahan kimia soda api, dengan garansi resmi 30 hari.
                    </p>

                    <!-- 4-Grid Feature Badges -->
                    <div class="grid grid-cols-2 sm:grid-cols-4 gap-2.5 sm:gap-3 max-w-2xl pt-1">
                        <div class="bg-white p-3 sm:p-3.5 rounded-lg border border-slate-200 shadow-2xs text-center sm:text-left">
                            <div class="text-[10px] sm:text-[11px] text-slate-500 font-medium">Estimasi Biaya</div>
                            <div class="text-xs sm:text-sm font-extrabold text-slate-900">Mulai {{ $startingPriceFormatted }}</div>
                            <div class="text-[9px] sm:text-[10px] text-emerald-700 font-bold mt-0.5 leading-tight">No Cure No Pay</div>
                        </div>

                        <div class="bg-white p-3 sm:p-3.5 rounded-lg border border-slate-200 shadow-2xs text-center sm:text-left">
                            <div class="text-[10px] sm:text-[11px] text-slate-500 font-medium">Respon Armada</div>
                            <div class="text-xs sm:text-sm font-extrabold text-slate-900">Siaga 24 Jam</div>
                        </div>

                        <div class="bg-white p-3 sm:p-3.5 rounded-lg border border-slate-200 shadow-2xs text-center sm:text-left">
                            <div class="text-[10px] sm:text-[11px] text-slate-500 font-medium">Perlindungan</div>
                            <div class="text-xs sm:text-sm font-extrabold text-slate-900">Garansi 30 Hari</div>
                        </div>

                        <div class="bg-white p-3 sm:p-3.5 rounded-lg border border-slate-200 shadow-2xs text-center sm:text-left">
                            <div class="text-[10px] sm:text-[11px] text-slate-500 font-medium">Metode Kerja</div>
                            <div class="text-xs sm:text-sm font-extrabold text-slate-900">Metode Tanpa Bongkar</div>
                        </div>
                    </div>

                    <!-- CTA Buttons -->
                    <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-2.5 sm:gap-3 pt-1 hero-proof">
                        <a href="{{ $emergencyWaUrl }}" target="_blank" rel="noopener noreferrer" 
                           class="min-h-12 inline-flex items-center justify-center gap-2.5 bg-emerald-700 hover:bg-emerald-800 text-white font-bold text-sm sm:text-base px-6 py-3 rounded-lg shadow-xs hover:shadow transition-all focus-visible:outline-hidden focus-visible:ring-2 focus-visible:ring-emerald-500">
                            <svg class="w-4 h-4 fill-current shrink-0" viewBox="0 0 24 24" aria-hidden="true">
                                <path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/>
                            </svg>
                            <span>{{ $cta['button_text'] }}</span>
                        </a>

                        <a href="tel:085609009009" 
                           class="min-h-12 inline-flex items-center justify-center gap-2 bg-slate-900 hover:bg-slate-800 text-white font-bold text-xs sm:text-sm px-5 py-2.5 rounded-lg border border-slate-800 shadow-2xs transition-colors">
                            <svg class="w-4 h-4 text-emerald-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                            </svg>
                            <span>Hotline: 0856-0900-9009</span>
                        </a>

                        <a href="#layanan-kecamatan" 
                           class="min-h-12 inline-flex items-center justify-center gap-2 bg-white hover:bg-slate-100 text-slate-800 font-bold text-xs sm:text-sm px-5 py-2.5 rounded-lg border border-slate-300 shadow-2xs transition-colors">
                            <span>Katalog Layanan</span>
                            <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </a>
                    </div>
                    <p class="text-[11px] text-slate-500 pt-1 flex items-center gap-1.5">
                        <svg class="w-3.5 h-3.5 text-emerald-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                        <span>Konsultasi &amp; Diagnosa Awal Gratis via WhatsApp • Hemat s/d 70% vs Bongkar Lantai</span>
                    </p>
                </div>

                <!-- Right Hero Dispatch Visual Card -->
                <div class="lg:col-span-5">
                    <div class="bg-white rounded-xl p-3 sm:p-4 border border-slate-200 shadow-xs space-y-3">
                        <div class="relative rounded-lg overflow-hidden aspect-4/3 bg-slate-900 border border-slate-200">
                            <img 
                                src="{{ $resolvedAreaImage ?? $area->resolved_hero_image }}" 
                                alt="Teknisi Jasa Saluran Pipa Mampet {{ $area->district }}, {{ $area->city }} Tanpa Bongkar Keramik" 
                                width="700" 
                                height="525" 
                                loading="eager"
                                fetchpriority="high"
                                decoding="async"
                                class="w-full h-full object-cover"
                            >
                            <div class="absolute bottom-2 left-2 right-2 bg-slate-950/80 backdrop-blur-xs px-3 py-1.5 rounded-md text-white text-[11px] flex items-center justify-between border border-white/10">
                                <span>Teknisi Siaga di {{ $area->district }}</span>
                                <span class="text-sky-300 font-bold">Respon Cepat</span>
                            </div>
                        </div>
                        <div class="px-1 py-0.5 flex items-center justify-between text-xs text-slate-600">
                            <span class="font-medium text-slate-700">Mesin Spiral Elektrik &amp; APD Steril</span>
                            <span class="text-sky-700 font-bold">No Cure No Pay</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- 2. SECTION DRAINUSANTARA HADIR DI KECAMATAN (TANPA CTA & HOTLINE) -->
    <section id="kehadiran-lokal-kecamatan" data-section="hadir-kecamatan" class="py-12 lg:py-16 bg-white border-b border-slate-200 overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-12 items-center">
                <!-- Visual Foto Presence -->
                <div class="lg:col-span-5 order-2 lg:order-1">
                    <div class="relative rounded-xl overflow-hidden border border-slate-200 bg-slate-900 shadow-sm aspect-4/3">
                        <img 
                            src="{{ $presencePhoto }}" 
                            alt="Operasional Teknisi Drainusantara Hadir di {{ $area->district }}, {{ $area->city }}"
                            loading="lazy"
                            decoding="async"
                            class="w-full h-full object-cover"
                        >
                        <div class="absolute inset-0 bg-linear-to-t from-slate-950/70 via-transparent to-transparent pointer-events-none"></div>
                        <div class="absolute bottom-3 left-3 right-3 text-white">
                            <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-sky-600 text-white uppercase tracking-wider">
                                Posko Siaga {{ $area->district }}
                            </span>
                            <p class="text-xs font-semibold mt-1 text-slate-200">
                                Armada siap meluncur dengan perlengkapan lengkap ke seluruh kelurahan di {{ $area->district }}.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Copywriting & 3 Poin Kehadiran -->
                <div class="lg:col-span-7 order-1 lg:order-2 space-y-4">
                    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-sky-50 border border-sky-200 text-sky-800 text-xs font-bold uppercase tracking-wider">
                        <span>LAYANAN RESMI TINGKAT KECAMATAN</span>
                    </div>

                    <h2 class="text-2xl sm:text-3xl lg:text-4xl font-extrabold text-slate-900 tracking-tight leading-tight">
                        Drainusantara Hadir di <span class="text-sky-700">{{ $area->district }}</span>, {{ $area->city }}
                    </h2>

                    <p class="text-sm sm:text-base text-slate-600 leading-relaxed">
                        {{ $area->resolved_presence_description }}
                    </p>

                    @php
                        $regProfile = $area->resolved_regional_profile;
                    @endphp
                    <!-- Local Regional Characteristics & Pipe Dynamics -->
                    <div class="p-3.5 sm:p-4 rounded-lg bg-slate-50 border border-slate-200 space-y-2 text-xs">
                        <div class="flex items-center gap-2 text-sky-800 font-bold uppercase tracking-wider text-[11px]">
                            <svg class="w-4 h-4 text-sky-700 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            <span>Analisis Karakteristik Pipa {{ $area->district }} ({{ $regProfile['zone_name'] }})</span>
                        </div>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-2 text-slate-600 pt-0.5">
                            <div>
                                <strong class="text-slate-800 font-semibold block text-[11px]">Tantangan Sumbatan Dominan:</strong>
                                <span class="leading-relaxed">{{ $regProfile['challenges'] }}</span>
                            </div>
                            <div>
                                <strong class="text-slate-800 font-semibold block text-[11px]">Metode Teknis Armada:</strong>
                                <span class="leading-relaxed">{{ $regProfile['technical_solution'] }}</span>
                            </div>
                        </div>
                        @if(!empty($regProfile['prominent_areas']))
                            <div class="pt-1.5 border-t border-slate-200/80 text-[11px] text-slate-500">
                                <span class="font-semibold text-slate-700">Area &amp; Koridor Reaksi Cepat:</span>
                                <span>{{ implode(' • ', $regProfile['prominent_areas']) }}</span>
                            </div>
                        @endif
                    </div>

                    <!-- Hint Geser di Mobile -->
                    <div class="flex sm:hidden items-center justify-start gap-1.5 text-xs text-sky-700 font-medium pt-1" aria-hidden="true">
                        <svg class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                        <span>Geser untuk melihat keunggulan kehadiran kami</span>
                    </div>

                    <!-- 3 Highlight Points (Carousel di Mobile, Grid di Desktop) -->
                    <div class="flex sm:grid sm:grid-cols-3 overflow-x-auto sm:overflow-visible snap-x snap-mandatory no-scrollbar gap-3 pt-2 pb-2 -mx-4 px-4 sm:mx-0 sm:px-0">
                        <div class="w-[78vw] max-w-[280px] sm:w-auto shrink-0 snap-center bg-slate-50 p-3.5 rounded-lg border border-slate-200 space-y-1.5 flex flex-col justify-between">
                            <div>
                                <div class="w-7 h-7 rounded-md bg-sky-100 text-sky-800 flex items-center justify-center font-bold text-xs mb-1.5">
                                    01
                                </div>
                                <h3 class="text-xs font-bold text-slate-900">Posko Siaga Terdekat</h3>
                                <p class="text-[11px] text-slate-600 leading-relaxed">Armada lokal di {{ $area->district }} siaga dengan mobilisasi cepat ke lokasi Anda.</p>
                            </div>
                        </div>

                        <div class="w-[78vw] max-w-[280px] sm:w-auto shrink-0 snap-center bg-slate-50 p-3.5 rounded-lg border border-slate-200 space-y-1.5 flex flex-col justify-between">
                            <div>
                                <div class="w-7 h-7 rounded-md bg-emerald-100 text-emerald-800 flex items-center justify-center font-bold text-xs mb-1.5">
                                    02
                                </div>
                                <h3 class="text-xs font-bold text-slate-900">Spiral Baja Non-Bongkar</h3>
                                <p class="text-[11px] text-slate-600 leading-relaxed">Endapan lemak dan kotoran dirontokkan langsung dari leher pipa tanpa bongkar keramik.</p>
                            </div>
                        </div>

                        <div class="w-[78vw] max-w-[280px] sm:w-auto shrink-0 snap-center bg-slate-50 p-3.5 rounded-lg border border-slate-200 space-y-1.5 flex flex-col justify-between">
                            <div>
                                <div class="w-7 h-7 rounded-md bg-amber-100 text-amber-800 flex items-center justify-center font-bold text-xs mb-1.5">
                                    03
                                </div>
                                <h3 class="text-xs font-bold text-slate-900">Transparan &amp; Garansi</h3>
                                <p class="text-[11px] text-slate-600 leading-relaxed">Sistem No Cure No Pay dilindungi nota garansi resmi 30 hari penuh.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- 2.5 SECTION PROFIL LAYANAN & CAKUPAN LOKAL -->
    <x-area.district-profile-section 
        :location-name="$area->district" 
        :location-title="$area->district . ', ' . $area->city" 
        :analysis="$analysis" 
        :whatsapp-url="$emergencyWaUrl" 
    />

    <!-- 3. SECTION LAYANAN 1 BARIS CAROUSEL -->
    @php
        $defaultServices = [
            [
                'name' => 'Kloset & WC Tersumbat',
                'slug' => 'kloset-wc',
                'category' => 'TOILET & KLOSET',
                'short_description' => "Atasi toilet duduk atau jongkok tersumbat pembalut atau tisu tanpa mencabut kloset dan tanpa merusak keramik di {$area->district}.",
                'price_starting_from' => $area->resolved_price,
                'image' => asset('images/services/drainusantara-jasa-perbaikan-saluran-kloset-wc-toilet-mampet.webp'),
            ],
            [
                'name' => 'Wastafel & Kitchen Sink',
                'slug' => 'wastafel-cuci-piring',
                'category' => 'DAPUR & RESIDENSIAL',
                'short_description' => "Pembersihan kerak minyak dan endapan lemak beku pada bak cuci piring rumah atau dapur resto di {$area->district}.",
                'price_starting_from' => $area->resolved_price,
                'image' => asset('images/services/drainusantara-jasa-perbaikan-saluran-wastafel-cuci-piring-mampet.webp'),
            ],
            [
                'name' => 'Floor Drain & Got Mandi',
                'slug' => 'floor-drain-kamar-mandi',
                'category' => 'SALURAN LANTAI',
                'short_description' => "Menuntaskan sumbatan rambut dan residu sabun yang memicu luapan air kotor pada saluran pembuangan kamar mandi Anda.",
                'price_starting_from' => $area->resolved_price,
                'image' => asset('images/services/drainusantara-jasa-perbaikan-saluran-floor-drain-kamar-mandi-mampet.webp'),
            ],
            [
                'name' => 'Inspeksi CCTV 30M',
                'slug' => 'inspeksi-cctv-30m',
                'category' => 'DIAGNOSTIK DIGITAL',
                'short_description' => "Mendeteksi titik pipa patah, sambungan lepas, atau intrusi akar di bawah cor dengan monitor resolusi tinggi berjarak hingga 30 meter.",
                'price_starting_from' => $area->resolved_price,
                'image' => asset('images/services/drainusantara-jasa-inspeksi-kamera-cctv-saluran-pipa-endoskopi.webp'),
            ],
        ];
        $itemsLayanan = (isset($services) && $services->isNotEmpty()) ? $services : collect($defaultServices);
    @endphp

    <section id="layanan-kecamatan" class="py-12 sm:py-16 bg-white border-b border-slate-200"
             x-data="{
                 active: 0,
                 total: {{ $itemsLayanan->count() }},
                 scrollLeft() {
                     const container = this.$refs.districtServiceCarousel;
                     if (container) {
                         container.scrollBy({ left: -340, behavior: 'smooth' });
                     }
                 },
                 scrollRight() {
                     const container = this.$refs.districtServiceCarousel;
                     if (container) {
                         container.scrollBy({ left: 340, behavior: 'smooth' });
                     }
                 },
                 onScroll() {
                     const container = this.$refs.districtServiceCarousel;
                     if (!container) return;
                     const scrollLeft = container.scrollLeft;
                     const first = container.firstElementChild;
                     const cardWidth = first ? first.offsetWidth + 20 : 340;
                     if (cardWidth > 0) {
                         this.active = Math.min(this.total - 1, Math.max(0, Math.round(scrollLeft / cardWidth)));
                     }
                 }
             }">
        <span id="layanan-area" class="sr-only"></span>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col sm:flex-row sm:items-end justify-between mb-8 gap-4">
                <div>
                    <p class="text-xs font-bold uppercase tracking-wider text-sky-800 mb-1">
                        Katalog Layanan Spesialis Wilayah {{ strtoupper($area->district) }}, {{ strtoupper($area->city) }}
                    </p>
                    <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">
                        Ahli Wastafel &amp; Saluran Kamar Mandi Mampet di {{ $area->district }}, {{ $area->city }} Tanpa Bobok Lantai
                    </h2>
                    <p class="text-xs sm:text-sm text-slate-600 mt-1">
                        Pilihan penanganan mekanis bergaransi resmi untuk warga {{ $area->district }}, {{ $area->city }}. Tuntas tanpa bongkar keramik hunian Anda.
                    </p>
                </div>
                <div class="flex items-center gap-3 self-end sm:self-auto">
                    <span class="text-xs text-slate-500 font-mono hidden sm:inline-block">
                        Layanan <span class="font-bold text-slate-900" x-text="active + 1">1</span> dari {{ $itemsLayanan->count() }}
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
            <div x-ref="districtServiceCarousel"
                 @scroll.debounce.50ms="onScroll()"
                 tabindex="0" role="region" aria-label="Katalog layanan kecamatan 1 baris"
                 class="flex overflow-x-auto snap-x snap-mandatory no-scrollbar pb-4 pt-1 px-4 gap-4 sm:gap-5 -mx-4 sm:mx-0 sm:px-0">
                @foreach($itemsLayanan as $catalog)
                    <div class="w-[84vw] sm:w-[275px] lg:w-[285px] shrink-0 snap-start flex flex-col">
                        <x-area.service-card 
                            :catalog="$catalog"
                            :location-name="$area->district . ', ' . $area->city"
                            :whatsapp-number="$whatsappNumber"
                            :area-price="$area->resolved_price"
                            button-text="Pesan Teknisi"
                        />
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- 4. SECTION PERALATAN 1 BARIS CAROUSEL -->
    <div id="peralatan-area">
        <x-area.equipment-section 
            section-id="peralatan-kecamatan"
            :area-name="$area->district . ', ' . $area->city"
            bg-color="bg-slate-50"
            eyebrow="STANDAR ALAT INDUSTRI SIAGA DI {{ strtoupper($area->district) }}, {{ strtoupper($area->city) }}"
            title="Peralatan Mekanis Siaga di {{ $area->district }}, {{ $area->city }}"
            description="Didukung peralatan standar internasional yang siaga di {{ $area->district }}, {{ $area->city }} untuk menjamin pipa lancar plong tanpa bongkar keramik lantai hunian Anda."
        />
    </div>

    <!-- 5. SECTION STANDAR OPERASIONAL WILAYAH (5 PILAR) -->
    @php
        $advantages = $area->resolved_advantages ?? $advantages;
    @endphp
    <section id="keunggulan-area" data-section="standar-operasional-kecamatan" class="py-14 lg:py-20 bg-white border-b border-slate-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto mb-10">
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-sky-50 border border-sky-200 text-sky-800 text-xs font-bold uppercase tracking-wider mb-2.5">
                    <svg class="w-4 h-4 text-sky-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                    </svg>
                    <span>SOP TEKNISI RESMI</span>
                </div>
                <h2 class="text-2xl sm:text-3xl lg:text-4xl font-extrabold text-slate-900 tracking-tight">
                    Standar Operasional Wilayah {{ $area->district }}, {{ $area->city }}
                </h2>
                <p class="text-xs sm:text-sm md:text-base text-slate-600 mt-2 leading-relaxed">
                    Setiap penanganan saluran pipa mampet di {{ $area->district }}, {{ $area->city }} dijalankan dengan 5 pilar operasional: metode mekanis non-destruktif, transparansi biaya No Cure No Pay, dan garansi tertulis 30 hari.
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
    <section id="sektor-layanan" data-section="sektor-layanan-kecamatan" class="py-12 sm:py-16 bg-slate-50 border-b border-slate-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto mb-10">
                <p class="text-xs font-bold uppercase tracking-wider text-sky-800 mb-1">
                    SEKTOR PENANGANAN DI {{ strtoupper($area->district) }}, {{ strtoupper($area->city) }}
                </p>
                <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">
                    Solusi Pipa untuk Beragam Kategori Bangunan di {{ $area->district }}, {{ $area->city }}
                </h2>
                <p class="text-xs sm:text-sm text-slate-600 mt-1">
                    Dari hunian rumah tinggal, restoran komersial dengan lemak beku, hingga fasilitas industri dan perkantoran di {{ $area->district }}, {{ $area->city }}.
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
                    <div class="w-[82vw] max-w-[340px] md:w-auto shrink-0 snap-center bg-white rounded-lg border border-slate-200 p-5 space-y-3 shadow-2xs hover:border-sky-300 transition-colors flex flex-col justify-between group">
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
                                <span class="text-[11px] text-slate-400 font-semibold uppercase shrink-0">{{ $area->district }}</span>
                            </div>
                            <h3 class="text-base font-bold text-slate-900 tracking-tight leading-snug">
                                {{ $sector['scope'] }}
                            </h3>
                            <div class="mt-3 space-y-2 text-xs">
                                <div class="bg-slate-50 p-2.5 rounded-md border border-slate-200">
                                    <div class="text-[11px] font-bold text-rose-700">Kendala Umum:</div>
                                    <p class="text-slate-600 mt-0.5 leading-relaxed">{{ $sector['problem'] }}</p>
                                </div>
                                <div class="bg-slate-50 p-2.5 rounded-md border border-slate-200">
                                    <div class="text-[11px] font-bold text-emerald-700">Penanganan Teknisi:</div>
                                    <p class="text-slate-600 mt-0.5 leading-relaxed">{{ $sector['solution'] }}</p>
                                </div>
                            </div>
                        </div>

                        <div class="pt-3 border-t border-slate-200/60 mt-3">
                            <a href="{{ $emergencyWaUrl }}" target="_blank" rel="noopener noreferrer"
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

    <!-- 7. SECTION GALERI PENGERJAAN (DIPILIH DARI CMS / DB HASIL PENGERJAAN) -->
    <section id="galeri-kecamatan" data-section="dokumentasi" class="py-14 lg:py-20 bg-white border-b border-slate-200" x-data="{ activeCategory: 'all' }">
        <span id="dokumentasi" class="sr-only"></span>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row items-start md:items-end justify-between gap-4 mb-8 md:mb-12">
                <div>
                    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-sky-50 border border-sky-200 text-sky-800 text-xs font-bold uppercase tracking-wider mb-2">
                        <span>BUKTI RIIL LAPANGAN</span>
                    </div>
                    <h2 class="text-2xl sm:text-3xl lg:text-4xl font-extrabold text-slate-900 tracking-tight">
                        Dokumentasi Pengerjaan di Lapangan {{ $area->district }}, {{ $area->city }}
                    </h2>
                    <p class="text-slate-600 text-xs sm:text-sm mt-1 max-w-2xl leading-relaxed">
                        Hasil Pengerjaan Teknisi di Lapangan: Dokumentasi riil penanganan saluran pipa tersumbat pada sektor hunian residensial dan tempat usaha komersial di {{ $area->district }}, {{ $area->city }} menggunakan mesin rooter spiral elektrik serta inspeksi kamera endoskopi.
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
                        <div class="w-[82vw] max-w-[340px] md:w-auto shrink-0 snap-center rounded-lg border border-slate-200 overflow-hidden bg-slate-50 shadow-2xs hover:border-sky-300 transition-colors flex flex-col justify-between">
                            <div>
                                <div class="relative aspect-16/10 bg-slate-900 overflow-hidden">
                                    <img src="{{ $galleryPhoto }}" 
                                         alt="Dokumentasi Jasa Saluran Pipa Mampet di {{ $area->district }}, {{ $area->city }} - {{ $galleryItem->title }}" 
                                         width="600" 
                                         height="375" 
                                         loading="lazy" 
                                         decoding="async" 
                                         class="w-full h-full object-cover">
                                    @if($hasComparison)
                                        <span class="absolute top-2 left-2 bg-emerald-700 text-white text-[10px] font-bold px-2 py-0.5 rounded shadow-2xs">
                                            Foto Before - After
                                        </span>
                                    @endif
                                </div>
                                <div class="p-4 space-y-2">
                                    <span class="text-[11px] font-bold text-sky-700 uppercase tracking-wider block">
                                        {{ $galleryItem->display_location ?? ($galleryItem->location ?: $area->district . ', ' . $area->city) }}
                                    </span>
                                    <h3 class="text-sm font-bold text-slate-900 tracking-tight line-clamp-1">
                                        {{ $galleryItem->display_title ?? $galleryItem->title }}
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
            @else
                <p class="text-xs text-slate-500 italic py-4 text-center">Dokumentasi hasil pengerjaan lapangan segera diperbarui.</p>
            @endif
        </div>
    </section>

    <!-- 7b. SECTION RATING & ULASAN PELANGGAN LOKAL -->
    <x-area.local-reviews-section 
        :area="$area" 
        :locationName="$area->district . ', ' . $area->city" 
        :reviews="$localReviews ?? []" 
        :whatsappUrl="$emergencyWaUrl" 
    />

    <!-- 8. SECTION KOMPARASI: TUKANG KONVENSIONAL VS DRAINUSANTARA -->
    <section id="perbandingan-area" data-section="perbandingan-kecamatan" class="py-12 sm:py-18 bg-slate-50 border-b border-slate-200">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-2xl mx-auto mb-10">
                <p class="text-xs font-bold uppercase tracking-wider text-sky-800 mb-1">
                    KOMPARASI TRANSPARAN BIAYA &amp; METODE KERJA DI {{ strtoupper($area->district) }}
                </p>
                <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">
                    Tukang Konvensional vs Standar Drainusantara di {{ $area->district }}, {{ $area->city }}
                </h2>
                <p class="text-xs sm:text-sm text-slate-600 mt-1">
                    Ketahui perbedaan mendasar penanganan di {{ $area->district }}, {{ $area->city }} sebelum Anda mengambil risiko pembongkaran lantai atau pipa pecah.
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

    <!-- 9. SECTION ARTIKEL & PANDUAN SALURAN AIR BERSIH -->
    <section id="artikel-kecamatan" class="py-12 sm:py-16 bg-white border-b border-slate-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between mb-8">
                <div>
                    <p class="text-xs font-bold uppercase tracking-wider text-sky-800 mb-1">EDUKASI &amp; PANDUAN PIPA {{ strtoupper($area->district) }}, {{ strtoupper($area->city) }}</p>
                    <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">
                        Artikel &amp; Panduan Saluran Air Bersih untuk Warga {{ $area->district }}, {{ $area->city }}
                    </h2>
                    <p class="text-xs sm:text-sm text-slate-600 mt-1 max-w-2xl">
                        Tips perawatan pipa, mitigasi lemak dapur, dan panduan saluran pembuangan di {{ $area->district }}, {{ $area->city }}.
                    </p>
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
                @forelse($articles as $post)
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
                                <img src="{{ $coverImg }}" 
                                     alt="{{ $post->title }}" 
                                     width="600" 
                                     height="375" 
                                     loading="lazy" 
                                     decoding="async" 
                                     class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
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
                                    <a href="{{ $post->silo_url }}" class="hover:text-sky-700 transition-colors">
                                        {{ $post->title }}
                                    </a>
                                </h3>
                                <p class="text-xs text-slate-600 line-clamp-2 leading-relaxed">
                                    {{ $post->excerpt ?: Str::limit(strip_tags($post->content), 90) }}
                                </p>
                            </div>
                        </div>
                        <div class="p-4 pt-0">
                            <a href="{{ $post->silo_url }}" class="text-xs font-semibold text-sky-700 hover:underline flex items-center gap-1">
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

    <!-- 10. SECTION CAKUPAN REGIONAL DRAINUSANTARA -->
    <x-area.regional-coverage :current-city="$area->city" />

    <!-- 11. SECTION POSKO ARMADA LOKAL & AREA SEKITAR -->
    <section id="posko-armada" class="py-12 sm:py-16 bg-white border-b border-slate-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">
            <div class="text-center max-w-3xl mx-auto mb-4">
                <p class="text-xs font-bold uppercase tracking-wider text-sky-800 mb-1">
                    JANGKAUAN AREA &amp; WILAYAH TERDEKAT
                </p>
                <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">
                    Cakupan Area Sekitar {{ $area->district }}, {{ $area->city }}
                </h2>
                <p class="text-xs sm:text-sm text-slate-600 mt-1">
                    Armada kami tersebar di seluruh titik kelurahan dan jalan utama dengan radius respon cepat.
                </p>
            </div>

            <!-- Box Posko Utama -->
            <div class="bg-slate-50 rounded-xl border border-slate-200 p-6 sm:p-8 shadow-2xs">
                <div class="grid grid-cols-1 md:grid-cols-12 gap-6 items-center">
                    <div class="md:col-span-8 space-y-3">
                        <div class="flex items-center gap-2">
                            <span class="text-xs font-bold uppercase tracking-wider text-sky-800">ARMADA STANDBY AREA LOKAL</span>
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
                        <a href="{{ $emergencyWaUrl }}" target="_blank" rel="noopener noreferrer"
                           class="min-h-11 inline-flex items-center justify-center gap-2 bg-emerald-700 hover:bg-emerald-800 text-white font-bold text-xs sm:text-sm px-5 py-2.5 rounded-lg shadow-2xs transition-all">
                            <svg class="w-4 h-4 fill-current shrink-0" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/></svg>
                            <span>Hubungi Posko Armada</span>
                        </a>
                        <span class="text-[11px] text-slate-500 text-center">Teknisi mobile standby dengan unit mesin</span>
                    </div>
                </div>
            </div>

            @php
                $currentDistrict = $area->district;
                $currentCitySlug = $cityData['slug'] ?? \Illuminate\Support\Str::slug($area->city);
                $cityName = $cityData['name'] ?? $area->city;
                
                $neighboringDistricts = collect($cityData['districts'] ?? [])
                    ->reject(fn($d) => strcasecmp($d, $currentDistrict) === 0);

                $allProvinces = \App\Services\RegionService::all();
                $otherCities = collect($allProvinces)
                    ->flatMap(fn($prov) => $prov['cities'])
                    ->reject(fn($c) => ($c['slug'] ?? '') === $currentCitySlug);

                $customSupportingTags = $area->resolved_supporting_tags;
            @endphp

            <!-- Custom Supporting Tags/Landmarks if any -->
            @if(!empty($customSupportingTags))
                <div class="p-5 rounded-lg bg-slate-50 border border-slate-200 shadow-2xs">
                    <span class="text-xs font-bold uppercase tracking-wider text-sky-800 block mb-3">
                        Titik Strategis &amp; Kelurahan di {{ $area->district }}
                    </span>
                    <div class="flex flex-wrap gap-2 text-xs">
                        @foreach($customSupportingTags as $customTag)
                            <span class="px-3 py-1.5 rounded-md bg-white text-slate-700 border border-slate-200 font-medium">
                                {{ $customTag }}
                            </span>
                        @endforeach
                    </div>
                </div>
            @endif

            @if(!empty($area->content) || !empty($area->postal_code))
                <div id="konten-lokal" class="p-5 sm:p-6 rounded-lg bg-slate-50 border border-slate-200 shadow-2xs">
                    @if(!empty($area->postal_code))
                        <div class="text-xs text-slate-500 mb-2 font-medium">Kode Pos: {{ $area->postal_code }}</div>
                    @endif
                    @if(!empty($area->content))
                        <div class="text-sm text-slate-700 leading-relaxed">
                            {{ $area->content }}
                        </div>
                    @endif
                </div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <div class="p-5 sm:p-6 rounded-lg bg-slate-50 border border-slate-200 shadow-2xs">
                    <div class="flex items-center justify-between mb-4">
                        <span class="text-xs font-bold uppercase tracking-wider text-sky-800">
                            Area Sekitar di {{ $cityName }}
                        </span>
                    </div>
                    
                    @if($neighboringDistricts->isNotEmpty())
                        <div class="flex flex-wrap gap-2 text-xs">
                            @foreach($neighboringDistricts as $neighbor)
                                @php
                                    $neighborSlug = \Illuminate\Support\Str::slug($neighbor);
                                @endphp
                                <a href="{{ route('area.detail', ['city' => $currentCitySlug, 'district' => $neighborSlug]) }}" 
                                   title="Tukang Saluran Pipa Mampet {{ $neighbor }}"
                                   class="px-3 py-2 rounded-md bg-white hover:bg-sky-50 text-slate-800 hover:text-sky-700 font-semibold border border-slate-200 hover:border-sky-300 transition-all flex items-center gap-1.5">
                                    <span>{{ $neighbor }}</span>
                                </a>
                            @endforeach
                        </div>
                    @else
                        <p class="text-xs text-slate-500">Seluruh area kelurahan dan jalan utama di {{ $cityName }} dalam radius posko kami.</p>
                    @endif
                </div>

                <div class="p-5 sm:p-6 rounded-lg bg-slate-50 border border-slate-200 shadow-2xs">
                    <div class="flex items-center justify-between mb-4">
                        <span class="text-xs font-bold uppercase tracking-wider text-sky-800">POSKO KOTA LAIN</span>
                        <a href="{{ route('area.index') }}" class="text-[11px] text-sky-700 hover:underline font-semibold flex items-center gap-1">
                            <span>Semua Area</span>
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
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
                               title="Jasa Saluran Pipa Mampet {{ $otherCity['name'] }}"
                               class="px-3 py-2 rounded-md bg-white hover:bg-sky-50 text-slate-800 hover:text-sky-700 font-semibold border border-slate-200 hover:border-sky-300 transition-all flex items-center">
                                {{ $otherCity['name'] }}
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- 12. SECTION FAQ DINAMIS -->
    @if(!empty($areaFaqs) && count($areaFaqs) > 0)
    <section id="faq-kecamatan" class="py-12 sm:py-16 bg-slate-50 border-b border-slate-200">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-2xl mx-auto mb-8">
                <p class="text-xs font-bold uppercase tracking-wider text-sky-800 mb-1">
                    TANYA JAWAB OPERASIONAL
                </p>
                <h3 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">
                    Pertanyaan Seputar Layanan di {{ $area->district }}, {{ $area->city }}
                </h3>
                <p class="text-xs sm:text-sm text-slate-600 mt-1 max-w-2xl mx-auto">
                    Konsultasi teknis, respon armada, dan garansi resmi pembersihan pipa tanpa bongkar di {{ $area->district }}, {{ $area->city }}.
                </p>
            </div>

            <div x-data="{ active: null }" class="space-y-3">
                @foreach($areaFaqs as $idx => $faq)
                    <div class="bg-white rounded-lg border border-slate-200 overflow-hidden shadow-2xs hover:border-sky-300 transition-colors">
                        <button type="button" 
                                @click="active = (active === {{ $idx }} ? null : {{ $idx }})"
                                class="w-full flex items-center justify-between p-4 text-left font-bold text-slate-900 hover:text-sky-700 transition-colors cursor-pointer">
                            <div class="flex items-center gap-3 pr-4">
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
                        <div x-show="active === {{ $idx }}" x-cloak class="px-4 pb-4 text-xs sm:text-sm text-slate-600 leading-relaxed border-t border-slate-100 pt-3 pl-12 sm:pl-13">
                            <p>{{ $faq['answer'] }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    <!-- 13. FINAL CLOSING CTA -->
    <section id="kontak-kecamatan" class="pt-12 pb-10 sm:pt-16 sm:pb-14 bg-slate-900 text-white text-center relative overflow-hidden">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 relative">
            <p class="text-xs font-bold uppercase tracking-wider text-sky-400 mb-2">
                RESPON CEPAT WILAYAH {{ strtoupper($area->district) }}
            </p>
            <h2 class="text-2xl sm:text-3xl lg:text-4xl font-extrabold tracking-tight text-white">
                {{ $cta['headline'] }}
            </h2>
            <p class="text-slate-300 text-xs sm:text-sm mt-2 max-w-lg mx-auto leading-relaxed">
                Teknisi siaga kami siap meluncur ke titik lokasi Anda di {{ $area->district }}, {{ $area->city }}. Penanganan mekanis tanpa bongkar keramik, estimasi mulai {{ $startingPriceFormatted }} (No Cure No Pay), konsultasi gratis via WhatsApp, dan dilindungi garansi 30 hari.
            </p>

            <div class="mt-6 sm:mt-8 flex flex-col sm:flex-row items-stretch sm:items-center justify-center gap-3 sm:gap-4 max-w-md sm:max-w-none mx-auto">
                <a href="{{ $emergencyWaUrl }}" target="_blank" rel="noopener noreferrer" 
                   class="w-full sm:w-auto min-h-12 inline-flex items-center justify-center gap-2.5 bg-emerald-700 hover:bg-emerald-800 text-white font-bold text-sm sm:text-base px-8 py-3.5 rounded-lg shadow-sm transition-all focus-visible:outline-hidden focus-visible:ring-2 focus-visible:ring-emerald-500">
                    <svg class="w-5 h-5 fill-current shrink-0" viewBox="0 0 24 24" aria-hidden="true">
                        <path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/>
                    </svg>
                    <span>{{ $cta['button_text'] }}</span>
                </a>

                <a href="tel:085609009009" 
                   class="w-full sm:w-auto min-h-12 inline-flex items-center justify-center gap-2 bg-slate-800 hover:bg-slate-700 text-white font-bold text-xs sm:text-sm px-6 py-3.5 rounded-lg border border-slate-700 shadow-2xs transition-colors">
                    <svg class="w-4 h-4 text-emerald-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                    </svg>
                    <span>Hotline: 0856-0900-9009</span>
                </a>
            </div>
        </div>
    </section>
</div>
@endsection
