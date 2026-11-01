@props([
    'currentCity' => null,
    'currentProvince' => null,
])

@php
    $regions = [
        [
            'region' => 'Jabodetabek & Banten',
            'badge' => 'HUB UTAMA & ARMADA TERBANYAK',
            'desc' => 'Pusat komando armada siaga tercepat melayani seluruh area metropolitan Jakarta, Depok, Tangerang, Tangsel, dan Bekasi.',
            'cities' => [
                ['name' => 'Jakarta Selatan', 'slug' => 'jakarta-selatan', 'hub' => 'Posko TB Simatupang & Kebayoran'],
                ['name' => 'Jakarta Barat', 'slug' => 'jakarta-barat', 'hub' => 'Posko Kebon Jeruk & Puri'],
                ['name' => 'Jakarta Timur', 'slug' => 'jakarta-timur', 'hub' => 'Posko Rawamangun & Cawang'],
                ['name' => 'Jakarta Utara', 'slug' => 'jakarta-utara', 'hub' => 'Posko Pluit & Kelapa Gading'],
                ['name' => 'Jakarta Pusat', 'slug' => 'jakarta-pusat', 'hub' => 'Posko Cempaka Putih & Salemba'],
                ['name' => 'Tangerang Kota', 'slug' => 'tangerang-kota', 'hub' => 'Posko Cipondoh & Ciledug'],
                ['name' => 'Tangerang Selatan', 'slug' => 'tangerang-selatan', 'hub' => 'Posko BSD Serpong & Bintaro'],
                ['name' => 'Depok & Cinere', 'slug' => 'depok-cinere', 'hub' => 'Posko Margonda & Cinere'],
                ['name' => 'Bekasi & Cikarang', 'slug' => 'bekasi-cikarang', 'hub' => 'Posko Summarecon & Cikarang'],
            ],
            'responseTime' => '30 - 45 Menit',
            'color' => 'sky',
        ],
        [
            'region' => 'Jawa Barat & Bandung Raya',
            'badge' => 'KORIDOR PRIANGAN & INDUSTRI',
            'desc' => 'Armada siaga khusus kawasan residensial dataran tinggi, ruko kuliner, dan pabrik kawasan industri Jawa Barat.',
            'cities' => [
                ['name' => 'Bandung Raya', 'slug' => 'bandung', 'hub' => 'Posko Buahbatu, Dago & Cimahi'],
            ],
            'responseTime' => '30 - 60 Menit',
            'color' => 'blue',
        ],
        [
            'region' => 'Jawa Tengah & Pantura',
            'badge' => 'KANTOR CABANG PANTURA',
            'desc' => 'Penanganan pipa mampet residensial pesisir dan komersial dengan mesin high-torque spesialis sedimen tanah & lumpur.',
            'cities' => [
                ['name' => 'Semarang Raya', 'slug' => 'semarang', 'hub' => 'Posko Simpang Lima & Banyumanik'],
            ],
            'responseTime' => '30 - 60 Menit',
            'color' => 'indigo',
        ],
        [
            'region' => 'Sumatera / Lampung',
            'badge' => 'HUB REGIONAL SUMATERA',
            'desc' => 'Pelayanan pelancaran pipa mampet bergaransi pertama dengan standar mesin spiral baja modern di Gerbang Sumatera.',
            'cities' => [
                ['name' => 'Bandar Lampung', 'slug' => 'lampung', 'hub' => 'Posko Tanjung Karang & Kedaton'],
            ],
            'responseTime' => '45 - 60 Menit',
            'color' => 'amber',
        ],
    ];
@endphp

