@extends('layouts.app')

@section('content')
@php
    $whatsappNumber = config('app.whatsapp_number', '6281234567890');
    $emergencyWaMsg = urlencode("Halo teknisi Drainusantara, saya butuh perbaikan saluran mampet di area {$area->district}, {$area->city}. Mohon info biaya dan estimasi kedatangan teknisi ke lokasi saya.");
    $emergencyWaUrl = "https://wa.me/{$whatsappNumber}?text={$emergencyWaMsg}";

    // Hero Background Resolution (Hierarchical Inheritance):
    // Cukup taruh 1 foto provinsi di: public/images/areas/provinces/{province-slug}.webp
    // Halaman kecamatan otomatis mewarisi foto provinsi tersebut.
    // Jika ada kecamatan prioritas yang ingin foto khusus, taruh di: public/images/areas/districts/{city-slug}-{district-slug}.webp
    $customHeroBg = null;
    $districtSlug = \Illuminate\Support\Str::slug($area->district);
    $citySlug = $cityData['slug'] ?? \Illuminate\Support\Str::slug($area->city);
    $provinceSlug = $cityData['province_slug'] ?? null;

    $heroBgImage = $customHeroBg 
        ?: (file_exists(public_path("images/areas/districts/{$citySlug}-{$districtSlug}.webp"))
            ? asset("images/areas/districts/{$citySlug}-{$districtSlug}.webp")
            : (file_exists(public_path("images/areas/districts/{$districtSlug}.webp"))
                ? asset("images/areas/districts/{$districtSlug}.webp")
                : (file_exists(public_path("images/areas/cities/{$citySlug}.webp"))
                    ? asset("images/areas/cities/{$citySlug}.webp")
                    : ($provinceSlug && file_exists(public_path("images/areas/provinces/{$provinceSlug}.webp"))
                        ? asset("images/areas/provinces/{$provinceSlug}.webp")
                        : ($provinceSlug && file_exists(public_path("images/areas/provinces/{$provinceSlug}.jpg"))
                            ? asset("images/areas/provinces/{$provinceSlug}.jpg")
                            : ($area->hero_image ?? null))))));
@endphp

