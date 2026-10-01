@props([
    'galleries' => null,
])

<section id="dokumentasi" class="relative py-16 lg:py-20 bg-slate-50 border-b border-slate-200">
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
            </div>
            <div class="shrink-0">
                <a href="{{ url('/galeri') }}" class="inline-flex items-center gap-2 text-xs sm:text-sm font-bold text-sky-700 hover:text-sky-800 bg-white hover:bg-sky-50 border border-slate-200 px-4 py-2.5 rounded-lg shadow-2xs transition-colors btn-press min-h-[40px]">
                    <span>Lihat Semua Galeri</span>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                    </svg>
                </a>
            </div>
        </div>

        @php
            $displayGalleries = ($galleries ?? collect())->take(4);
            $countTotal = $displayGalleries->count();
        @endphp

        @if($countTotal > 0)
        <!-- 4-Card Responsive Grid (1 col mobile, 2 col tablet, 4 col desktop) -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 lg:gap-6">
            @foreach($displayGalleries as $item)
                @php
                    $photo = $item->image ?: ($item->after_image ?: $item->before_image);
                    $serviceTitle = is_object($item->service ?? null) ? $item->service->name : 'Pelancaran Pipa';
                    $waText = urlencode("Halo Tim Drainusantara, saya melihat dokumentasi '{$item->title}'. Saluran pipa saya ada kendala serupa, mohon info estimasi biaya dan kedatangan teknisi.");
                    $itemWaUrl = "https://wa.me/" . config('app.whatsapp_number', '6281234567890') . "?text={$waText}";
                @endphp
                <div class="bg-white rounded-xl border border-slate-200/90 overflow-hidden shadow-2xs hover:shadow-md hover:border-sky-300 transition-all duration-300 card-lift reveal-soft flex flex-col justify-between group">
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
                        <div class="p-4 sm:p-5">
                            <h3 class="text-sm sm:text-base font-bold text-slate-900 mb-1.5 leading-snug line-clamp-2 group-hover:text-sky-700 transition-colors">
                                {{ $item->title }}
                            </h3>
                            @if(!empty($item->description))
                            <p class="text-xs text-slate-600 leading-relaxed line-clamp-2">
                                {{ $item->description }}
                            </p>
                            @endif
                        </div>
                    </div>

                    <!-- Action Bar -->
                    <div class="p-4 sm:p-5 pt-0 border-t border-slate-100 mt-2 text-xs text-slate-500 flex items-center justify-between gap-2 bg-slate-50/50">
                        <span class="text-emerald-700 font-bold flex items-center gap-1 text-[11px]">
                            ✓ Bebas Bongkar
                        </span>
                        <a href="{{ $itemWaUrl }}" 
                           target="_blank" 
                           rel="noopener noreferrer" 
                           class="btn-press text-xs font-bold text-sky-700 hover:text-sky-800 underline underline-offset-2 min-h-[36px] inline-flex items-center">
                            Konsultasi &rarr;
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