<section id="cakupan-daerah-operasional" class="py-14 sm:py-20 bg-slate-50 border-b border-slate-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Header Section -->
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-4 mb-10 md:mb-12">
            <div class="max-w-3xl">
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs font-bold uppercase tracking-wider mb-3">
                    <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                    <span>Armada Siaga Tersebar di 4 Wilayah Strategis</span>
                </div>
                <h2 class="text-2xl sm:text-3xl lg:text-4xl font-extrabold text-slate-900 tracking-tight">
                    Cakupan Daerah Operasional Drainusantara
                </h2>
                <p class="text-slate-600 text-xs sm:text-sm md:text-base mt-2 leading-relaxed">
                    Mulai dari kawasan megapolitan Jabodetabek, koridor industri Jawa Barat, Jawa Tengah (Semarang), hingga Bandar Lampung. Teknisi standby di posko terdekat agar tiba di lokasi Anda dalam hitungan menit tanpa penundaan.
                </p>
            </div>

            <div class="shrink-0 flex items-center gap-2">
                <a href="{{ route('area.index') }}" 
                   class="inline-flex items-center gap-2 text-xs sm:text-sm font-bold text-sky-700 hover:text-sky-800 bg-white hover:bg-slate-100 border border-slate-300 px-4 py-2.5 rounded-lg transition-colors shadow-2xs btn-press">
                    <span>Lihat Semua Direktori Kecamatan</span>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                    </svg>
                </a>
            </div>
        </div>

        <div class="flex md:hidden items-center justify-start gap-1.5 text-xs text-sky-700 font-medium mb-3 px-1" aria-hidden="true">
            <svg class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
            <span>Geser untuk melihat wilayah regional lain</span>
        </div>

        <!-- Grid 4 Wilayah Regional (Carousel di Mobile) -->
        <div class="flex md:grid md:grid-cols-2 lg:grid-cols-4 overflow-x-auto md:overflow-visible snap-x snap-mandatory no-scrollbar gap-4 md:gap-6 pb-3 pt-1 px-4 -mx-4 md:mx-0 md:px-0">
            @foreach($regions as $idx => $reg)
            <div class="w-[84vw] max-w-[340px] md:w-auto shrink-0 snap-center bg-white rounded-xl border border-slate-200 shadow-2xs p-5 sm:p-6 flex flex-col justify-between card-lift transition-all hover:border-sky-500">
                <div>
                    <!-- Header Card Wilayah -->
                    <div class="flex items-center justify-between gap-2 pb-3 mb-3 border-b border-slate-100">
                        <span class="text-[10px] font-black uppercase tracking-wider px-2 py-0.5 rounded-md bg-slate-100 text-slate-700">
                            {{ $reg['badge'] }}
                        </span>
                        <span class="inline-flex items-center gap-1 text-[11px] font-semibold text-emerald-700">
                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                            <span>Siaga 24 Jam</span>
                        </span>
                    </div>

                    <h3 class="text-lg font-extrabold text-slate-900 tracking-tight mb-2">
                        {{ $reg['region'] }}
                    </h3>

                    <p class="text-xs text-slate-600 leading-relaxed mb-4">
                        {{ $reg['desc'] }}
                    </p>

                    <!-- Daftar Kota dalam Wilayah -->
                    <div class="space-y-1.5 mb-5">
                        <p class="text-[11px] font-bold uppercase tracking-wider text-slate-400">Pusat Layanan Kota:</p>
                        <div class="flex flex-col gap-1.5">
                            @foreach($reg['cities'] as $c)
                            @php
                                $isCurrent = ($currentCity && (str_contains(strtolower($currentCity), strtolower($c['name'])) || $currentCity === $c['slug']));
                            @endphp
                            <a href="{{ route('area.city', ['city' => $c['slug']]) }}" 
                               class="group/city flex items-center justify-between px-2.5 py-1.5 rounded-md text-xs transition-colors {{ $isCurrent ? 'bg-sky-50 text-sky-800 font-bold border border-sky-200' : 'bg-slate-50 hover:bg-sky-50 hover:text-sky-800 text-slate-700 border border-slate-100' }}">
                                <span class="flex items-center gap-1.5 truncate">
                                    <svg class="w-3.5 h-3.5 text-sky-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    </svg>
                                    <span class="truncate">{{ $c['name'] }}</span>
                                </span>
                                <span class="text-[10px] text-slate-400 group-hover/city:text-sky-600 shrink-0 font-medium ml-1">&rarr;</span>
                            </a>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Footer Card Wilayah: Quick CTA -->
                <div class="pt-3 border-t border-slate-100 flex items-center justify-between text-xs">
                    <span class="inline-flex items-center gap-1.5 text-[11px] font-medium text-slate-500">
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                        Armada Siaga
                    </span>
                    <a href="https://wa.me/6285609009009?text={{ urlencode('Halo Drainusantara, saya ingin order penanganan pipa mampet untuk wilayah ' . $reg['region']) }}"
                       target="_blank"
                       rel="noopener"
                       class="inline-flex items-center gap-1 text-[11px] font-bold text-emerald-700 hover:text-emerald-800 bg-emerald-50 hover:bg-emerald-100 px-2.5 py-1.5 rounded-md border border-emerald-200 transition-colors btn-press">
                        <span>Panggil Posko</span>
                        <svg class="w-3 h-3 fill-current" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/></svg>
                    </a>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Banner Jaminan Standar Wilayah -->
        <div class="mt-8 bg-white border border-slate-200 rounded-xl p-4 sm:p-5 flex flex-col sm:flex-row items-center justify-between gap-4">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-lg bg-sky-50 border border-sky-200 text-sky-700 flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                    </svg>
                </div>
                <div>
                    <h4 class="text-xs sm:text-sm font-bold text-slate-900">Garansi Layanan Resmi 30 Hari Berlaku di Seluruh Wilayah</h4>
                    <p class="text-[11px] sm:text-xs text-slate-600">Jika saluran mampet kembali dalam masa garansi 30 hari, teknisi kami datang kembali dan menuntaskan hingga lancar tanpa biaya tambahan (No Cure No Pay).</p>
                </div>
            </div>
            <a href="tel:085609009009" class="shrink-0 inline-flex items-center gap-2 bg-slate-900 hover:bg-slate-800 text-white text-xs font-bold px-4 py-2.5 rounded-lg transition-colors">
                <svg class="w-4 h-4 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                </svg>
                <span>Hotline: 0856-0900-9009</span>
            </a>
        </div>

    </div>
</section>

