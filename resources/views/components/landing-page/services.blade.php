@props([
    'services' => null,
    'problemCatalogs' => [],
    'whatsappNumber' => null,
])

@php
    $whatsappNumber = $whatsappNumber ?: (config('app.whatsapp_number') ?: '6281234567890');
    $itemsLayanan = (isset($services) && $services->isNotEmpty()) ? $services : collect($problemCatalogs);
@endphp
<section id="layanan" class="py-16 lg:py-24 bg-slate-50 border-b border-slate-200" x-data="mobileCarousel({{ count($itemsLayanan) }}, 4000)">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="text-center max-w-3xl mx-auto mb-10 md:mb-14 reveal-soft">
            <span class="text-xs font-bold uppercase tracking-wider text-sky-700 block mb-2">
                Katalog Spesialis Masalah
            </span>
            <h2 class="text-3xl sm:text-4xl font-extrabold text-slate-900 tracking-tight">
                Layanan Penanganan Saluran Pipa Mampet
            </h2>
            <p class="text-slate-600 text-sm sm:text-base mt-3 leading-relaxed">
                Pembersihan kerak pipa buangan wastafel, kloset duduk, floor drain, talang, dan grease trap menggunakan mesin spiral baja rotary. Dikerjakan dari lubang pipa eksisting tanpa merusak lantai keramik.
            </p>
            <div class="flex md:hidden items-center justify-center gap-1.5 text-xs text-sky-700 font-medium mt-3" aria-hidden="true">
                <svg class="w-4 h-4 subtle-shift-x shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                </svg>
                <span>Geser katalog titik saluran</span>
            </div>
        </div>

        <div x-ref="slider"
             @scroll.passive="onScroll()"
             @touchstart="pause()"
             @touchend="resume()"
             @mouseenter="pause()"
             @mouseleave="resume()"
             class="flex md:grid md:grid-cols-2 lg:grid-cols-3 overflow-x-auto md:overflow-visible snap-x snap-mandatory no-scrollbar gap-4 lg:gap-6 pb-4 pt-1 px-4 -mx-4 sm:mx-0 sm:px-0">
            @foreach($itemsLayanan as $catalog)
                @php
                    $isModel = $catalog instanceof \App\Models\Service;
                    $title = $isModel ? $catalog->name : $catalog['title'];
                    $slug = $isModel ? $catalog->slug : \Illuminate\Support\Str::slug($catalog['title']);
                    $desc = $isModel ? ($catalog->short_description ?: ($catalog->description ?: 'Pelancaran saluran mampet tanpa bongkar keramik.')) : $catalog['problem_desc'];
                    $price = $isModel ? ($catalog->price_starting_from ?: 400000) : $catalog['price'];
                    $features = $isModel ? ($catalog->features ?: []) : ($catalog['specs'] ?? []);
                    
                    // Smart Category Badge
                    $category = 'Layanan Spesialis';
                    $lowerName = strtolower($title);
                    if (str_contains($lowerName, 'wastafel') || str_contains($lowerName, 'dapur') || str_contains($lowerName, 'sink')) {
                        $category = 'Dapur & Residensial';
                    } elseif (str_contains($lowerName, 'kloset') || str_contains($lowerName, 'wc') || str_contains($lowerName, 'toilet')) {
                        $category = 'Toilet & Kamar Mandi';
                    } elseif (str_contains($lowerName, 'floor drain') || str_contains($lowerName, 'kamar mandi')) {
                        $category = 'Kamar Mandi & Lantai';
                    } elseif (str_contains($lowerName, 'cctv') || str_contains($lowerName, 'kamera')) {
                        $category = 'Diagnostik IP68';
                    } elseif (str_contains($lowerName, 'grease') || str_contains($lowerName, 'lemak') || str_contains($lowerName, 'resto')) {
                        $category = 'F&B Komersial';
                    } elseif (str_contains($lowerName, 'talang') || str_contains($lowerName, 'atap')) {
                        $category = 'Talang & Saluran Atap';
                    } elseif (!$isModel && isset($catalog['category'])) {
                        $category = $catalog['category'];
                    }

                    // Image resolution (custom CMS upload or curated fallback)
                    $rawImage = $isModel ? $catalog->image : ($catalog['image'] ?? null);
                    $fallbackImage = asset('images/services/wastafel-cuci-piring-mampet.webp');
                    if (str_contains($lowerName, 'kloset') || str_contains($lowerName, 'toilet') || str_contains($lowerName, 'wc')) {
                        $fallbackImage = asset('images/services/kloset-wc-mampet.webp');
                    } elseif (str_contains($lowerName, 'floor') || str_contains($lowerName, 'kamar mandi')) {
                        $fallbackImage = asset('images/services/floor-drain-kamar-mandi.webp');
                    } elseif (str_contains($lowerName, 'talang') || str_contains($lowerName, 'atap')) {
                        $fallbackImage = asset('images/services/talang-rooftop-pipa-atap.webp');
                    } elseif (str_contains($lowerName, 'grease') || str_contains($lowerName, 'lemak') || str_contains($lowerName, 'resto')) {
                        $fallbackImage = asset('images/services/kuras-grease-trap-lemak.webp');
                    } elseif (str_contains($lowerName, 'cctv') || str_contains($lowerName, 'kamera')) {
                        $fallbackImage = asset('images/services/inspeksi-kamera-cctv-pipa.webp');
                    }

                    if (empty($rawImage) || str_contains($rawImage, 'placehold.co')) {
                        $imageSrc = $fallbackImage;
                    } elseif (str_starts_with($rawImage, 'http://') || str_starts_with($rawImage, 'https://')) {
                        $imageSrc = $rawImage;
                    } else {
                        $imageSrc = asset(ltrim($rawImage, '/'));
                    }

                    $waMessage = $isModel 
                        ? "Halo Drainusantara, saya butuh penanganan untuk {$title}. Mohon info jadwal teknisi terdekat."
                        : ($catalog['wa_text'] ?? "Halo Drainusantara, saya butuh penanganan untuk {$title}.");
                    $specificWaUrl = "https://wa.me/{$whatsappNumber}?text=" . urlencode($waMessage);
                @endphp
                <div id="layanan-{{ $slug }}" class="w-[84vw] sm:w-[340px] md:w-auto shrink-0 snap-center bg-white rounded-lg border border-slate-200 shadow-xs hover:border-sky-300 hover:shadow-sm transition-all duration-200 flex flex-col justify-between p-4 sm:p-5 group card-lift reveal-soft delay-{{ min($loop->iteration * 50, 300) }}">
                    <div>
                        <div class="relative w-full aspect-16/10 rounded-md overflow-hidden bg-slate-100 mb-4 border border-slate-100">
                            <img src="{{ $imageSrc }}" 
                                 alt="{{ $title }}" 
                                 loading="lazy" 
                                 onerror="this.onerror=null; this.src='{{ $fallbackImage }}';"
                                 class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300 ease-out">
                            <div class="absolute inset-0 bg-gradient-to-t from-slate-900/60 via-transparent to-transparent opacity-60"></div>
                            <div class="absolute top-2.5 left-2.5">
                                <span class="text-[11px] font-bold text-sky-900 bg-white/95 backdrop-blur-xs px-2.5 py-0.5 rounded-md border border-slate-200/80 shadow-2xs">
                                    {{ $category }}
                                </span>
                            </div>
                        </div>

                        <h3 class="text-lg font-bold tracking-tight text-slate-900 group-hover:text-sky-700 transition-colors mb-2">
                            {{ $title }}
                        </h3>

                        <p class="text-xs sm:text-sm text-slate-600 leading-relaxed mb-4">
                            {{ $desc }}
                        </p>

                        @if(!empty($features) && is_array($features))
                            <ul class="space-y-1.5 text-xs text-slate-600 mb-3 pt-2 border-t border-slate-100">
                                @foreach(array_slice($features, 0, 3) as $feat)
                                    <li class="flex items-center gap-1.5">
                                        <svg class="w-3.5 h-3.5 text-emerald-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                        </svg>
                                        <span>{{ $feat }}</span>
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                    </div>

                    <div class="pt-4 mt-5 border-t border-slate-100 flex items-center justify-between gap-3">
                        <div>
                            <span class="text-[11px] text-slate-500 block leading-none mb-1">Tarif Penanganan:</span>
                            <div class="text-base sm:text-lg font-extrabold text-slate-900 tracking-tight">
                                Rp {{ number_format($price, 0, ',', '.') }}
                            </div>
                            <span class="text-[10px] text-emerald-700 font-semibold block mt-0.5">Tuntas baru bayar</span>
                        </div>

                        <a href="{{ $specificWaUrl }}" target="_blank" rel="noopener noreferrer" 
                           class="btn-press inline-flex items-center justify-center gap-1.5 bg-emerald-600 hover:bg-emerald-700 active:bg-emerald-800 text-white font-bold text-xs sm:text-sm px-3.5 sm:px-4 py-2.5 rounded-md shadow-xs transition-colors focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2 min-h-[44px]">
                            <span>Konsultasi Titik Ini (WA)</span>
                        </a>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="flex md:hidden justify-center items-center gap-1.5 mt-4">
            @for($i = 0; $i < count($itemsLayanan); $i++)
                <button type="button" 
                        @click="goTo({{ $i }})"
                        class="h-2 rounded-full transition-all duration-300 ease-out cursor-pointer active:scale-75"
                        :class="active === {{ $i }} ? 'w-6 bg-sky-700' : 'w-2 bg-slate-300 hover:bg-slate-400'"
                        aria-label="Layanan {{ $i + 1 }}">
                </button>
            @endfor
        </div>

    </div>
</section>
