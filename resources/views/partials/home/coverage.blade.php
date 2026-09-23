<!-- ====================================================================
     7. WILAYAH JANGKAUAN DISPATCH & CRAWLABLE LOCAL LINKS (#area)
==================================================================== -->
<section id="area" class="bg-slate-50 border-b border-slate-200 py-16 fade-up">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Header -->
        <div class="flex flex-col lg:flex-row items-start lg:items-center justify-between gap-6 mb-10">
            <div class="flex items-center gap-4">
                <div class="w-11 h-11 rounded-xl bg-slate-900 text-white flex items-center justify-center shrink-0 shadow-xs">
                    <svg class="w-5 h-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                </div>
                <div>
                    <h2 class="text-2xl sm:text-3xl font-extrabold tracking-tight text-slate-900">Matriks Posko Wilayah Armada Drainusantara</h2>
                    <p class="text-xs sm:text-sm text-slate-600 mt-1">Armada teknisi siaga di seluruh Jabodetabek, Bandung, Semarang, dan Lampung dengan estimasi tiba 30–45 menit.</p>
                </div>
            </div>

            <div class="inline-flex items-center gap-2 px-3 py-1.5 bg-white border border-slate-200 rounded-full text-xs font-mono font-bold text-slate-800 shadow-2xs">
                <span class="w-2 h-2 bg-emerald-500 rounded-full inline-block"></span>
                <span>DISPATCH 24 JAM READY</span>
            </div>
        </div>

        <div class="space-y-5">
            <!-- Group 1: PROVINSI DKI JAKARTA -->
            <div class="bg-white rounded-2xl p-6 border border-slate-200/90 shadow-2xs">
                <div class="flex flex-wrap items-center justify-between gap-2 mb-4">
                    <div class="flex items-center gap-2.5">
                        <span class="text-xs uppercase font-mono font-bold text-blue-800 bg-blue-50 px-3 py-1 rounded-full border border-blue-200">DKI JAKARTA</span>
                        <span class="text-xs text-slate-600 font-medium">5 Kota Administrasi Siaga 24 Jam:</span>
                    </div>
                    <a href="{{ route('area.province', ['province' => 'dki-jakarta']) }}" title="Jasa Saluran Mampet Provinsi DKI Jakarta" class="text-xs font-bold text-blue-700 hover:text-blue-800 hover:underline">
                        Buka Halaman Provinsi DKI Jakarta &rarr;
                    </a>
                </div>
                <div class="flex flex-wrap gap-2.5 text-xs sm:text-sm">
                    <a href="{{ route('area.city', ['city' => 'jakarta-selatan']) }}" title="Jasa Saluran Mampet Jakarta Selatan" class="px-3.5 py-2 rounded-xl bg-slate-50 hover:bg-white text-slate-800 hover:text-blue-700 font-semibold border border-slate-200 hover:border-blue-300 hover:shadow-2xs transition-all flex items-center gap-2">
                        <span class="w-1.5 h-1.5 bg-emerald-500 rounded-full"></span>
                        <span>Jasa Saluran Mampet Jakarta Selatan <span class="text-slate-400 font-normal text-xs">(Tebet, Cilandak, Kemang)</span></span>
                    </a>
                    <a href="{{ route('area.city', ['city' => 'jakarta-timur']) }}" title="Pelancar WC Mampet Jakarta Timur" class="px-3.5 py-2 rounded-xl bg-slate-50 hover:bg-white text-slate-800 hover:text-blue-700 font-semibold border border-slate-200 hover:border-blue-300 hover:shadow-2xs transition-all flex items-center gap-2">
                        <span class="w-1.5 h-1.5 bg-emerald-500 rounded-full"></span>
                        <span>Pelancar WC Mampet Jakarta Timur <span class="text-slate-400 font-normal text-xs">(Duren Sawit, Ciracas, Cakung)</span></span>
                    </a>
                    <a href="{{ route('area.city', ['city' => 'jakarta-barat']) }}" title="Tukang Pipa Tersumbat Jakarta Barat" class="px-3.5 py-2 rounded-xl bg-slate-50 hover:bg-white text-slate-800 hover:text-blue-700 font-semibold border border-slate-200 hover:border-blue-300 hover:shadow-2xs transition-all flex items-center gap-2">
                        <span class="w-1.5 h-1.5 bg-emerald-500 rounded-full"></span>
                        <span>Tukang Pipa Tersumbat Jakarta Barat <span class="text-slate-400 font-normal text-xs">(Kebon Jeruk, Puri, Grogol)</span></span>
                    </a>
                    <a href="{{ route('area.city', ['city' => 'jakarta-utara']) }}" title="Jasa Wastafel Mampet Jakarta Utara" class="px-3.5 py-2 rounded-xl bg-slate-50 hover:bg-white text-slate-800 hover:text-blue-700 font-semibold border border-slate-200 hover:border-blue-300 hover:shadow-2xs transition-all flex items-center gap-2">
                        <span class="w-1.5 h-1.5 bg-emerald-500 rounded-full"></span>
                        <span>Jasa Wastafel Mampet Jakarta Utara <span class="text-slate-400 font-normal text-xs">(Kelapa Gading, PIK, Sunter)</span></span>
                    </a>
                    <a href="{{ route('area.city', ['city' => 'jakarta-pusat']) }}" title="Pelancar Pipa Mampet Jakarta Pusat" class="px-3.5 py-2 rounded-xl bg-slate-50 hover:bg-white text-slate-800 hover:text-blue-700 font-semibold border border-slate-200 hover:border-blue-300 hover:shadow-2xs transition-all flex items-center gap-2">
                        <span class="w-1.5 h-1.5 bg-emerald-500 rounded-full"></span>
                        <span>Pelancar Pipa Mampet Jakarta Pusat <span class="text-slate-400 font-normal text-xs">(Kemayoran, Cempaka Putih, Menteng)</span></span>
                    </a>
                </div>
            </div>

            <!-- Group 2: PROVINSI JAWA BARAT & BANTEN -->
            <div class="bg-white rounded-2xl p-6 border border-slate-200/90 shadow-2xs">
                <div class="flex flex-wrap items-center justify-between gap-2 mb-4">
                    <div class="flex items-center gap-2.5">
                        <span class="text-xs uppercase font-mono font-bold text-blue-800 bg-blue-50 px-3 py-1 rounded-full border border-blue-200">JAWA BARAT & BANTEN</span>
                        <span class="text-xs text-slate-600 font-medium">Bodetabek & Kota Bandung:</span>
                    </div>
                    <div class="flex items-center gap-3 text-xs font-bold">
                        <a href="{{ route('area.province', ['province' => 'jawa-barat']) }}" title="Jasa Pipa Mampet Jawa Barat" class="text-blue-700 hover:text-blue-800 hover:underline">
                            Provinsi Jawa Barat &rarr;
                        </a>
                        <span class="text-slate-300">|</span>
                        <a href="{{ route('area.province', ['province' => 'banten']) }}" title="Jasa Saluran Mampet Banten" class="text-blue-700 hover:text-blue-800 hover:underline">
                            Provinsi Banten &rarr;
                        </a>
                    </div>
                </div>
                <div class="flex flex-wrap gap-2.5 text-xs sm:text-sm">
                    <a href="{{ route('area.city', ['city' => 'bogor']) }}" title="Jasa Pipa Mampet Bogor & Sentul" class="px-3.5 py-2 rounded-xl bg-slate-50 hover:bg-white text-slate-800 hover:text-blue-700 font-semibold border border-slate-200 hover:border-blue-300 hover:shadow-2xs transition-all flex items-center gap-2">
                        <span class="w-1.5 h-1.5 bg-emerald-500 rounded-full"></span>
                        <span>Jasa Pipa Mampet Bogor & Sentul <span class="text-slate-400 font-normal text-xs">(Cibinong, Sentul, Kota Bogor)</span></span>
                    </a>
                    <a href="{{ route('area.city', ['city' => 'depok-cinere']) }}" title="Tukang Pipa Tersumbat Depok" class="px-3.5 py-2 rounded-xl bg-slate-50 hover:bg-white text-slate-800 hover:text-blue-700 font-semibold border border-slate-200 hover:border-blue-300 hover:shadow-2xs transition-all flex items-center gap-2">
                        <span class="w-1.5 h-1.5 bg-emerald-500 rounded-full"></span>
                        <span>Tukang Pipa Tersumbat Depok <span class="text-slate-400 font-normal text-xs">(Margonda, Sawangan, Cinere)</span></span>
                    </a>
                    <a href="{{ route('area.city', ['city' => 'bekasi-cikarang']) }}" title="Pelancar WC Mampet Bekasi" class="px-3.5 py-2 rounded-xl bg-slate-50 hover:bg-white text-slate-800 hover:text-blue-700 font-semibold border border-slate-200 hover:border-blue-300 hover:shadow-2xs transition-all flex items-center gap-2">
                        <span class="w-1.5 h-1.5 bg-emerald-500 rounded-full"></span>
                        <span>Pelancar WC Mampet Bekasi <span class="text-slate-400 font-normal text-xs">(Bekasi Barat, Cikarang Selatan)</span></span>
                    </a>
                    <a href="{{ route('area.city', ['city' => 'bandung']) }}" title="Posko Saluran Mampet Kota Bandung" class="px-3.5 py-2 rounded-xl bg-slate-50 hover:bg-white text-slate-800 hover:text-blue-700 font-semibold border border-slate-200 hover:border-blue-300 hover:shadow-2xs transition-all flex items-center gap-2">
                        <span class="w-1.5 h-1.5 bg-emerald-500 rounded-full"></span>
                        <span>Posko Saluran Mampet Kota Bandung <span class="text-slate-400 font-normal text-xs">(Buahbatu, Antapani, Coblong)</span></span>
                    </a>
                    <a href="{{ route('area.city', ['city' => 'tangerang-kota']) }}" title="Jasa Wastafel Mampet Tangerang Kota" class="px-3.5 py-2 rounded-xl bg-slate-50 hover:bg-white text-slate-800 hover:text-blue-700 font-semibold border border-slate-200 hover:border-blue-300 hover:shadow-2xs transition-all flex items-center gap-2">
                        <span class="w-1.5 h-1.5 bg-emerald-500 rounded-full"></span>
                        <span>Jasa Wastafel Mampet Tangerang Kota <span class="text-slate-400 font-normal text-xs">(Cipondoh, Karawaci, Ciledug)</span></span>
                    </a>
                    <a href="{{ route('area.city', ['city' => 'tangerang-selatan']) }}" title="Jasa Saluran Mampet Tangerang Selatan" class="px-3.5 py-2 rounded-xl bg-slate-50 hover:bg-white text-slate-800 hover:text-blue-700 font-semibold border border-slate-200 hover:border-blue-300 hover:shadow-2xs transition-all flex items-center gap-2">
                        <span class="w-1.5 h-1.5 bg-emerald-500 rounded-full"></span>
                        <span>Jasa Saluran Mampet Tangerang Selatan <span class="text-slate-400 font-normal text-xs">(BSD City, Bintaro, Serpong)</span></span>
                    </a>
                </div>
            </div>

            <!-- Group 3: CRAWLABLE KEYWORD DISTRICT INDEX FOR GOOGLEBOT -->
            <div class="bg-slate-100/70 rounded-2xl p-5 border border-slate-200 text-xs">
                <span class="text-xs font-mono font-bold text-slate-700 uppercase tracking-wider block mb-2">PETA JANGKAUAN POSKO KECAMATAN TERPOPULER</span>
                <div class="grid grid-cols-2 sm:grid-cols-4 md:grid-cols-6 gap-2 text-[11px] text-slate-600">
                    <a href="{{ route('area.detail', ['city' => 'jaksel', 'district' => 'tebet']) }}" class="hover:text-blue-700 hover:underline">Sumbatan Tebet Jaksel</a>
                    <a href="{{ route('area.detail', ['city' => 'jaksel', 'district' => 'cilandak']) }}" class="hover:text-blue-700 hover:underline">WC Mampet Cilandak</a>
                    <a href="{{ route('area.detail', ['city' => 'jaktim', 'district' => 'duren-sawit']) }}" class="hover:text-blue-700 hover:underline">Wastafel Duren Sawit</a>
                    <a href="{{ route('area.detail', ['city' => 'jaktim', 'district' => 'ciracas']) }}" class="hover:text-blue-700 hover:underline">Pipa Mampet Ciracas</a>
                    <a href="{{ route('area.detail', ['city' => 'jakbar', 'district' => 'kebon-jeruk']) }}" class="hover:text-blue-700 hover:underline">Floor Drain Kebon Jeruk</a>
                    <a href="{{ route('area.detail', ['city' => 'jakut', 'district' => 'kelapa-gading']) }}" class="hover:text-blue-700 hover:underline">Grease Trap Kelapa Gading</a>
                    <a href="{{ route('area.detail', ['city' => 'tangsel', 'district' => 'serpong']) }}" class="hover:text-blue-700 hover:underline">Pipa Tersumbat Serpong</a>
                    <a href="{{ route('area.detail', ['city' => 'tangsel', 'district' => 'bintaro']) }}" class="hover:text-blue-700 hover:underline">Jasa WC Bintaro</a>
                    <a href="{{ route('area.detail', ['city' => 'semarang', 'district' => 'semarang-tengah']) }}" class="hover:text-blue-700 hover:underline">Pipa Mampet Semarang</a>
                    <a href="{{ route('area.detail', ['city' => 'lampung', 'district' => 'tanjung-karang']) }}" class="hover:text-blue-700 hover:underline">Saluran Mampet Lampung</a>
                </div>
            </div>

            <!-- Directory Link Banner -->
            <div class="bg-blue-50/80 border border-blue-200/80 rounded-2xl p-5 flex flex-col sm:flex-row items-center justify-between gap-4">
                <div class="flex items-center gap-3 text-xs sm:text-sm text-slate-800 font-medium">
                    <svg class="w-5 h-5 text-blue-700 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                    </svg>
                    <span>Cari kecamatan atau kota spesifik lainnya? Buka peta direktori lengkap seluruh posko siaga kami.</span>
                </div>
                <a href="{{ route('area.index') }}" title="Direktori Lengkap Area Layanan Pipa Mampet DrainNusantara" class="shrink-0 inline-flex items-center gap-2 px-5 py-2.5 bg-blue-700 hover:bg-blue-800 text-white text-xs font-bold rounded-xl transition-colors shadow-2xs">
                    <span>Lihat Direktori Seluruh Area</span>
                    <span>&rarr;</span>
                </a>
            </div>

        </div>

    </div>
</section>
