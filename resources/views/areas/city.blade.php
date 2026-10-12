@extends('layouts.app')

@section('content')
@php
    $whatsappNumber = config('app.whatsapp_number') ?: '6285609009009';
    $cityWaMsg = urlencode("Halo teknisi Drainusantara, saya butuh layanan darurat pelancaran saluran pipa mampet di area {$cityData['name']}. Mohon info estimasi kedatangan teknisi terdekat.");
    $cityWaUrl = "https://wa.me/{$whatsappNumber}?text={$cityWaMsg}";

    // Hero Background Resolution (Hierarchical Inheritance):
    // Cukup taruh 1 foto provinsi di: public/images/areas/provinces/{province-slug}.webp
    // Halaman kota otomatis mewarisi foto provinsi tersebut jika tidak ada foto khusus kota.
    $customHeroBg = null;
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

<section class="relative bg-slate-50 border-b border-slate-200 pt-5 pb-8 sm:pt-8 sm:pb-14 lg:pt-12 lg:pb-18 overflow-hidden">
    @if(!empty($heroBgImage))
        <div class="absolute inset-0 z-0 pointer-events-none overflow-hidden" aria-hidden="true">
            <img src="{{ $heroBgImage }}" 
                 alt="Latar Belakang {{ $cityData['name'] }}" 
                 loading="eager"
                 decoding="async"
                 class="w-full h-full object-cover object-center opacity-55 md:opacity-70 scale-105 transition-transform duration-700">
            <div class="absolute inset-0 bg-linear-to-r from-slate-50 via-slate-50/85 to-slate-50/25"></div>
            <div class="absolute inset-0 bg-linear-to-t from-slate-50 via-transparent to-slate-50/30"></div>
        </div>
    @endif

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="sm:hidden mb-3 reveal-fade">
            <a href="{{ route('area.province', ['province' => $cityData['province_slug']]) }}" 
               class="inline-flex items-center gap-1.5 text-xs font-semibold text-slate-600 hover:text-sky-700 transition-colors">
                <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
                <span>Provinsi {{ $cityData['province_name'] }}</span>
            </a>
        </div>

        <nav class="hidden sm:flex items-center gap-2 text-xs text-slate-500 mb-6 flex-wrap font-medium reveal-fade" aria-label="Breadcrumb">
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
                <div class="inline-flex items-center gap-2 px-3 py-1.5 bg-white border border-slate-200 rounded-lg text-xs font-semibold text-slate-800 shadow-2xs reveal-fade">
                    <span class="w-2 h-2 rounded-full bg-emerald-600"></span>
                    <span class="sm:hidden">Wilayah {{ $cityData['name'] }} &bull; Respon Cepat</span>
                    <span class="hidden sm:inline">Wilayah {{ $cityData['name'] }} &bull; Respon Chat WhatsApp Cepat</span>
                </div>

                <h1 class="text-2xl sm:text-4xl md:text-5xl font-extrabold text-slate-900 tracking-tight leading-snug sm:leading-tight reveal-soft">
                    Jasa Saluran Mampet di <span class="text-sky-700">{{ $cityData['name'] }}</span>
                </h1>

                <p class="text-sm sm:text-base text-slate-600 leading-relaxed max-w-2xl reveal-soft delay-100">
                    Pelancaran wastafel, kloset toilet, dan saluran mampet di seluruh area <strong>{{ $cityData['name'] }}</strong> ({{ $cityData['province_name'] }}). Dikerjakan mekanis tanpa bongkar dan bergaransi 30 hari.
                </p>

                <div class="grid grid-cols-3 gap-2 sm:gap-3 pt-1 reveal-soft delay-150">
                    <div class="bg-white p-2.5 sm:p-3.5 rounded-lg border border-slate-200 shadow-2xs flex flex-col sm:flex-row items-center sm:items-center gap-1.5 sm:gap-3 text-center sm:text-left card-lift">
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

                    <div class="bg-white p-2.5 sm:p-3.5 rounded-lg border border-slate-200 shadow-2xs flex flex-col sm:flex-row items-center sm:items-center gap-1.5 sm:gap-3 text-center sm:text-left card-lift">
                        <div class="w-8 h-8 sm:w-10 sm:h-10 rounded-md bg-amber-50 border border-amber-200 text-amber-700 flex items-center justify-center shrink-0">
                            <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                            </svg>
                        </div>
                        <div class="min-w-0">
                            <div class="text-[10px] sm:text-[11px] text-slate-500 font-medium leading-tight">Garansi</div>
                            <div class="text-xs sm:text-sm font-extrabold text-slate-900 truncate">Garansi 30 Hari</div>
                        </div>
                    </div>

                    <div class="bg-white p-2.5 sm:p-3.5 rounded-lg border border-slate-200 shadow-2xs flex flex-col sm:flex-row items-center sm:items-center gap-1.5 sm:gap-3 text-center sm:text-left card-lift">
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

                <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-2.5 sm:gap-3 pt-1 reveal-soft delay-200">
                    <a href="{{ $cityWaUrl }}" target="_blank" rel="noopener noreferrer" 
                       class="min-h-12 inline-flex items-center justify-center gap-2.5 bg-emerald-700 hover:bg-emerald-800 text-white font-bold text-sm sm:text-base px-6 py-3 rounded-lg shadow-sm hover:shadow transition-all btn-press">
                        <svg class="w-4 h-4 fill-current shrink-0" viewBox="0 0 24 24">
                            <path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/>
                        </svg>
                        <span>Panggil Teknisi {{ $cityData['name'] }}</span>
                    </a>

                    <a href="#daftar-kecamatan" 
                       class="min-h-11 inline-flex items-center justify-center gap-2 bg-white hover:bg-slate-50 text-slate-800 font-bold text-xs sm:text-sm px-5 py-2.5 rounded-lg border border-slate-200 shadow-2xs transition-colors btn-press">
                        <span>Pilih Area ({{ count($cityData['districts']) }})</span>
                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </a>
                </div>
            </div>

            <div class="hidden lg:block lg:col-span-5 reveal-soft delay-150">
                <div class="bg-white rounded-xl p-3 sm:p-4 border border-slate-200 shadow-xs space-y-3 card-lift">
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

