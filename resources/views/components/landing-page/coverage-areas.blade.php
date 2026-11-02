@props([
    'whatsappNumber' => null,
])

@php
    $whatsappNumber = $whatsappNumber ?: (config('app.whatsapp_number') ?: '6285609009009');
@endphp

<section id="area" class="bg-slate-50 border-b border-slate-200 py-16 lg:py-20" x-data="mobileCarousel(5, 4500)">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="flex flex-col lg:flex-row items-start lg:items-center justify-between gap-6 mb-10 md:mb-12 reveal-soft">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl bg-sky-700 text-white flex items-center justify-center shrink-0 shadow-xs">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                </div>
                <div>
                    <h2 class="text-2xl sm:text-3xl font-extrabold tracking-tight text-slate-900">Wilayah Jangkauan Armada Drainusantara</h2>
                    <p class="text-xs sm:text-sm text-slate-600 mt-1">Posko teknisi siaga di seluruh Jabodetabek, Bandung Raya, Semarang Raya, Demak, dan Lampung dengan respon WhatsApp sigap &amp; cepat.</p>
                </div>
            </div>
        </div>

        <div x-ref="slider" tabindex="0" role="region" aria-label="Wilayah layanan - geser untuk melihat lainnya"
             @scroll.passive="onScroll()"
             @touchstart="pause()"
             @touchend="resume()"
             @touchcancel="resume()"
             class="flex lg:grid lg:grid-cols-3 overflow-x-auto lg:overflow-visible snap-x snap-mandatory no-scrollbar gap-5 lg:gap-6 pb-4 pt-1 px-1 -mx-1 sm:mx-0 sm:px-0 items-stretch">
            
            <!-- Card 1: DKI JAKARTA -->
            <div class="group/card relative overflow-hidden w-[85vw] sm:w-85 lg:w-auto shrink-0 snap-center bg-white rounded-xl p-6 sm:p-7 border border-slate-200/90 hover:border-sky-400 hover:shadow-md transition-all flex flex-col justify-between card-lift reveal-soft stagger-1">
                <!-- Card Background Image Layer -->
                <div class="absolute inset-0 z-0 pointer-events-none overflow-hidden">
                    <img src="{{ asset('assets/wilayah/jasa-saluran-pipa-mampet-jakarta-indonesia-city-jakarta-drainusantara.webp') }}"
                         alt="Wilayah DKI Jakarta"
                         loading="lazy"
                         decoding="async"
                         class="w-full h-full object-cover object-top opacity-15 sm:opacity-20 group-hover/card:opacity-30 group-hover/card:scale-105 transition-all duration-700 ease-out">
                    <div class="absolute inset-0 bg-linear-to-b from-white/55 via-white/70 to-white/55"></div>
                </div>

                <div class="relative z-10">
                    <div class="mb-4">
                        <div class="w-9 h-9 rounded-lg bg-sky-50 border border-sky-200 text-sky-700 flex items-center justify-center shrink-0">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                            </svg>
                        </div>
                    </div>

                    <h3 class="text-xl font-bold text-slate-900 tracking-tight mb-2">DKI Jakarta</h3>
                    
                    <p class="text-xs sm:text-sm text-slate-600 leading-relaxed mb-5">
                        Armada teknisi siaga 24 jam menjangkau 5 kota administrasi. Siap menangani perumahan, apartemen, ruko, restoran, hingga gedung perkantoran.
                    </p>

                    <div class="pt-4 border-t border-slate-100">
                        <span class="text-xs font-bold uppercase tracking-wider text-slate-400 block mb-2.5">
                            Area Layanan Utama:
                        </span>
                        <div class="grid grid-cols-2 gap-2">
                            <a href="{{ route('area.city', ['city' => 'jakarta-selatan']) }}" class="group p-2.5 rounded-lg bg-slate-50/90 backdrop-blur-[2px] hover:bg-white border border-slate-200/80 hover:border-sky-300 transition-colors flex flex-col justify-between">
                                <div class="font-semibold text-xs text-slate-900 group-hover:text-sky-700 transition-colors truncate">Jakarta Selatan</div>
                                <div class="text-[11px] text-slate-500 mt-1 line-clamp-1">Kebayoran, Kemang, Tebet</div>
                            </a>
                            <a href="{{ route('area.city', ['city' => 'jakarta-barat']) }}" class="group p-2.5 rounded-lg bg-slate-50/90 backdrop-blur-[2px] hover:bg-white border border-slate-200/80 hover:border-sky-300 transition-colors flex flex-col justify-between">
                                <div class="font-semibold text-xs text-slate-900 group-hover:text-sky-700 transition-colors truncate">Jakarta Barat</div>
                                <div class="text-[11px] text-slate-500 mt-1 line-clamp-1">Kebon Jeruk, Puri, Grogol</div>
                            </a>
                            <a href="{{ route('area.city', ['city' => 'jakarta-timur']) }}" class="group p-2.5 rounded-lg bg-slate-50/90 backdrop-blur-[2px] hover:bg-white border border-slate-200/80 hover:border-sky-300 transition-colors flex flex-col justify-between">
                                <div class="font-semibold text-xs text-slate-900 group-hover:text-sky-700 transition-colors truncate">Jakarta Timur</div>
                                <div class="text-[11px] text-slate-500 mt-1 line-clamp-1">Duren Sawit, Cakung, Ciracas</div>
                            </a>
                            <a href="{{ route('area.city', ['city' => 'jakarta-utara']) }}" class="group p-2.5 rounded-lg bg-slate-50/90 backdrop-blur-[2px] hover:bg-white border border-slate-200/80 hover:border-sky-300 transition-colors flex flex-col justify-between">
                                <div class="font-semibold text-xs text-slate-900 group-hover:text-sky-700 transition-colors truncate">Jakarta Utara</div>
                                <div class="text-[11px] text-slate-500 mt-1 line-clamp-1">Kelapa Gading, PIK, Sunter</div>
                            </a>
                            <a href="{{ route('area.city', ['city' => 'jakarta-pusat']) }}" class="group col-span-2 p-2.5 rounded-lg bg-slate-50/90 backdrop-blur-[2px] hover:bg-white border border-slate-200/80 hover:border-sky-300 transition-colors flex items-center justify-between">
                                <div class="font-semibold text-xs text-slate-900 group-hover:text-sky-700 transition-colors">Jakarta Pusat</div>
                                <div class="text-[11px] text-slate-500">Menteng, Cempaka Putih, Kemayoran</div>
                            </a>
                        </div>
                    </div>
                </div>

                <div class="relative z-10 mt-6 pt-4 border-t border-slate-100 flex items-center justify-between gap-3">
                    <a href="{{ route('area.province', ['province' => 'dki-jakarta']) }}" class="text-xs font-bold text-sky-700 hover:text-sky-800 hover:underline">
                        Lihat Area Layanan &rarr;
                    </a>
                    @php
                        $waJktText = urlencode("Halo Drainusantara, saya butuh teknisi saluran mampet untuk area DKI Jakarta. Mohon info jadwal kedatangan.");
                    @endphp
                    <a href="https://wa.me/{{ $whatsappNumber }}?text={{ $waJktText }}" target="_blank" rel="noopener noreferrer"
                       class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-emerald-700 hover:bg-emerald-800 text-white text-xs font-bold transition-colors shadow-2xs btn-press">
                        <span>Panggil Teknisi</span>
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                        </svg>
                    </a>
                </div>
            </div>

            <!-- Card 2: BODETABEK -->
            <div class="group/card relative overflow-hidden w-[85vw] sm:w-85 lg:w-auto shrink-0 snap-center bg-white rounded-xl p-6 sm:p-7 border border-slate-200/90 hover:border-sky-400 hover:shadow-md transition-all flex flex-col justify-between card-lift reveal-soft stagger-2">
                <!-- Card Background Image Layer -->
                <div class="absolute inset-0 z-0 pointer-events-none overflow-hidden">
                    <img src="{{ asset('assets/wilayah/jasa-saluran-pipa-mampet-kota-bekasi-jawa-barat-drainusantara.webp') }}"
                         alt="Wilayah Bodetabek"
                         loading="lazy"
                         decoding="async"
                         class="w-full h-full object-cover object-top opacity-15 sm:opacity-20 group-hover/card:opacity-30 group-hover/card:scale-105 transition-all duration-700 ease-out">
                    <div class="absolute inset-0 bg-linear-to-b from-white/55 via-white/70 to-white/55"></div>
                </div>

                <div class="relative z-10">
                    <div class="mb-4">
                        <div class="w-9 h-9 rounded-lg bg-sky-50 border border-sky-200 text-sky-700 flex items-center justify-center shrink-0">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                            </svg>
                        </div>
                    </div>

                    <h3 class="text-xl font-bold text-slate-900 tracking-tight mb-2">BODETABEK</h3>
                    
                    <p class="text-xs sm:text-sm text-slate-600 leading-relaxed mb-5">
                        Posko teknisi tersebar di koridor perumahan dan klaster hunian penyangga ibu kota. Respon cepat tangani pipa mampet tanpa bongkar lantai ubin maupun keramik.
                    </p>

                    <div class="pt-4 border-t border-slate-100">
                        <span class="text-xs font-bold uppercase tracking-wider text-slate-400 block mb-2.5">
                            Area Layanan Utama:
                        </span>
                        <div class="grid grid-cols-2 gap-2">
                            <a href="{{ route('area.city', ['city' => 'bogor']) }}" class="group p-2.5 rounded-lg bg-slate-50/90 backdrop-blur-[2px] hover:bg-white border border-slate-200/80 hover:border-sky-300 transition-colors flex flex-col justify-between">
                                <div class="font-semibold text-xs text-slate-900 group-hover:text-sky-700 transition-colors truncate">Bogor &amp; Sentul</div>
                                <div class="text-[11px] text-slate-500 mt-1 line-clamp-1">Sentul City, Cibinong, Bogor Kota</div>
                            </a>
                            <a href="{{ route('area.city', ['city' => 'depok-cinere']) }}" class="group p-2.5 rounded-lg bg-slate-50/90 backdrop-blur-[2px] hover:bg-white border border-slate-200/80 hover:border-sky-300 transition-colors flex flex-col justify-between">
                                <div class="font-semibold text-xs text-slate-900 group-hover:text-sky-700 transition-colors truncate">Depok &amp; Cinere</div>
                                <div class="text-[11px] text-slate-500 mt-1 line-clamp-1">Margonda, Sawangan, Cinere</div>
                            </a>
                            <a href="{{ route('area.city', ['city' => 'tangerang-kota']) }}" class="group p-2.5 rounded-lg bg-slate-50/90 backdrop-blur-[2px] hover:bg-white border border-slate-200/80 hover:border-sky-300 transition-colors flex flex-col justify-between">
                                <div class="font-semibold text-xs text-slate-900 group-hover:text-sky-700 transition-colors truncate">Tangerang Kota</div>
                                <div class="text-[11px] text-slate-500 mt-1 line-clamp-1">Cipondoh, Karawaci, Ciledug</div>
                            </a>
                            <a href="{{ route('area.city', ['city' => 'tangerang-selatan']) }}" class="group p-2.5 rounded-lg bg-slate-50/90 backdrop-blur-[2px] hover:bg-white border border-slate-200/80 hover:border-sky-300 transition-colors flex flex-col justify-between">
                                <div class="font-semibold text-xs text-slate-900 group-hover:text-sky-700 transition-colors truncate">Tangsel</div>
                                <div class="text-[11px] text-slate-500 mt-1 line-clamp-1">BSD City, Bintaro, Serpong</div>
                            </a>
                            <a href="{{ route('area.city', ['city' => 'bekasi-cikarang']) }}" class="group col-span-2 p-2.5 rounded-lg bg-slate-50/90 backdrop-blur-[2px] hover:bg-white border border-slate-200/80 hover:border-sky-300 transition-colors flex items-center justify-between">
                                <div class="font-semibold text-xs text-slate-900 group-hover:text-sky-700 transition-colors">Bekasi &amp; Cikarang</div>
                                <div class="text-[11px] text-slate-500">Bekasi Barat, Harapan Indah, Cikarang</div>
                            </a>
                        </div>
                    </div>
                </div>

                <div class="relative z-10 mt-6 pt-4 border-t border-slate-100 flex items-center justify-between gap-3">
                    <span class="text-xs text-slate-500 font-medium">Banten &amp; Jabar</span>
                    @php
                        $waBodetabekText = urlencode("Halo Drainusantara, saya butuh teknisi saluran mampet untuk area Bodetabek. Mohon info teknisi terdekat.");
                    @endphp
                    <a href="https://wa.me/{{ $whatsappNumber }}?text={{ $waBodetabekText }}" target="_blank" rel="noopener noreferrer"
                       class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-emerald-700 hover:bg-emerald-800 text-white text-xs font-bold transition-colors shadow-2xs btn-press">
                        <span>Panggil Teknisi</span>
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                        </svg>
                    </a>
                </div>
            </div>

            <!-- Card 3: BANDUNG RAYA & CIMAHI (NEW) -->
            <div class="group/card relative overflow-hidden w-[85vw] sm:w-85 lg:w-auto shrink-0 snap-center bg-white rounded-xl p-6 sm:p-7 border border-slate-200/90 hover:border-sky-400 hover:shadow-md transition-all flex flex-col justify-between card-lift reveal-soft stagger-3">
                <!-- Card Background Image Layer -->
                <div class="absolute inset-0 z-0 pointer-events-none overflow-hidden">
                    <img src="{{ asset('assets/wilayah/jasa-saluran-pipa-mampet-kota-bekasi-jawa-barat-drainusantara.webp') }}"
                         alt="Wilayah Bandung Raya & Cimahi"
                         loading="lazy"
                         decoding="async"
                         class="w-full h-full object-cover object-top opacity-15 sm:opacity-20 group-hover/card:opacity-30 group-hover/card:scale-105 transition-all duration-700 ease-out">
                    <div class="absolute inset-0 bg-linear-to-b from-white/55 via-white/70 to-white/55"></div>
                </div>

                <div class="relative z-10">
                    <div class="mb-4">
                        <div class="w-9 h-9 rounded-lg bg-sky-50 border border-sky-200 text-sky-700 flex items-center justify-center shrink-0">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                        </div>
                    </div>

                    <h3 class="text-xl font-bold text-slate-900 tracking-tight mb-2">Bandung Raya &amp; Cimahi</h3>
                    
                    <p class="text-xs sm:text-sm text-slate-600 leading-relaxed mb-5">
                        Posko armada siaga melayani Kota Bandung (30 kecamatan), Kabupaten Bandung (31 kecamatan), dan Kota Cimahi. Siap atasi wastafel, kloset, dan saluran lemak kafe.
                    </p>

                    <div class="pt-4 border-t border-slate-100">
                        <span class="text-xs font-bold uppercase tracking-wider text-slate-400 block mb-2.5">
                            Area Layanan Utama:
                        </span>
                        <div class="grid grid-cols-2 gap-2">
                            <a href="{{ route('area.city', ['city' => 'bandung']) }}" class="group p-2.5 rounded-lg bg-slate-50/90 backdrop-blur-[2px] hover:bg-white border border-slate-200/80 hover:border-sky-300 transition-colors flex flex-col justify-between">
                                <div class="font-semibold text-xs text-slate-900 group-hover:text-sky-700 transition-colors truncate">Kota Bandung</div>
                                <div class="text-[11px] text-slate-500 mt-1 line-clamp-1">Dago, Coblong, Buahbatu, Sukajadi</div>
                            </a>
                            <a href="{{ route('area.city', ['city' => 'kabupaten-bandung']) }}" class="group p-2.5 rounded-lg bg-slate-50/90 backdrop-blur-[2px] hover:bg-white border border-slate-200/80 hover:border-sky-300 transition-colors flex flex-col justify-between">
                                <div class="font-semibold text-xs text-slate-900 group-hover:text-sky-700 transition-colors truncate">Kab. Bandung</div>
                                <div class="text-[11px] text-slate-500 mt-1 line-clamp-1">Soreang, Baleendah, Dayeuhkolot</div>
                            </a>
                            <a href="{{ route('area.city', ['city' => 'kota-cimahi']) }}" class="group col-span-2 p-2.5 rounded-lg bg-slate-50/90 backdrop-blur-[2px] hover:bg-white border border-slate-200/80 hover:border-sky-300 transition-colors flex items-center justify-between">
                                <div class="font-semibold text-xs text-slate-900 group-hover:text-sky-700 transition-colors truncate">Kota Cimahi</div>
                                <div class="text-[11px] text-slate-500">Cimahi Tengah, Cimahi Selatan, Cimahi Utara</div>
                            </a>
                        </div>
                    </div>
                </div>

                <div class="relative z-10 mt-6 pt-4 border-t border-slate-100 flex items-center justify-between gap-3">
                    <span class="text-xs text-slate-500 font-medium">Jawa Barat</span>
                    @php
                        $waBdgText = urlencode("Halo Drainusantara, saya butuh teknisi saluran mampet untuk area Bandung Raya / Cimahi. Mohon info teknisi terdekat.");
                    @endphp
                    <a href="https://wa.me/{{ $whatsappNumber }}?text={{ $waBdgText }}" target="_blank" rel="noopener noreferrer"
                       class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-emerald-700 hover:bg-emerald-800 text-white text-xs font-bold transition-colors shadow-2xs btn-press">
                        <span>Panggil Teknisi</span>
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                        </svg>
                    </a>
                </div>
            </div>

            <!-- Card 4: SEMARANG RAYA & KABUPATEN DEMAK (NEW & EXPANDED) -->
            <div class="group/card relative overflow-hidden w-[85vw] sm:w-85 lg:w-auto shrink-0 snap-center bg-white rounded-xl p-6 sm:p-7 border border-slate-200/90 hover:border-sky-400 hover:shadow-md transition-all flex flex-col justify-between card-lift reveal-soft stagger-4">
                <!-- Card Background Image Layer -->
                <div class="absolute inset-0 z-0 pointer-events-none overflow-hidden">
                    <img src="{{ asset('assets/wilayah/jasa-saluran-pipa-mampet-semarang-lampung-drainusantara.webp') }}"
                         alt="Wilayah Semarang & Demak"
                         loading="lazy"
                         decoding="async"
                         class="w-full h-full object-cover object-top opacity-15 sm:opacity-20 group-hover/card:opacity-30 group-hover/card:scale-105 transition-all duration-700 ease-out">
                    <div class="absolute inset-0 bg-linear-to-b from-white/55 via-white/70 to-white/55"></div>
                </div>

                <div class="relative z-10">
                    <div class="mb-4">
                        <div class="w-9 h-9 rounded-lg bg-sky-50 border border-sky-200 text-sky-700 flex items-center justify-center shrink-0">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                    </div>

                    <h3 class="text-xl font-bold text-slate-900 tracking-tight mb-2">Semarang Raya &amp; Demak</h3>
                    
                    <p class="text-xs sm:text-sm text-slate-600 leading-relaxed mb-5">
                        Posko teknisi Jawa Tengah mencakup Kota Semarang, Kabupaten Semarang (Ungaran), dan Kabupaten Demak (14 kecamatan) dengan mesin spiral modern.
                    </p>

                    <div class="pt-4 border-t border-slate-100">
                        <span class="text-xs font-bold uppercase tracking-wider text-slate-400 block mb-2.5">
                            Area Layanan Utama:
                        </span>
                        <div class="grid grid-cols-2 gap-2">
                            <a href="{{ route('area.city', ['city' => 'semarang']) }}" class="group p-2.5 rounded-lg bg-slate-50/90 backdrop-blur-[2px] hover:bg-white border border-slate-200/80 hover:border-sky-300 transition-colors flex flex-col justify-between">
                                <div class="font-semibold text-xs text-slate-900 group-hover:text-sky-700 transition-colors truncate">Kota Semarang</div>
                                <div class="text-[11px] text-slate-500 mt-1 line-clamp-1">Candisari, Banyumanik, Simpang Lima</div>
                            </a>
                            <a href="{{ route('area.city', ['city' => 'kabupaten-semarang']) }}" class="group p-2.5 rounded-lg bg-slate-50/90 backdrop-blur-[2px] hover:bg-white border border-slate-200/80 hover:border-sky-300 transition-colors flex flex-col justify-between">
                                <div class="font-semibold text-xs text-slate-900 group-hover:text-sky-700 transition-colors truncate">Kab. Semarang</div>
                                <div class="text-[11px] text-slate-500 mt-1 line-clamp-1">Ungaran Barat, Ambarawa, Bawen</div>
                            </a>
                            <a href="{{ route('area.city', ['city' => 'demak']) }}" class="group col-span-2 p-2.5 rounded-lg bg-slate-50/90 backdrop-blur-[2px] hover:bg-white border border-slate-200/80 hover:border-sky-300 transition-colors flex items-center justify-between">
                                <div class="font-semibold text-xs text-slate-900 group-hover:text-sky-700 transition-colors truncate">Kabupaten Demak</div>
                                <div class="text-[11px] text-slate-500">Sayung, Mranggen, Bonang, Demak Kota, Karanganyar</div>
                            </a>
                        </div>
                    </div>
                </div>

                <div class="relative z-10 mt-6 pt-4 border-t border-slate-100 flex items-center justify-between gap-3">
                    <a href="{{ route('area.province', ['province' => 'jawa-tengah']) }}" class="text-xs font-bold text-sky-700 hover:text-sky-800 hover:underline">
                        Lihat Jawa Tengah &rarr;
                    </a>
                    @php
                        $waSmgText = urlencode("Halo Drainusantara, saya butuh teknisi saluran mampet untuk area Semarang / Demak. Mohon info teknisi terdekat.");
                    @endphp
                    <a href="https://wa.me/{{ $whatsappNumber }}?text={{ $waSmgText }}" target="_blank" rel="noopener noreferrer"
                       class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-emerald-700 hover:bg-emerald-800 text-white text-xs font-bold transition-colors shadow-2xs btn-press">
                        <span>Panggil Teknisi</span>
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                        </svg>
                    </a>
                </div>
            </div>

            <!-- Card 5: BANDAR LAMPUNG & SUMATERA -->
            <div class="group/card relative overflow-hidden w-[85vw] sm:w-85 lg:w-auto shrink-0 snap-center bg-white rounded-xl p-6 sm:p-7 border border-slate-200/90 hover:border-sky-400 hover:shadow-md transition-all flex flex-col justify-between card-lift reveal-soft stagger-5">
                <!-- Card Background Image Layer -->
                <div class="absolute inset-0 z-0 pointer-events-none overflow-hidden">
                    <img src="{{ asset('assets/wilayah/jasa-saluran-pipa-mampet-semarang-lampung-drainusantara.webp') }}"
                         alt="Wilayah Bandar Lampung"
                         loading="lazy"
                         decoding="async"
                         class="w-full h-full object-cover object-top opacity-15 sm:opacity-20 group-hover/card:opacity-30 group-hover/card:scale-105 transition-all duration-700 ease-out">
                    <div class="absolute inset-0 bg-linear-to-b from-white/55 via-white/70 to-white/55"></div>
                </div>

                <div class="relative z-10">
                    <div class="mb-4">
                        <div class="w-9 h-9 rounded-lg bg-sky-50 border border-sky-200 text-sky-700 flex items-center justify-center shrink-0">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                            </svg>
                        </div>
                    </div>

                    <h3 class="text-xl font-bold text-slate-900 tracking-tight mb-2">Bandar Lampung</h3>
                    
                    <p class="text-xs sm:text-sm text-slate-600 leading-relaxed mb-5">
                        Posko regional siaga Pulau Sumatera melayani hunian perumahan, ruko, restoran, dan hotel dengan mesin rotary Ridgid dan garansi 30 hari.
                    </p>

                    <div class="pt-4 border-t border-slate-100">
                        <span class="text-xs font-bold uppercase tracking-wider text-slate-400 block mb-2.5">
                            Area Layanan Utama:
                        </span>
                        <div class="grid grid-cols-2 gap-2">
                            <a href="{{ route('area.city', ['city' => 'bandar-lampung']) }}" class="group p-2.5 rounded-lg bg-slate-50/90 backdrop-blur-[2px] hover:bg-white border border-slate-200/80 hover:border-sky-300 transition-colors flex flex-col justify-between">
                                <div class="font-semibold text-xs text-slate-900 group-hover:text-sky-700 transition-colors truncate">Bandar Lampung</div>
                                <div class="text-[11px] text-slate-500 mt-1 line-clamp-1">Kedaton, Tanjung Karang, Way Halim</div>
                            </a>
                            <a href="{{ route('area.city', ['city' => 'bandar-lampung']) }}" class="group p-2.5 rounded-lg bg-slate-50/90 backdrop-blur-[2px] hover:bg-white border border-slate-200/80 hover:border-sky-300 transition-colors flex flex-col justify-between">
                                <div class="font-semibold text-xs text-slate-900 group-hover:text-sky-700 transition-colors truncate">Lampung Selatan</div>
                                <div class="text-[11px] text-slate-500 mt-1 line-clamp-1">Natar, Jati Agung, Rajabasa</div>
                            </a>
                            <div class="group col-span-2 p-2.5 rounded-lg bg-slate-50/90 backdrop-blur-[2px] border border-slate-200/80 flex items-center justify-between">
                                <div class="font-semibold text-xs text-slate-900">Teluk Betung &amp; Sukarame</div>
                                <div class="text-[11px] text-slate-500">Dispatch via Bypass Soekarno-Hatta</div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="relative z-10 mt-6 pt-4 border-t border-slate-100 flex items-center justify-between gap-3">
                    <a href="{{ route('area.province', ['province' => 'lampung']) }}" class="text-xs font-bold text-sky-700 hover:text-sky-800 hover:underline">
                        Lihat Lampung &rarr;
                    </a>
                    @php
                        $waLpgText = urlencode("Halo Drainusantara, saya butuh teknisi saluran mampet untuk area Bandar Lampung. Mohon info teknisi terdekat.");
                    @endphp
                    <a href="https://wa.me/{{ $whatsappNumber }}?text={{ $waLpgText }}" target="_blank" rel="noopener noreferrer"
                       class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-emerald-700 hover:bg-emerald-800 text-white text-xs font-bold transition-colors shadow-2xs btn-press">
                        <span>Panggil Teknisi</span>
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                        </svg>
                    </a>
                </div>
            </div>

        </div>

        <!-- Mobile Slide Counter -->
        <div class="flex items-center justify-center gap-3 mt-5 lg:hidden text-xs text-slate-500 font-mono">
            <button type="button" @click="goTo(Math.max(0, active - 1))"
                    :disabled="active === 0"
                    :class="active === 0 ? 'opacity-40 cursor-not-allowed' : 'hover:bg-slate-100 hover:text-slate-900 cursor-pointer'"
                    class="p-1.5 rounded-md border border-slate-200 transition-colors"
                    aria-label="Wilayah sebelumnya">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            </button>
            <span>Wilayah <strong class="text-slate-900" x-text="active + 1">1</strong> dari 5</span>
            <button type="button" @click="goTo(Math.min(4, active + 1))"
                    :disabled="active === 4"
                    :class="active === 4 ? 'opacity-40 cursor-not-allowed' : 'hover:bg-slate-100 hover:text-slate-900 cursor-pointer'"
                    class="p-1.5 rounded-md border border-slate-200 transition-colors"
                    aria-label="Wilayah berikutnya">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            </button>
        </div>

        <div class="mt-8 bg-sky-50/80 border border-sky-200/80 rounded-xl p-5 flex flex-col sm:flex-row items-center justify-between gap-4">
            <div class="flex items-center gap-3 text-xs sm:text-sm text-slate-700">
                <svg class="w-5 h-5 text-sky-700 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                </svg>
                <span>Cari area atau kota spesifik lainnya? Buka peta direktori lengkap seluruh provinsi layanan kami.</span>
            </div>
            <a href="{{ route('area.index') }}" class="shrink-0 inline-flex items-center gap-2 px-5 py-2.5 bg-sky-700 hover:bg-sky-800 text-white text-xs font-bold rounded-lg transition-colors shadow-xs">
                <span>Lihat Direktori Seluruh Area</span>
                <span>&rarr;</span>
            </a>
        </div>

    </div>
</section>
