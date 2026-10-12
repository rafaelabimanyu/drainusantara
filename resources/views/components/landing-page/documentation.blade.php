@props([
    'galleries' => null,
])

@php
    $displayGalleries = ($galleries ?? collect())->take(4);
    $countTotal = $displayGalleries->count();
@endphp

<section id="dokumentasi" class="relative py-16 lg:py-20 bg-slate-50 border-b border-slate-200 content-auto" @if($countTotal > 0) x-data="mobileCarousel({{ $countTotal }}, 4500)" @endif>
    <div id="galeri-before-after" class="absolute -top-16"></div>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-6 mb-8 md:mb-10 reveal-soft">
            <div>
                <span class="text-xs font-bold uppercase tracking-wider text-sky-700 block mb-2">
                    Dokumentasi Pekerjaan Lapangan
                </span>
                <h2 class="text-2xl sm:text-3xl lg:text-4xl font-extrabold text-slate-900 tracking-tight">
                    Hasil Pengerjaan Teknisi Drainusantara
                </h2>
                <p class="text-slate-600 text-xs sm:text-sm mt-2 max-w-2xl leading-relaxed">
                    Dokumentasi riil penanganan saluran pipa tersumbat menggunakan mesin rooter spiral elektrik dan kamera inspeksi endoskopi pipa tanpa bongkar keramik.
                </p>
                @if($countTotal > 0)
                <div class="flex md:hidden items-center justify-start gap-1.5 text-xs text-sky-700 font-medium mt-3" aria-hidden="true">
                    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                    </svg>
                    <span>Geser foto dokumentasi &bull; Auto-scroll aktif</span>
                </div>
                @endif
            </div>
            <div class="shrink-0">
                <a href="{{ url('/galeri') }}" class="inline-flex items-center gap-2 text-xs sm:text-sm font-bold text-sky-700 hover:text-sky-800 bg-white hover:bg-sky-50 border border-slate-200 px-4 py-2.5 rounded-lg shadow-2xs transition-colors btn-press min-h-10">
                    <span>Lihat Semua Galeri</span>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                    </svg>
                </a>
            </div>
        </div>

        @if($countTotal > 0)
        <!-- Responsive Grid on Desktop / Mobile Carousel -->
            <div x-ref="slider" tabindex="0" role="region" aria-label="Dokumentasi pekerjaan — geser untuk melihat lainnya"
             @scroll.passive="onScroll()"
             @touchstart="pause()"
             @touchend="resume()"
             @touchcancel="resume()"
             class="flex md:grid md:grid-cols-2 lg:grid-cols-4 overflow-x-auto md:overflow-visible snap-x snap-mandatory no-scrollbar gap-5 lg:gap-6 pb-4 pt-1 px-4 -mx-4 md:mx-0 md:px-0">
            @foreach($displayGalleries as $item)
                @php
                    $photo = $item->image ?: ($item->after_image ?: $item->before_image);
                    $serviceTitle = is_object($item->service ?? null) ? $item->service->name : 'Pelancaran Pipa';
                    $waText = urlencode("Halo Tim Drainusantara, saya melihat dokumentasi '{$item->title}'. Saluran pipa saya ada kendala serupa, mohon info estimasi biaya dan kedatangan teknisi.");
                    $itemWaUrl = "https://wa.me/" . config('app.whatsapp_number', '6285609009009') . "?text={$waText}";
                @endphp
                <div class="w-[84vw] sm:w-85 md:w-auto shrink-0 snap-center bg-white rounded-xl border border-slate-200/90 overflow-hidden shadow-2xs hover:shadow-md hover:border-sky-300 transition-all duration-300 card-lift reveal-soft stagger-{{ ($loop->iteration % 4) + 1 }} flex flex-col justify-between group">
                    <div>
                        <!-- Foto Dokumentasi Tajam (Tanpa Badge Kategori) -->
                        <div class="relative aspect-16/10 bg-slate-900 overflow-hidden border-b border-slate-100">
                            @if($photo)
                                <img 
                                    src="{{ $photo }}" 
                                    alt="{{ $item->title }}" 
                                    class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105"
                                    width="600"
                                    height="375"
                                    loading="lazy"
                                    decoding="async"
                                >
                            @else
                                <div class="w-full h-full flex items-center justify-center bg-slate-100 text-slate-400 text-xs">
                                    Foto Dokumentasi Lapangan
                                </div>
                            @endif
                        </div>

                        <!-- Keterangan Pekerjaan -->
                        <div class="p-4 sm:p-5 flex-1 flex flex-col justify-between">
                            <div>
                                <h3 class="text-sm sm:text-base font-bold text-slate-900 mb-2 leading-snug line-clamp-2 group-hover:text-sky-700 transition-colors">
                                    {{ $item->title }}
                                </h3>
                                @if(!empty($item->description))
                                <p class="text-sm text-slate-600 leading-relaxed line-clamp-3">
                                    {{ $item->description }}
                                </p>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Action Bar -->
                    <div class="p-4 sm:p-5 pt-3 border-t border-slate-100 flex items-center justify-end bg-slate-50/50">
                        <a href="{{ $itemWaUrl }}" 
                           target="_blank" 
                           rel="noopener noreferrer" 
                           class="btn-press text-xs sm:text-sm font-bold text-sky-700 hover:text-sky-800 underline underline-offset-2 min-h-9 inline-flex items-center gap-1 group/btn">
                            <span>Konsultasi</span>
                            <svg class="w-3.5 h-3.5 group-hover/btn:translate-x-0.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                            </svg>
                        </a>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="flex md:hidden justify-center items-center flex-wrap gap-1 mt-4">
            @for($i = 0; $i < $countTotal; $i++)
                <button :aria-current="active === {{ $i }} ? 'true' : 'false'" type="button"
                        @click="goTo({{ $i }})"
                        class="carousel-dot min-w-7 min-h-7 p-2 inline-flex items-center justify-center cursor-pointer active:scale-90"
                        aria-label="Dokumentasi {{ $i + 1 }}">
                    <span class="h-2 rounded-full transition-all duration-300 block"
                          :class="active === {{ $i }} ? 'w-6 bg-sky-700' : 'w-2 bg-slate-300 hover:bg-slate-400'"></span>
                </button>
            @endfor
        </div>
        @else
        <div class="py-14 px-6 text-center bg-white rounded-xl border border-slate-200 text-slate-500 reveal-soft">
            <div class="w-12 h-12 mx-auto mb-3 rounded-full bg-slate-100 text-slate-400 flex items-center justify-center">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
            </div>
            <h3 class="text-base font-bold text-slate-800 mb-1">Dokumentasi Belum Tersedia</h3>
            <p class="text-xs text-slate-500 max-w-md mx-auto">Foto hasil pengerjaan lapangan teknisi akan otomatis tampil di sini setelah ditambahkan melalui panel admin.</p>
        </div>
        @endif

    </div>
</section>