<section id="daftar-kecamatan" class="py-14 lg:py-20 bg-white border-b border-slate-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="max-w-2xl mb-10 reveal-soft">
            <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-sky-50 border border-sky-200 text-sky-800 text-xs font-bold rounded-md uppercase tracking-wider mb-2">
                DAFTAR AREA LAYANAN
            </span>
            <h2 class="text-3xl sm:text-4xl font-extrabold text-slate-900 tracking-tight">
                Area yang Dilayani di {{ $cityData['name'] }}
            </h2>
            <p class="text-slate-600 text-sm sm:text-base mt-2 leading-relaxed">
                Pilih area Anda untuk melihat detail layanan lokal, estimasi respon cepat teknisi, dan pemesanan WhatsApp darurat:
            </p>
        </div>

        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-3 sm:gap-4">
            @foreach($cityData['districts'] as $district)
                @php
                    $districtSlug = \Illuminate\Support\Str::slug($district);
                    $districtUrl = route('area.detail', ['city' => $cityData['slug'], 'district' => $districtSlug]);
                @endphp
                <div class="bg-slate-50 hover:bg-white rounded-xl border border-slate-200 hover:border-sky-300 hover:shadow-sm p-3 sm:p-4.5 transition-all flex flex-col justify-between group card-lift reveal-soft stagger-{{ ($loop->iteration % 4) + 1 }}">
                    <div>
                        <span class="text-[10px] sm:text-[11px] text-slate-600 font-bold uppercase tracking-wider block mb-1">{{ \App\Services\RegionService::districtType($cityData, $district) }}</span>
                        <h3 class="text-sm sm:text-base font-bold text-slate-900 group-hover:text-sky-700 transition-colors tracking-tight leading-snug">
                            <a href="{{ $districtUrl }}" class="hover:underline">
                                {{ $district }}
                            </a>
                        </h3>
                        <p class="text-[11px] sm:text-xs text-slate-500 mt-0.5 line-clamp-1">
                            Area {{ $district }}, {{ $cityData['name'] }}
                        </p>
                    </div>

                    <div class="mt-3.5 pt-2.5 border-t border-slate-200">
                        <a href="{{ $districtUrl }}" 
                           class="w-full min-h-9 text-[11px] sm:text-xs font-bold text-sky-700 group-hover:text-white bg-sky-50 group-hover:bg-sky-700 border border-sky-200 group-hover:border-sky-700 py-1.5 px-3 rounded-lg inline-flex items-center justify-center gap-1.5 transition-all btn-press">
                            <span>Detail Area</span>
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