<div class="pb-24 md:pb-0">
    <section class="relative bg-slate-50 border-b border-slate-200 pt-5 pb-10 sm:pt-8 sm:pb-14 lg:pt-12 lg:pb-18 overflow-hidden">
        @if(!empty($heroBgImage))
            <div class="absolute inset-0 z-0 pointer-events-none overflow-hidden" aria-hidden="true">
                <img src="{{ $heroBgImage }}" 
                     alt="Latar Belakang {{ $area->district }}" 
                     loading="eager"
                     decoding="async"
                     class="w-full h-full object-cover object-center opacity-50 md:opacity-65 scale-105 transition-transform duration-700">
                <div class="absolute inset-0 bg-linear-to-r from-slate-50 via-slate-50/85 to-slate-50/30"></div>
                <div class="absolute inset-0 bg-linear-to-t from-slate-50 via-transparent to-slate-50/30"></div>
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

            <nav class="hidden sm:flex items-center gap-2 text-xs text-slate-500 mb-6 font-medium flex-wrap reveal-fade" aria-label="Breadcrumb">
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
                    <div class="inline-flex items-center gap-2 px-3 py-1 bg-white border border-slate-200 rounded-lg text-xs font-semibold text-slate-800 shadow-2xs reveal-fade">
                        <span class="w-2 h-2 rounded-full bg-emerald-600"></span>
                        <span>Posko Wilayah: Kecamatan {{ $area->district }}, {{ $area->city }}</span>
                    </div>

                    <h1 class="text-2xl sm:text-4xl md:text-5xl font-extrabold text-slate-900 tracking-tight leading-snug sm:leading-tight reveal-soft">
                        Jasa Pipa & Saluran Mampet <span class="text-sky-700">{{ $area->district }}, {{ $area->city }}</span>
                    </h1>

                    <p class="text-sm sm:text-base text-slate-600 leading-relaxed max-w-2xl reveal-soft delay-100">
                        Pelancaran wastafel, kloset toilet, dan saluran mampet di area <strong>{{ $area->district }}</strong>. Dikerjakan mekanis tanpa membongkar keramik lantai hunian Anda, tuntas bersih, dan dilindungi garansi resmi 30 hari.
                    </p>

                    <div class="grid grid-cols-3 gap-2 sm:gap-3 pt-1 reveal-soft delay-150">
                        <div class="bg-white p-2.5 sm:p-3.5 rounded-lg border border-slate-200 shadow-2xs flex flex-col sm:flex-row items-center sm:items-center gap-1.5 sm:gap-3 text-center sm:text-left card-lift">
                            <div class="w-8 h-8 sm:w-10 sm:h-10 rounded-md bg-sky-50 border border-sky-200 text-sky-700 flex items-center justify-center shrink-0">
                                <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                            <div class="min-w-0">
                                <div class="text-[10px] sm:text-[11px] text-slate-500 font-medium leading-tight">Respon WA</div>
                                <div class="text-xs sm:text-sm font-extrabold text-emerald-700 truncate">Respon Cepat</div>
                            </div>
                        </div>

                        <div class="bg-white p-2.5 sm:p-3.5 rounded-lg border border-slate-200 shadow-2xs flex flex-col sm:flex-row items-center sm:items-center gap-1.5 sm:gap-3 text-center sm:text-left card-lift">
                            <div class="w-8 h-8 sm:w-10 sm:h-10 rounded-md bg-amber-50 border border-amber-200 text-amber-700 flex items-center justify-center shrink-0">
                                <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                                </svg>
                            </div>
                            <div class="min-w-0">
                                <div class="text-[10px] sm:text-[11px] text-slate-500 font-medium leading-tight">Jaminan</div>
                                <div class="text-xs sm:text-sm font-extrabold text-slate-900 truncate">Garansi 30 Hari</div>
                            </div>
                        </div>

                        <div class="bg-white p-2.5 sm:p-3.5 rounded-lg border border-slate-200 shadow-2xs flex flex-col sm:flex-row items-center sm:items-center gap-1.5 sm:gap-3 text-center sm:text-left card-lift">
                            <div class="w-8 h-8 sm:w-10 sm:h-10 rounded-md bg-emerald-50 border border-emerald-200 text-emerald-700 flex items-center justify-center shrink-0">
                                <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                                </svg>
                            </div>
                            <div class="min-w-0">
                                <div class="text-[10px] sm:text-[11px] text-slate-500 font-medium leading-tight">Metode</div>
                                <div class="text-xs sm:text-sm font-extrabold text-slate-900 truncate">Tanpa Bongkar</div>
                            </div>
                        </div>
                    </div>

                    <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-2.5 sm:gap-3 pt-1 reveal-soft delay-200">
                        <a href="{{ $emergencyWaUrl }}" target="_blank" rel="noopener noreferrer" 
                           class="min-h-12 inline-flex items-center justify-center gap-2.5 bg-emerald-700 hover:bg-emerald-800 text-white font-bold text-sm sm:text-base px-6 py-3 rounded-lg shadow-xs hover:shadow transition-all focus-visible:outline-hidden focus-visible:ring-2 focus-visible:ring-emerald-500 btn-press">
                            <svg class="w-4 h-4 fill-current shrink-0" viewBox="0 0 24 24" aria-hidden="true">
                                <path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/>
                            </svg>
                            <span>Panggil Teknisi Sekarang</span>
                        </a>

                        <a href="#layanan-area" 
                           class="min-h-12 inline-flex items-center justify-center gap-2 bg-white hover:bg-slate-100 text-slate-800 font-bold text-xs sm:text-sm px-5 py-2.5 rounded-lg border border-slate-300 shadow-2xs transition-colors focus-visible:outline-hidden focus-visible:ring-2 focus-visible:ring-sky-600 btn-press">
                            <span>Lihat Layanan Tersedia</span>
                            <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </a>
                    </div>
                </div>

                <div class="hidden lg:block lg:col-span-5 reveal-soft delay-150">
                    <div class="bg-white rounded-xl p-3 sm:p-4 border border-slate-200 shadow-xs space-y-3 card-lift">
                        <div class="relative rounded-lg overflow-hidden aspect-4/3 bg-slate-900 border border-slate-200">
                            <img 
                                src="{{ asset('images/hero-technician.webp') }}" 
                                alt="Teknisi Drainusantara Penanganan Saluran Pipa Mampet di {{ $area->district }}" 
                                width="700" 
                                height="525" 
                                loading="eager"
                                fetchpriority="high"
                                decoding="async"
                                class="w-full h-full object-cover"
                            >
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

    @php
        $defaultServices = [
            [
                'name' => 'Kloset & WC Tersumbat',
                'slug' => 'kloset-wc',
                'category' => 'TOILET & KLOSET',
                'short_description' => "Atasi toilet duduk atau jongkok tersumbat pembalut atau tisu tanpa mencabut kloset dan tanpa merusak keramik di {$area->district}.",
                'price_starting_from' => 400000,
                'features' => ['Tanpa bongkar kloset keramik', 'APD steril dan bebas bau', 'Garansi nota 30 hari'],
                'image' => asset('images/services/kloset-wc-mampet.webp'),
            ],
            [
                'name' => 'Wastafel & Kitchen Sink',
                'slug' => 'wastafel-cuci-piring',
                'category' => 'DAPUR & RESIDENSIAL',
                'short_description' => "Pembersihan kerak minyak dan endapan lemak beku pada bak cuci piring rumah atau dapur resto di {$area->district}.",
                'price_starting_from' => 400000,
                'features' => ['Lemak beku rontok tuntas', 'Aman untuk pipa sifon PVC', 'Garansi nota 30 hari'],
                'image' => asset('images/services/wastafel-cuci-piring-mampet.webp'),
            ],
            [
                'name' => 'Floor Drain & Got Mandi',
                'slug' => 'floor-drain-kamar-mandi',
                'category' => 'SALURAN LANTAI',
                'short_description' => "Menuntaskan sumbatan rambut dan residu sabun yang memicu luapan air kotor pada saluran pembuangan kamar mandi Anda.",
                'price_starting_from' => 400000,
                'features' => ['Bersihkan gumpalan rambut', 'Hilangkan bau got menguap', 'Garansi nota 30 hari'],
                'image' => asset('images/services/floor-drain-kamar-mandi.webp'),
            ],
            [
                'name' => 'Inspeksi CCTV 30M',
                'slug' => 'inspeksi-cctv-30m',
                'category' => 'DIAGNOSTIK DIGITAL',
                'short_description' => "Mendeteksi titik pipa patah, sambungan lepas, atau intrusi akar di bawah cor dengan monitor resolusi tinggi berjarak hingga 30 meter.",
                'price_starting_from' => 400000,
                'features' => ['Jangkauan kabel 30 meter', 'Rekaman visual monitor digital', 'Diagnosa titik akurat'],
                'image' => asset('images/services/inspeksi-kamera-cctv-pipa.webp'),
            ],
        ];
        $itemsLayanan = (isset($services) && $services->isNotEmpty()) ? $services : collect($defaultServices);
    @endphp
    <section id="layanan-area" class="py-12 sm:py-18 bg-white border-b border-slate-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto mb-8 sm:mb-12">
                <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-sky-50 border border-sky-200 text-sky-800 text-xs font-bold rounded-md uppercase tracking-wider mb-2">
                    KATALOG WILAYAH {{ strtoupper($area->district) }}
                </span>
                <h2 class="text-2xl sm:text-4xl font-extrabold text-slate-900 tracking-tight">
                    Layanan Pipa Mampet Area {{ $area->district }}, {{ $area->city }}
                </h2>
                <p class="text-slate-600 text-xs sm:text-base mt-2 leading-relaxed">
                    Pengerjaan mekanis di lokasi oleh teknisi berpengalaman tanpa bongkar keramik lantai dan bergaransi 30 hari kalender.
                </p>
            </div>

            <div class="flex md:grid md:grid-cols-2 lg:grid-cols-4 overflow-x-auto md:overflow-visible snap-x snap-mandatory no-scrollbar gap-4 lg:gap-6 pb-4 pt-1 px-4 -mx-4 sm:mx-0 sm:px-0">
                @foreach($itemsLayanan as $catalog)
                    @php
                        $isModel = $catalog instanceof \App\Models\Service;
                        $title = $isModel ? $catalog->name : $catalog['name'];
                        $slug = $isModel ? $catalog->slug : $catalog['slug'];
                        $desc = $isModel ? ($catalog->short_description ?: ($catalog->description ?: 'Pelancaran saluran pipa mampet tanpa bongkar keramik.')) : $catalog['short_description'];
                        $price = $isModel ? ($catalog->price_starting_from ?: 400000) : $catalog['price_starting_from'];
                        $features = $isModel ? ($catalog->features ?: ['Tanpa bongkar keramik', 'Teknisi profesional ber-APD', 'Garansi nota 30 hari']) : ($catalog['features'] ?? []);
                        
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

                        $rawImage = $isModel ? $catalog->image : ($catalog['image'] ?? null);
                        $imageSrc = $rawImage;
                        if (empty($imageSrc) || str_contains($imageSrc, 'placehold.co') || str_contains($imageSrc, 'unsplash.com')) {
                            if (str_contains($lowerName, 'wastafel') || str_contains($lowerName, 'dapur') || str_contains($lowerName, 'sink')) {
                                $imageSrc = asset('images/services/wastafel-cuci-piring-mampet.webp');
                            } elseif (str_contains($lowerName, 'kloset') || str_contains($lowerName, 'wc') || str_contains($lowerName, 'toilet')) {
                                $imageSrc = asset('images/services/kloset-wc-mampet.webp');
                            } elseif (str_contains($lowerName, 'floor drain') || str_contains($lowerName, 'kamar mandi')) {
                                $imageSrc = asset('images/services/floor-drain-kamar-mandi.webp');
                            } elseif (str_contains($lowerName, 'cctv') || str_contains($lowerName, 'kamera')) {
                                $imageSrc = asset('images/services/inspeksi-kamera-cctv-pipa.webp');
                            } elseif (str_contains($lowerName, 'grease') || str_contains($lowerName, 'lemak') || str_contains($lowerName, 'resto')) {
                                $imageSrc = asset('images/services/kuras-grease-trap-lemak.webp');
                            } elseif (str_contains($lowerName, 'talang') || str_contains($lowerName, 'atap')) {
                                $imageSrc = asset('images/services/talang-rooftop-pipa-atap.webp');
                            } else {
                                $imageSrc = asset('images/services/wastafel-cuci-piring-mampet.webp');
                            }
                        }

                        $waMsg = urlencode("Halo teknisi Drainusantara, saya butuh perbaikan {$title} di area {$area->district}, {$area->city}. Mohon info estimasi biaya dan jadwal.");
                        $itemWaUrl = "https://wa.me/{$whatsappNumber}?text={$waMsg}";
                    @endphp
                    <div class="w-[84vw] sm:w-[320px] md:w-auto shrink-0 snap-center bg-white rounded-lg border border-slate-200 p-4 sm:p-5 flex flex-col justify-between shadow-2xs hover:border-sky-300 transition-all duration-200 group card-lift reveal-soft stagger-{{ ($loop->iteration % 4) + 1 }}">
                        <div>
                            <div class="relative w-full aspect-16/10 rounded-md overflow-hidden bg-slate-100 mb-3.5 border border-slate-100">
                                <img src="{{ $imageSrc }}" 
                                     alt="{{ $title }}" 
                                     width="600"
                                     height="375"
                                     loading="lazy" 
                                     decoding="async"
                                     class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300 ease-out"
                                     onerror="this.onerror=null; this.src='{{ asset('images/services/wastafel-cuci-piring-mampet.webp') }}';">
                            </div>
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
                                            <svg class="w-3.5 h-3.5 text-emerald-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                                            </svg>
                                            <span class="truncate">{{ $feature }}</span>
                                        </li>
                                    @endforeach
                                </ul>
                            @endif
                        </div>
                        <div class="mt-5 pt-3.5 border-t border-slate-100">
                            <div class="text-[11px] text-slate-500 font-medium">Biaya Mulai Dari:</div>
                            <div class="text-base sm:text-lg font-extrabold text-slate-900 mb-2.5 tracking-tight">
                                Mulai Rp {{ number_format($price, 0, ',', '.') }}
                            </div>
                            <a href="{{ $itemWaUrl }}" target="_blank" rel="noopener noreferrer" 
                               class="w-full min-h-11 flex items-center justify-center gap-2 bg-emerald-700 hover:bg-emerald-800 text-white font-bold text-xs py-2.5 px-3 rounded-lg shadow-2xs transition-all">
                                <svg class="w-4 h-4 fill-current shrink-0" viewBox="0 0 24 24" aria-hidden="true">
                                    <path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/>
                                </svg>
                                <span>Pesan via WhatsApp</span>
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <section class="py-12 sm:py-18 bg-white border-b border-slate-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-2xl mx-auto mb-8 sm:mb-12">
                <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-sky-50 border border-sky-200 text-sky-800 text-xs font-bold rounded-md uppercase tracking-wider mb-2">
                    ALUR MUDAH DAN CEPAT
                </span>
                <h3 class="text-2xl sm:text-4xl font-extrabold text-slate-900 tracking-tight">3 Langkah Praktis Penanganan Saluran</h3>
                <p class="text-slate-600 text-xs sm:text-base mt-2">Alur terstruktur dari konsultasi awal hingga aliran pipa lancar dan terproteksi garansi.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-slate-50 p-6 sm:p-7 rounded-xl border border-slate-200 text-center space-y-3 shadow-2xs">
                    <div class="w-12 h-12 rounded-xl bg-sky-50 border border-sky-200 text-sky-700 flex items-center justify-center mx-auto">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                        </svg>
                    </div>
                    <h4 class="font-bold text-slate-900 text-base sm:text-lg">01. Konsultasi via WhatsApp</h4>
                    <p class="text-xs sm:text-sm text-slate-600 leading-relaxed">Kirimkan pesan WhatsApp mengenai titik mampet dan lokasi hunian Anda untuk estimasi awal serta kepastian armada.</p>
                </div>

                <div class="bg-slate-50 p-6 sm:p-7 rounded-xl border border-slate-200 text-center space-y-3 shadow-2xs">
                    <div class="w-12 h-12 rounded-xl bg-sky-50 border border-sky-200 text-sky-700 flex items-center justify-center mx-auto">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                        </svg>
                    </div>
                    <h4 class="font-bold text-slate-900 text-base sm:text-lg">02. Teknisi Cek Lokasi</h4>
                    <p class="text-xs sm:text-sm text-slate-600 leading-relaxed">Teknisi memeriksa titik sumbatan menggunakan mesin rotary mekanis secara presisi tanpa merusak keramik.</p>
                </div>

                <div class="bg-slate-50 p-6 sm:p-7 rounded-xl border border-slate-200 text-center space-y-3 shadow-2xs">
                    <div class="w-12 h-12 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-700 flex items-center justify-center mx-auto">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                        </svg>
                    </div>
                    <h4 class="font-bold text-slate-900 text-base sm:text-lg">03. Air Lancar, Baru Bayar</h4>
                    <p class="text-xs sm:text-sm text-slate-600 leading-relaxed">Aliran air dites bersama di hadapan Anda hingga tuntas, setelah itu nota garansi resmi 30 hari diterbitkan.</p>
                </div>
            </div>
        </div>
    </section>

    <section class="py-14 sm:py-20 bg-slate-50 border-b border-slate-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto mb-10">
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
                
                $neighboringDistricts = collect($cityData['districts'] ?? [])
                    ->reject(fn($d) => strcasecmp($d, $currentDistrict) === 0);

                $allProvinces = \App\Services\RegionService::all();
                $otherCities = collect($allProvinces)
                    ->flatMap(fn($prov) => $prov['cities'])
                    ->reject(fn($c) => ($c['slug'] ?? '') === $currentCitySlug);
            @endphp

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <div class="p-6 rounded-xl bg-white border border-slate-200 shadow-2xs">
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
                                   class="min-h-11 px-3.5 py-2.5 rounded-lg bg-slate-50 hover:bg-sky-50 text-slate-800 hover:text-sky-700 font-semibold border border-slate-200 hover:border-sky-300 transition-all flex items-center gap-1.5 focus-visible:outline-hidden focus-visible:ring-2 focus-visible:ring-sky-600">
                                    <span class="w-1.5 h-1.5 rounded-full bg-slate-300"></span>
                                    <span>{{ $neighbor }}</span>
                                </a>
                            @endforeach
                        </div>
                    @else
                        <p class="text-xs text-slate-500">Seluruh area kelurahan dan jalan utama di {{ $cityName }} dalam radius posko kami.</p>
                    @endif
                </div>

                <div class="p-6 rounded-xl bg-white border border-slate-200 shadow-2xs">
                    <div class="flex items-center justify-between mb-4">
                        <div class="flex items-center gap-2">
                            <span class="text-xs font-bold uppercase text-sky-800 bg-sky-50 px-3 py-1 rounded-md border border-sky-200">POSKO KOTA LAIN</span>
                            <span class="text-xs text-slate-500 font-medium">Jaringan Armada Siaga</span>
                        </div>
                        <a href="{{ route('area.index') }}" class="text-[11px] text-sky-700 hover:underline font-semibold flex items-center gap-1 min-h-11">
                            <span>Semua Area</span>
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
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
                               class="min-h-11 px-3.5 py-2.5 rounded-lg bg-slate-50 hover:bg-sky-50 text-slate-800 hover:text-sky-700 font-semibold border border-slate-200 hover:border-sky-300 transition-all flex items-center focus-visible:outline-hidden focus-visible:ring-2 focus-visible:ring-sky-600">
                                {{ $otherCity['name'] }}
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="py-12 sm:py-16 bg-slate-900 text-white text-center relative overflow-hidden">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 relative">
            <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-slate-800 border border-slate-700 text-sky-400 text-xs font-bold rounded-md uppercase tracking-wider mb-2.5">
                RESPON CEPAT WILAYAH {{ strtoupper($area->district) }}
            </span>
            <h2 class="text-2xl sm:text-3xl lg:text-4xl font-extrabold tracking-tight text-white">
                Saluran Air di Lokasi Anda Tersumbat Hari Ini?
            </h2>
            <p class="text-slate-300 text-xs sm:text-sm mt-2 max-w-lg mx-auto leading-relaxed">
                Teknisi siaga kami siap menuju titik lokasi Anda di {{ $area->district }}, {{ $area->city }}. Penanganan mekanis tanpa bongkar keramik dan dilindungi garansi resmi 30 hari.
            </p>

            <div class="mt-6 flex flex-col items-center justify-center gap-3">
                <a href="{{ $emergencyWaUrl }}" target="_blank" rel="noopener noreferrer" 
                   class="w-full sm:w-auto min-h-12 inline-flex items-center justify-center gap-2.5 bg-emerald-700 hover:bg-emerald-800 text-white font-bold text-sm sm:text-base px-8 py-3.5 rounded-lg shadow-sm transition-all focus-visible:outline-hidden focus-visible:ring-2 focus-visible:ring-emerald-500">
                    <svg class="w-5 h-5 fill-current shrink-0" viewBox="0 0 24 24" aria-hidden="true">
                        <path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/>
                    </svg>
                    <span>Panggil Teknisi Sekarang</span>
                </a>

                <div class="flex flex-wrap items-center justify-center gap-x-4 gap-y-1 text-slate-300 text-[11px] sm:text-xs">
                    <span class="inline-flex items-center gap-1">
                        <svg class="w-3.5 h-3.5 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        Respon Cepat Armada
                    </span>
                    <span class="inline-flex items-center gap-1">
                        <svg class="w-3.5 h-3.5 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        Metode Tanpa Bongkar Keramik
                    </span>
                    <span class="inline-flex items-center gap-1">
                        <svg class="w-3.5 h-3.5 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        Garansi Nota 30 Hari
                    </span>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
