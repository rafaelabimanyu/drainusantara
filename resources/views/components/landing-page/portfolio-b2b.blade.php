@props([
    'portfolios' => null,
    'whatsappNumber' => null,
])

@php
    $b2bProjects = $portfolios ?? collect();
    $b2bWaUrl = "https://wa.me/{$whatsappNumber}?text=" . urlencode("Halo Admin Drainusantara, saya ingin konsultasi penanganan saluran pipa & grease trap untuk perusahaan/gedung kami. Mohon info survey lokasi.");
@endphp

@if($b2bProjects->isNotEmpty())
<section id="portofolio-b2b" class="py-16 lg:py-20 bg-slate-50 border-b border-slate-200 scroll-mt-20 lg:scroll-mt-24 content-auto" 
         x-data="mobileCarousel({{ count($b2bProjects) }}, 4500, 3)">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Section Header with Prev / Next Navigation -->
        <div class="flex flex-col md:flex-row items-start md:items-end justify-between gap-6 mb-10 md:mb-12">
            <div class="reveal-soft">
                <span class="text-xs font-bold uppercase tracking-wider text-sky-700 block mb-2">
                    Perusahaan Yang Menggunakan Jasa Kami &bull; Layanan Komersial &amp; Gedung
                </span>
                <h2 class="text-2xl sm:text-3xl lg:text-4xl font-extrabold text-slate-900 tracking-tight">
                    Dipercaya Perusahaan F&amp;B, Perhotelan &amp; Gedung Bertingkat
                </h2>
                <p class="text-slate-600 text-xs sm:text-sm mt-2 max-w-2xl leading-relaxed">
                    Solusi pemeliharaan saluran pipa limbah dan grease trap berkala dengan standar kepatuhan K3, sertifikat garansi pengerjaan, dan faktur pajak resmi.
                </p>
            </div>

            <!-- Desktop Carousel Controls -->
            <div class="hidden sm:flex items-center gap-2 shrink-0">
                <button type="button" 
                        @click="prev()" 
                        class="carousel-control w-10 h-10 rounded-xl bg-white hover:bg-sky-50 text-slate-700 hover:text-sky-700 border border-slate-200/90 hover:border-sky-300 transition-all shadow-2xs flex items-center justify-center cursor-pointer btn-press"
                        aria-label="Proyek Sebelumnya">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                    </svg>
                </button>
                <button type="button" 
                        @click="next()" 
                        class="carousel-control w-10 h-10 rounded-xl bg-white hover:bg-sky-50 text-slate-700 hover:text-sky-700 border border-slate-200/90 hover:border-sky-300 transition-all shadow-2xs flex items-center justify-center cursor-pointer btn-press"
                        aria-label="Proyek Berikutnya">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </button>
            </div>
        </div>

        <!-- Carousel Slider Track -->
            <div x-ref="slider" tabindex="0" role="region" aria-label="Portofolio perusahaan — geser untuk melihat lainnya"
             @scroll.passive="onScroll()"
             @touchstart="pause()"
             @touchend="resume()"
             @touchcancel="resume()"
             class="flex overflow-x-auto snap-x snap-mandatory no-scrollbar gap-5 lg:gap-6 pb-4 pt-1 px-1 -mx-1 sm:mx-0 sm:px-0">
            @foreach($b2bProjects as $project)
                @php
                    $itemWaText = urlencode("Halo Tim Drainusantara, saya tertarik dengan portofolio penanganan di '{$project->client_name}'. Mohon info konsultasi dan survei lokasi.");
                    $itemWaUrl = "https://wa.me/{$whatsappNumber}?text={$itemWaText}";
                @endphp
                <a href="{{ $itemWaUrl }}" 
                   target="_blank" 
                   rel="noopener noreferrer" 
                   class="w-[85vw] sm:w-85 md:w-auto lg:w-85 shrink-0 snap-center lg:snap-start bg-white rounded-xl border border-slate-200 overflow-hidden shadow-2xs hover:shadow-md hover:border-sky-300 transition-all duration-300 flex flex-col group card-lift focus-visible:outline-hidden focus-visible:ring-2 focus-visible:ring-sky-600"
                   title="Konsultasi penanganan {{ $project->client_name }}">
                    <!-- Foto Restoran / Klien Jernih (Tanpa Blur) -->
                    <div class="w-full h-52 sm:h-56 overflow-hidden bg-slate-100 relative">
                        @php
                            $projectImg = $project->image ? (str_starts_with($project->image, 'http') || str_starts_with($project->image, '/') ? $project->image : asset($project->image)) : asset('images/hero-technician.webp');
                            $defaultFallback = asset('images/hero-technician.webp');
                        @endphp
                        <img src="{{ $projectImg }}" 
                             alt="{{ $project->client_name }}" 
                             loading="lazy"
                             decoding="async"
                             width="800"
                             height="500"
                             class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                             onerror="this.onerror=null; this.src='{{ $defaultFallback }}';">
                    </div>

                    <!-- Informasi Restoran / Klien Bersih -->
                    <div class="p-5 flex flex-col justify-between flex-1">
                        <div>
                            <h3 class="text-base sm:text-lg font-bold text-slate-900 tracking-tight line-clamp-1 group-hover:text-sky-700 transition-colors">
                                {{ $project->client_name }}
                            </h3>
                            @if(!empty($project->client_type))
                            <p class="text-xs text-slate-500 mt-1.5 flex items-center gap-1.5 truncate">
                                <svg class="w-3.5 h-3.5 text-sky-600 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                </svg>
                                <span class="truncate">{{ $project->client_type }}</span>
                            </p>
                            @endif
                        </div>
                    </div>
                </a>
            @endforeach
        </div>

        <!-- Carousel Dots Indicator (1 titik untuk setiap 3 card) -->
        @php
            $b2bDotCount = max(1, (int) ceil(count($b2bProjects) / 3));
        @endphp
        @if($b2bDotCount > 1)
        <div class="flex justify-center items-center gap-1 mt-5">
            @for($p = 0; $p < $b2bDotCount; $p++)
                <button :aria-current="active === {{ $p }} ? 'true' : 'false'" type="button"
                        @click="goTo({{ $p }})"
                        class="carousel-dot min-w-7 min-h-7 p-2 inline-flex items-center justify-center cursor-pointer active:scale-90"
                        aria-label="Halaman Portofolio {{ $p + 1 }}">
                    <span class="h-2 rounded-full transition-all duration-300 block"
                          :class="active === {{ $p }} ? 'w-6 bg-sky-700' : 'w-2 bg-slate-300'"></span>
                </button>
            @endfor
        </div>
        @endif

        <!-- B2B Direct Consultation Banner -->
        <div class="mt-10 bg-white rounded-xl border border-slate-200 p-5 sm:p-6 flex flex-col sm:flex-row items-center justify-between gap-4 shadow-2xs reveal-soft">
            <div class="flex items-center gap-3.5 text-center sm:text-left">
                <div class="w-11 h-11 rounded-xl bg-sky-50 border border-sky-200 text-sky-700 flex items-center justify-center shrink-0 hidden sm:flex">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                    </svg>
                </div>
                <div>
                    <h4 class="text-sm sm:text-base font-bold text-slate-900">Butuh Survei Lokasi atau Penawaran Kontrak B2B?</h4>
                    <p class="text-xs text-slate-500 mt-0.5">Tersedia invoice resmi, faktur pajak PPN, Berita Acara (BAST), dan penanganan di luar jam operasional bisnis.</p>
                </div>
            </div>
            <a href="{{ $b2bWaUrl }}" target="_blank" rel="noopener noreferrer" 
               class="shrink-0 inline-flex items-center gap-2 px-5 py-2.5 rounded-lg bg-emerald-700 hover:bg-emerald-800 text-white text-xs sm:text-sm font-bold transition-colors shadow-2xs btn-press">
                <span>Konsultasi B2B via WhatsApp</span>
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                </svg>
            </a>
        </div>

    </div>
</section>
@endif