@php
    $defaultCityServices = [
        [
            'name' => 'Bak Cuci Piring Tersumbat',
            'slug' => 'wastafel-cuci-piring',
            'category' => 'DAPUR & RESIDENSIAL',
            'desc' => 'Pembersihan pipa wastafel tersumbat minyak beku menggunakan spiral baja elektrik tanpa merusak sifon PVC.',
            'price' => 400000,
            'features' => ['Tanpa bongkar sifon PVC', 'Kerak lemak rontok tuntas', 'Garansi nota 30 hari'],
        ],
        [
            'name' => 'Kloset & Toilet Meluap',
            'slug' => 'kloset-wc',
            'category' => 'TOILET & KLOSET',
            'desc' => 'Penanganan kloset duduk/jongkok tersumbat pembalut atau tisu tanpa membongkar porselen keramik.',
            'price' => 400000,
            'features' => ['100% tanpa cabut kloset', 'Teknisi APD steril higienis', 'Garansi nota 30 hari'],
        ],
        [
            'name' => 'Floor Drain Kamar Mandi',
            'slug' => 'floor-drain-kamar-mandi',
            'category' => 'SALURAN LANTAI',
            'desc' => 'Mengatasi genangan air lantai kamar mandi akibat jalinan rambut dan residu busa sabun yang menebal.',
            'price' => 400000,
            'features' => ['Tarik gumpalan rambut', 'Hilangkan bau got menguap', 'Garansi nota 30 hari'],
        ],
        [
            'name' => 'Inspeksi Kamera CCTV Pipa',
            'slug' => 'inspeksi-cctv-30m',
            'category' => 'DIAGNOSTIK DIGITAL',
            'desc' => 'Pemeriksaan visual kondisi jalur pipa dengan monitor HD hingga 30 meter untuk kepastian titik masalah.',
            'price' => 500000,
            'features' => ['Kamera anti-air IP68', 'Jangkauan kabel 30 meter', 'Bukti visual langsung'],
        ],
    ];
    $itemsCityServices = (isset($services) && $services->isNotEmpty()) ? $services : collect($defaultCityServices);
@endphp
<section id="layanan-kota" class="py-12 sm:py-18 bg-slate-50 border-b border-slate-200" x-data="mobileCarousel({{ count($itemsCityServices) }}, 4500)">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-2xl mx-auto mb-8 sm:mb-12 reveal-soft">
            <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-white border border-slate-200 text-slate-800 text-xs font-bold rounded-md uppercase tracking-wider mb-2 shadow-2xs">
                SPESIFIKASI LAYANAN
            </span>
            <h2 class="text-2xl sm:text-4xl font-extrabold text-slate-900 tracking-tight">
                Layanan Saluran Mampet di {{ $cityData['name'] }}
            </h2>
            <p class="text-slate-600 text-xs sm:text-base mt-2">
                Dikerjakan oleh teknisi ahli menggunakan mesin spiral torsi tinggi dan kamera CCTV pipa bergaransi 30 hari.
            </p>

            <div class="flex lg:hidden items-center justify-center gap-1.5 text-xs text-sky-700 font-medium mt-2.5">
                <svg class="w-4 h-4 text-sky-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                </svg>
                <span>Geser untuk layanan lainnya</span>
            </div>
        </div>

            <div x-ref="slider" tabindex="0" role="region" aria-label="Layanan kota — geser untuk melihat lainnya"
             @scroll.passive="onScroll()"
             @touchstart="pause()"
             @touchend="resume()"
             @touchcancel="resume()"
             class="flex lg:grid lg:grid-cols-4 overflow-x-auto lg:overflow-visible snap-x snap-mandatory no-scrollbar gap-4 sm:gap-6 pb-4 pt-1 px-4 -mx-4 sm:mx-0 sm:px-0">
            @foreach($itemsCityServices as $index => $item)
                @php
                    $isModel = is_object($item);
                    $title = $isModel ? $item->name : $item['name'];
                    $slug = $isModel ? $item->slug : $item['slug'];
                    $desc = $isModel ? ($item->short_description ?: $item->description) : $item['desc'];
                    $price = $isModel ? $item->price_starting_from : $item['price'];
                    $features = $isModel ? ($item->features ?: ['Tanpa bongkar keramik', 'Garansi nota 30 hari']) : $item['features'];
                    $category = $isModel ? ($item->category ?? 'LAYANAN UTAMA') : $item['category'];

                    $rawImage = $isModel ? $item->image : ($item['image'] ?? null);
                    $fallbackImage = asset('assets/placeholders/service.svg');
                    if (empty($rawImage) || str_contains($rawImage, 'placehold.co') || str_contains($rawImage, 'unsplash.com')) {
                        $imageSrc = $fallbackImage;
                    } else {
                        $imageSrc = str_starts_with($rawImage, 'http://') || str_starts_with($rawImage, 'https://')
                            ? $rawImage : asset(ltrim($rawImage, '/'));
                    }

                    $waServiceMsg = urlencode("Halo teknisi Drainusantara, saya butuh penanganan {$title} di area {$cityData['name']}. Mohon info estimasi biaya.");
                    $waServiceUrl = "https://wa.me/{$whatsappNumber}?text={$waServiceMsg}";
                @endphp
                <div class="w-[82vw] sm:w-70 lg:w-auto shrink-0 snap-center bg-white rounded-xl border border-slate-200 p-4 sm:p-5 flex flex-col justify-between shadow-2xs hover:shadow-md hover:border-sky-300 transition-all card-lift reveal-soft stagger-{{ ($index % 4) + 1 }}">
                    <div>
                        <div class="relative w-full aspect-16/10 rounded-md overflow-hidden bg-slate-100 mb-3.5 border border-slate-100">
                            <img src="{{ $imageSrc }}" onerror="this.onerror=null; this.src='{{ $fallbackImage }}';"
                                 alt="{{ $title }}" 
                                 width="600"
                                 height="375"
                                 loading="lazy" 
                                 decoding="async"
                                 class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300 ease-out">
                        </div>
                        <h3 class="text-base sm:text-lg font-bold text-slate-900 tracking-tight mb-2">
                            {{ $title }}
                        </h3>
                        <p class="text-xs text-slate-600 leading-relaxed line-clamp-3 mb-4">
                            {{ $desc }}
                        </p>

                        <ul class="space-y-1.5 text-xs text-slate-700 border-t border-slate-100 pt-3 mb-4">
                            @foreach(array_slice($features, 0, 3) as $feature)
                                <li class="flex items-center gap-1.5 text-slate-600">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-600 shrink-0"></span>
                                    <span class="truncate">{{ $feature }}</span>
                                </li>
                            @endforeach
                        </ul>
                    </div>

                    <div class="pt-3.5 border-t border-slate-100 flex items-center justify-between gap-2">
                        <div>
                            <span class="text-xs text-slate-500 block font-medium">Mulai dari</span>
                            <span class="text-xs sm:text-sm font-extrabold text-slate-900">{{ $price > 0 ? 'Rp '.number_format($price, 0, ',', '.') : 'Hubungi untuk harga' }}</span>
                        </div>
                        <a href="{{ $waServiceUrl }}" target="_blank" rel="noopener noreferrer" 
                           class="btn-press min-h-11 inline-flex items-center gap-1.5 text-xs font-bold text-white bg-emerald-700 hover:bg-emerald-800 py-2 px-3.5 rounded-lg shadow-2xs transition-colors shrink-0"
                           aria-label="Konsultasi {{ $title }} via WhatsApp">
                            <svg class="w-3.5 h-3.5 fill-current shrink-0" viewBox="0 0 24 24" aria-hidden="true">
                                <path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/>
                            </svg>
                            <span>Konsultasi WA</span>
                        </a>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="flex lg:hidden justify-center items-center flex-wrap gap-1.5 mt-3">
            @for($i = 0; $i < count($itemsCityServices); $i++)
                <button :aria-current="active === {{ $i }} ? 'true' : 'false'" type="button"
                        @click="goTo({{ $i }})"
                        class="carousel-dot"

                        aria-label="Layanan {{ $i + 1 }}">
                <span aria-hidden="true" class="h-1.5 rounded-full transition-all duration-300 ease-out cursor-pointer active:scale-75" :class="active === {{ $i }} ? 'w-5 bg-sky-700' : 'w-1.5 bg-slate-300 hover:bg-slate-400'"></span></button>
            @endfor
        </div>
    </div>
