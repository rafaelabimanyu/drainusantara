@props([
    'galleries' => null,
])

<section id="dokumentasi" class="relative py-16 lg:py-24 bg-slate-50 border-b border-slate-200" x-data="{ activeCategory: 'all' }">
    <div id="galeri-before-after" class="absolute -top-16"></div>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-6 mb-8 md:mb-10 reveal-soft">
            <div>
                <span class="text-xs font-bold uppercase tracking-wider text-sky-700 block mb-2">
                    Dokumentasi Pekerjaan Lapangan
                </span>
                <h2 class="text-3xl sm:text-4xl font-extrabold text-slate-900 tracking-tight">
                    Hasil Pengerjaan Teknisi Drainusantara
                </h2>
                <p class="text-slate-600 text-sm sm:text-base mt-2 max-w-2xl">
                    Dokumentasi riil penanganan saluran pipa tersumbat di sektor hunian rumahan dan komersial B2B menggunakan mesin rooter spiral elektrik dan kamera inspeksi pipa.
                </p>
            </div>
            <div>
                <a href="{{ url('/galeri') }}" class="inline-flex items-center gap-2 text-sm font-bold text-sky-700 hover:text-sky-800 bg-white hover:bg-sky-50 border border-slate-200 px-5 py-3 rounded-xl shadow-xs transition-colors btn-press min-h-[44px]">
                    <span>Lihat Semua Galeri</span>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                    </svg>
                </a>
            </div>
        </div>

        @php
            $displayGalleries = ($galleries ?? collect())->take(3);
            $countTotal = $displayGalleries->count();
            $countRumahan = $displayGalleries->where('category', 'rumahan')->count();
            $countB2b = $displayGalleries->where('category', 'b2b')->count();
        @endphp

        @if($countTotal > 0)
        <div class="flex flex-wrap items-center gap-2 mb-8 reveal-soft">
            <button type="button" 
                    @click="activeCategory = 'all'"
                    class="px-4 py-2.5 rounded-lg text-xs font-semibold transition-colors cursor-pointer focus-visible:outline-hidden focus-visible:ring-2 focus-visible:ring-sky-600 min-h-[44px] bg-white text-slate-700 border border-slate-200 hover:bg-slate-100"
                    :class="activeCategory === 'all' ? '!bg-sky-700 !text-white !font-bold shadow-xs !border-sky-700' : ''">
                Semua Sektor ({{ $countTotal }})
            </button>
            <button type="button" 
                    @click="activeCategory = 'rumahan'"
                    class="px-4 py-2.5 rounded-lg text-xs font-semibold transition-colors cursor-pointer focus-visible:outline-hidden focus-visible:ring-2 focus-visible:ring-sky-600 min-h-[44px] bg-white text-slate-700 border border-slate-200 hover:bg-slate-100"
                    :class="activeCategory === 'rumahan' ? '!bg-sky-700 !text-white !font-bold shadow-xs !border-sky-700' : ''">
                Rumahan / Residensial ({{ $countRumahan }})
            </button>
            <button type="button" 
                    @click="activeCategory = 'b2b'"
                    class="px-4 py-2.5 rounded-lg text-xs font-semibold transition-colors cursor-pointer focus-visible:outline-hidden focus-visible:ring-2 focus-visible:ring-sky-600 min-h-[44px] bg-white text-slate-700 border border-slate-200 hover:bg-slate-100"
                    :class="activeCategory === 'b2b' ? '!bg-sky-700 !text-white !font-bold shadow-xs !border-sky-700' : ''">
                B2B / Komersial ({{ $countB2b }})
            </button>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 lg:gap-8">
            @foreach($displayGalleries as $item)
                @php
                    $isB2b = ($item->category ?? 'rumahan') === 'b2b';
                    $photo = $item->image ?: ($item->after_image ?: $item->before_image);
                    $serviceTitle = is_object($item->service ?? null) ? $item->service->name : 'Pelancaran Pipa';
                    $waText = urlencode("Halo Tim Drainusantara, saya melihat dokumentasi '{$item->title}'. Saluran pipa saya ada kendala serupa, mohon info estimasi biaya dan kedatangan teknisi.");
                    $itemWaUrl = "https://wa.me/" . config('app.whatsapp_number', '6281234567890') . "?text={$waText}";
                @endphp
                <div x-show="activeCategory === 'all' || activeCategory === '{{ $item->category ?? 'rumahan' }}'"
                     x-transition:enter="transition ease-out duration-200"
                     x-transition:enter-start="opacity-0 scale-98"
                     x-transition:enter-end="opacity-100 scale-100"
                     class="bg-white rounded-xl border border-slate-200/90 overflow-hidden shadow-xs hover:shadow-md transition-all card-lift reveal-soft flex flex-col justify-between">
                    <div>
                        <div class="relative aspect-[16/10] bg-slate-900 overflow-hidden border-b border-slate-100">
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
                                    Foto Dokumentasi Lapangan
                                </div>
                            @endif

                            @if($isB2b)
                                <span class="absolute top-3 left-3 bg-slate-950/85 backdrop-blur-xs border border-amber-500/40 text-amber-300 text-[11px] font-bold px-2.5 py-1 rounded-md shadow-xs flex items-center gap-1.5">
                                    <svg class="w-3.5 h-3.5 fill-current" viewBox="0 0 20 20">
                                        <path d="M4 4a2 2 0 012-2h8a2 2 0 012 2v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4zm3 1h6v2H7V5zm6 4H7v2h6V9zm-6 4h6v2H7v-2z"/>
                                    </svg>
                                    B2B Komersial
                                </span>
                            @else
                                <span class="absolute top-3 left-3 bg-slate-950/85 backdrop-blur-xs border border-sky-500/40 text-sky-300 text-[11px] font-bold px-2.5 py-1 rounded-md shadow-xs flex items-center gap-1.5">
                                    <svg class="w-3.5 h-3.5 fill-current" viewBox="0 0 20 20">
                                        <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"/>
                                    </svg>
                                    Rumahan Residensial
                                </span>
                            @endif
                        </div>

                        <div class="p-5 sm:p-6">
                            <div class="flex items-center gap-2 mb-2">
                                <span class="px-2 py-0.5 text-[11px] font-bold bg-sky-50 text-sky-800 border border-sky-200/80 rounded-md">
                                    {{ $serviceTitle }}
                                </span>
                            </div>
                            <h3 class="text-base font-bold text-slate-900 mb-2 leading-snug line-clamp-2">
                                {{ $item->title }}
                            </h3>
                            <p class="text-xs text-slate-600 leading-relaxed line-clamp-3">
                                {{ $item->description }}
                            </p>
                        </div>
                    </div>

                    <div class="p-5 sm:p-6 pt-0 border-t border-slate-100 mt-2 text-xs text-slate-500 flex items-center justify-between gap-3 bg-slate-50/50">
                        <span class="text-emerald-700 font-bold flex items-center gap-1">
                            ✓ Bebas Bongkar Keramik
                        </span>
                        <a href="{{ $itemWaUrl }}" 
                           target="_blank" 
                           rel="noopener noreferrer" 
                           class="btn-press text-xs font-bold text-sky-700 hover:text-sky-800 underline underline-offset-2 min-h-[44px] inline-flex items-center">
                            Konsultasi Kasus Ini &rarr;
                        </a>
                    </div>
                </div>
            @endforeach
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