</section>

<x-area.equipment-section 
    :area-name="$cityData['name']"
    bg-color="bg-white"
/>

<section class="py-14 lg:py-20 bg-slate-900 text-white relative overflow-hidden reveal-soft">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-slate-800 border border-slate-700 text-sky-400 text-xs font-bold rounded-full uppercase tracking-wider mb-3">
            RESPON CEPAT {{ strtoupper($cityData['name']) }}
        </span>
        <h2 class="text-3xl sm:text-4xl font-extrabold text-white tracking-tight">
            Butuh Bantuan Teknisi di {{ $cityData['name'] }}?
        </h2>
        <p class="text-slate-400 text-sm sm:text-base mt-3 max-w-xl mx-auto leading-relaxed">
            Tim kami siap memberikan respon WhatsApp sigap dan cepat untuk penanganan saluran mampet di {{ $cityData['name'] }}. Konsultasikan masalah Anda sekarang juga.
        </p>
        <div class="mt-8 flex flex-col sm:flex-row items-center justify-center gap-4">
            <a href="{{ $cityWaUrl }}" target="_blank" rel="noopener noreferrer" 
               class="min-h-12 inline-flex items-center justify-center gap-2.5 bg-emerald-700 hover:bg-emerald-800 text-white font-bold text-sm px-6 py-3.5 rounded-xl shadow-md transition-all btn-press">
                <svg class="w-4 h-4 fill-current shrink-0" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/></svg>
                <span>Panggil Teknisi via WhatsApp</span>
            </a>
            <a href="{{ route('area.province', ['province' => $cityData['province_slug']]) }}" 
               class="min-h-12 inline-flex items-center justify-center gap-2 bg-slate-800 hover:bg-slate-700 text-slate-200 font-bold text-sm px-6 py-3.5 rounded-xl border border-slate-700 transition-colors btn-press">
                <span>Kota Lain di {{ $cityData['province_name'] }}</span>
            </a>
        </div>
    </div>
</section>
@endsection
