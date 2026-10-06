@props(['navServices' => null])

<header class="border-b border-slate-200/80 bg-white/95 backdrop-blur-md sticky top-0 z-40 transition-all shadow-2xs"
        @click.outside="activeMenu = null">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-20">
            <!-- Modern Friendly Brand Logo & Sub-Badge -->
            <a href="{{ url('/') }}" class="flex items-center gap-3 group">
                <div class="w-10 h-10 rounded-xl bg-sky-50 border border-sky-100 text-sky-700 flex items-center justify-center group-hover:bg-sky-100 transition-colors shadow-2xs">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" />
                    </svg>
                </div>
                <div>
                    <span class="text-xl font-extrabold tracking-tight text-slate-900 block leading-tight">
                        DRAI<span class="text-sky-700">NUSANTARA</span>
                    </span>
                    <span class="text-[10px] font-semibold text-slate-500 tracking-wider uppercase block">
                        Jasa Saluran Tanpa Bongkar
                    </span>
                </div>
            </a>

            <!-- Desktop Navigation Items -->
            <nav class="hidden md:flex items-center space-x-1 lg:space-x-1.5 text-sm font-semibold text-slate-600" aria-label="Navigasi Utama">
                <!-- 1. Beranda -->
                <a href="{{ route('home') }}" 
                   class="px-3 py-2 rounded-lg transition-colors focus-visible:outline-hidden focus-visible:ring-2 focus-visible:ring-sky-600 {{ request()->routeIs('home') && !request()->is('galeri*') && !request()->is('artikel*') && !request()->is('pengetahuan*') && !request()->is('area*') ? 'text-sky-700 font-bold bg-sky-50/70 border border-sky-100/60' : 'hover:text-sky-700 hover:bg-slate-50' }}">
                    Beranda
                </a>

                <!-- 2. Tentang kami (Interactive Dropdown Popover) -->
                <div class="relative" @click.outside="activeMenu = (activeMenu === 'tentang' ? null : activeMenu)">
                    <button @click="activeMenu = (activeMenu === 'tentang' ? null : 'tentang')"
                            type="button" 
                            class="inline-flex items-center gap-1.5 px-3 py-2 rounded-lg hover:text-sky-700 hover:bg-slate-50 transition-colors focus-visible:outline-hidden focus-visible:ring-2 focus-visible:ring-sky-600 cursor-pointer"
                            :class="{ 'text-sky-700 font-bold bg-sky-50/70 border border-sky-100/60': activeMenu === 'tentang' || {{ request()->is('tentang-kami*') ? 'true' : 'false' }} }"
                            aria-expanded="false"
                            :aria-expanded="activeMenu === 'tentang' ? 'true' : 'false'"
                            aria-haspopup="true">
                        <span>Tentang kami</span>
                        <svg class="w-4 h-4 transition-transform duration-200 text-slate-400" :class="{ 'rotate-180 text-sky-700': activeMenu === 'tentang' }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>

                    <!-- Compact Popover Menu (Clean, No Pills) -->
                    <div x-cloak 
                         x-show="activeMenu === 'tentang'"
                         x-transition:enter="transition ease-out duration-150"
                         x-transition:enter-start="opacity-0 translate-y-1 scale-98"
                         x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                         x-transition:leave="transition ease-in duration-100"
                         x-transition:leave-start="opacity-100 translate-y-0 scale-100"
                         x-transition:leave-end="opacity-0 translate-y-1 scale-98"
                         class="absolute top-full left-0 mt-2 w-80 bg-white border border-slate-200 rounded-xl shadow-lg p-2 z-50">
                        
                        <div class="pb-1.5 mb-1 border-b border-slate-100 px-2">
                            <span class="text-[10px] font-bold uppercase tracking-wider text-sky-700">
                                Profil &amp; Standar Kerja
                            </span>
                        </div>

                        <div class="space-y-0.5 max-h-95 overflow-y-auto pr-1">
                            <!-- 1. Struktur Holding J&J Group -->
                            <a href="{{ route('about.holding') }}" @click="activeMenu = null" class="block p-2 rounded-lg hover:bg-slate-50 transition-colors group">
                                <div class="text-xs font-bold text-slate-900 group-hover:text-sky-700 mb-0.5">Struktur Holding J&amp;J Group</div>
                                <p class="text-[11px] text-slate-500 leading-snug">Induk perusahaan &amp; jaringan ekosistem sanitasi.</p>
                            </a>

                            <!-- 2. SOP K3 -->
                            <a href="{{ route('about.k3') }}" @click="activeMenu = null" class="block p-2 rounded-lg hover:bg-slate-50 transition-colors group">
                                <div class="text-xs font-bold text-slate-900 group-hover:text-sky-700 mb-0.5">SOP K3</div>
                                <p class="text-[11px] text-slate-500 leading-snug">Standar APD teknisi, cover sepatu, &amp; sanitasi pasca kerja.</p>
                            </a>

                            <!-- 3. Profil Perusahaan -->
                            <a href="{{ route('about.profile') }}" @click="activeMenu = null" class="block p-2 rounded-lg hover:bg-slate-50 transition-colors group">
                                <div class="text-xs font-bold text-slate-900 group-hover:text-sky-700 mb-0.5">Profil Perusahaan</div>
                                <p class="text-[11px] text-slate-500 leading-snug">Visi, misi, dan komitmen spesialis pipa tanpa bongkar.</p>
                            </a>

                            <!-- 4. Peralatan & Teknologi -->
                            <a href="{{ route('about.equipment') }}" @click="activeMenu = null" class="block p-2 rounded-lg hover:bg-slate-50 transition-colors group">
                                <div class="text-xs font-bold text-slate-900 group-hover:text-sky-700 mb-0.5">Peralatan &amp; Teknologi</div>
                                <p class="text-[11px] text-slate-500 leading-snug">Mesin spiral rotary Ridgid &amp; kamera inspeksi CCTV IP68.</p>
                            </a>

                            <!-- 5. Klien / Portofolio (Perusahaan Yang Menggunakan Jasa Kami) -->
                            <a href="{{ route('about.portfolio') }}" @click="activeMenu = null" class="block p-2 rounded-lg hover:bg-slate-50 transition-colors group">
                                <div class="text-xs font-bold text-slate-900 group-hover:text-sky-700 mb-0.5">Perusahaan &amp; Portofolio Klien</div>
                                <p class="text-[11px] text-slate-500 leading-snug">Daftar perusahaan &amp; mitra B2B yang menggunakan jasa Drainusantara.</p>
                            </a>

                            <!-- 6. Ketentuan Garansi 30 Hari -->
                            <a href="{{ route('about.warranty') }}" @click="activeMenu = null" class="block p-2 rounded-lg hover:bg-slate-50 transition-colors group">
                                <div class="text-xs font-bold text-slate-900 group-hover:text-sky-700 mb-0.5">Ketentuan Garansi 30 Hari</div>
                                <p class="text-[11px] text-slate-500 leading-snug">Jaminan tertulis, No Cure No Pay, &amp; alur klaim re-visit gratis.</p>
                            </a>

                            <!-- 7. FAQ -->
                            <a href="{{ route('about.faq') }}" @click="activeMenu = null" class="block p-2 rounded-lg hover:bg-slate-50 transition-colors group">
                                <div class="text-xs font-bold text-slate-900 group-hover:text-sky-700 mb-0.5">FAQ</div>
                                <p class="text-[11px] text-slate-500 leading-snug">Tanya jawab seputar metode tanpa bongkar, biaya, &amp; soda api.</p>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- 3. Layanan (Hybrid Compact Popover) -->
                <a href="{{ url('/#layanan') }}" 
                   class="px-3 py-2 rounded-lg transition-colors focus-visible:outline-hidden focus-visible:ring-2 focus-visible:ring-sky-600 hover:text-sky-700 hover:bg-slate-50">
                    Layanan
                </a>
                <!-- 4. Hasil Kerja -->
                <a href="{{ route('gallery') }}" 
                   class="px-3 py-2 rounded-lg transition-colors focus-visible:outline-hidden focus-visible:ring-2 focus-visible:ring-sky-600 {{ request()->is('galeri*') ? 'text-sky-700 font-bold bg-sky-50/70 border border-sky-100/60' : 'hover:text-sky-700 hover:bg-slate-50' }}">
                    Hasil Kerja
                </a>

                <!-- 5. Area Jangkauan (Direct Dropdown Popover) -->
                <div class="relative" @click.outside="activeMenu = (activeMenu === 'wilayah' ? null : activeMenu)">
                    <button @click="activeMenu = (activeMenu === 'wilayah' ? null : 'wilayah')"
                            type="button" 
                            class="inline-flex items-center gap-1.5 px-3 py-2 rounded-lg hover:text-sky-700 hover:bg-slate-50 transition-colors focus-visible:outline-hidden focus-visible:ring-2 focus-visible:ring-sky-600 cursor-pointer"
                            :class="{ 'text-sky-700 font-bold bg-sky-50/70': activeMenu === 'wilayah' || {{ request()->is('area*') ? 'true' : 'false' }} }"
                            aria-expanded="false"
                            :aria-expanded="activeMenu === 'wilayah' ? 'true' : 'false'"
                            aria-haspopup="true">
                        <span>Area Jangkauan</span>
                        <svg class="w-4 h-4 transition-transform duration-200 text-slate-400" :class="{ 'rotate-180 text-sky-700': activeMenu === 'wilayah' }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>

                    <!-- Compact Popover Menu -->
                    <div x-cloak 
                         x-show="activeMenu === 'wilayah'"
                         x-transition:enter="transition ease-out duration-150"
                         x-transition:enter-start="opacity-0 translate-y-1 scale-98"
                         x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                         x-transition:leave="transition ease-in duration-100"
                         x-transition:leave-start="opacity-100 translate-y-0 scale-100"
                         x-transition:leave-end="opacity-0 translate-y-1 scale-98"
                         class="absolute top-full right-0 mt-2 w-120 bg-white border border-slate-200 rounded-xl shadow-lg p-3 z-50">
                        
                        <!-- Popover Header -->
                        <div class="flex items-center justify-between pb-2 mb-2.5 border-b border-slate-100">
                            <span class="text-xs font-bold text-sky-700 uppercase tracking-wider">
                                Wilayah Jangkauan Armada
                            </span>
                            <span class="text-[10px] font-bold text-emerald-700 bg-emerald-50 border border-emerald-200/60 px-2 py-0.5 rounded-md">
                                Siaga 24 Jam
                            </span>
                        </div>

                        <!-- 3 Clean Columns -->
                        <div class="grid grid-cols-3 gap-2.5 text-xs">
                            <!-- Col 1: DKI Jakarta -->
                            <div>
                                <div class="text-[10px] font-bold uppercase tracking-wider text-sky-700 mb-1 px-2">
                                    DKI Jakarta
                                </div>
                                <div class="space-y-0.5">
                                    <a href="{{ url('/area/jakarta-selatan') }}" @click="activeMenu = null" class="block px-2 py-1.5 rounded-md text-slate-700 hover:text-sky-700 hover:bg-slate-50 transition-colors font-medium">
                                        Jakarta Selatan
                                    </a>
                                    <a href="{{ url('/area/jakarta-timur') }}" @click="activeMenu = null" class="block px-2 py-1.5 rounded-md text-slate-700 hover:text-sky-700 hover:bg-slate-50 transition-colors font-medium">
                                        Jakarta Timur
                                    </a>
                                    <a href="{{ url('/area/jakarta-barat') }}" @click="activeMenu = null" class="block px-2 py-1.5 rounded-md text-slate-700 hover:text-sky-700 hover:bg-slate-50 transition-colors font-medium">
                                        Jakarta Barat
                                    </a>
                                    <a href="{{ url('/area/jakarta-utara') }}" @click="activeMenu = null" class="block px-2 py-1.5 rounded-md text-slate-700 hover:text-sky-700 hover:bg-slate-50 transition-colors font-medium">
                                        Jakarta Utara
                                    </a>
                                    <a href="{{ url('/area/jakarta-pusat') }}" @click="activeMenu = null" class="block px-2 py-1.5 rounded-md text-slate-700 hover:text-sky-700 hover:bg-slate-50 transition-colors font-medium">
                                        Jakarta Pusat
                                    </a>
                                </div>
                            </div>

                            <!-- Col 2: Bodetabek -->
                            <div>
                                <div class="text-[10px] font-bold uppercase tracking-wider text-sky-700 mb-1 px-2">
                                    BODETABEK
                                </div>
                                <div class="space-y-0.5">
                                    <a href="{{ url('/area/bogor-sentul') }}" @click="activeMenu = null" class="block px-2 py-1.5 rounded-md text-slate-700 hover:text-sky-700 hover:bg-slate-50 transition-colors font-medium">
                                        Bogor &amp; Sentul
                                    </a>
                                    <a href="{{ url('/area/depok-cinere') }}" @click="activeMenu = null" class="block px-2 py-1.5 rounded-md text-slate-700 hover:text-sky-700 hover:bg-slate-50 transition-colors font-medium">
                                        Depok &amp; Cinere
                                    </a>
                                    <a href="{{ url('/area/tangerang-kota') }}" @click="activeMenu = null" class="block px-2 py-1.5 rounded-md text-slate-700 hover:text-sky-700 hover:bg-slate-50 transition-colors font-medium">
                                        Tangerang Kota
                                    </a>
                                    <a href="{{ url('/area/tangerang-selatan') }}" @click="activeMenu = null" class="block px-2 py-1.5 rounded-md text-slate-700 hover:text-sky-700 hover:bg-slate-50 transition-colors font-medium">
                                        Tangsel / BSD
                                    </a>
                                    <a href="{{ url('/area/bekasi-cikarang') }}" @click="activeMenu = null" class="block px-2 py-1.5 rounded-md text-slate-700 hover:text-sky-700 hover:bg-slate-50 transition-colors font-medium">
                                        Bekasi &amp; Cikarang
                                    </a>
                                </div>
                            </div>

                            <!-- Col 3: Hub Regional & Posko -->
                            <div>
                                <div class="text-[10px] font-bold uppercase tracking-wider text-sky-700 mb-1 px-2">
                                    Hub Lainnya
                                </div>
                                <div class="space-y-0.5 mb-2">
                                    <a href="{{ url('/area/semarang') }}" @click="activeMenu = null" class="block px-2 py-1.5 rounded-md text-slate-700 hover:text-sky-700 hover:bg-slate-50 transition-colors font-medium">
                                        Kota Semarang
                                    </a>
                                    <a href="{{ url('/area/bandar-lampung') }}" @click="activeMenu = null" class="block px-2 py-1.5 rounded-md text-slate-700 hover:text-sky-700 hover:bg-slate-50 transition-colors font-medium">
                                        Bandar Lampung
                                    </a>
                                </div>
                            </div>
                        </div>

                        <!-- Footer Bar -->
                        <div class="pt-2 mt-2.5 border-t border-slate-100 flex items-center justify-between text-xs">
                            <a href="{{ url('/#area') }}" @click="activeMenu = null" class="text-sky-700 hover:text-sky-800 font-bold px-2 py-1 rounded-md hover:bg-sky-50 transition-colors">
                                Lihat Posko &amp; Peta Armada
                            </a>
                            <span class="text-[11px] text-slate-400 font-medium pr-2">
                                Garansi 30 Hari
                            </span>
                        </div>
                    </div>
                </div>

                <!-- 6. Artikel/Edukasi -->
                <a href="{{ route('articles.index') }}" 
                   class="px-3 py-2 rounded-lg transition-colors focus-visible:outline-hidden focus-visible:ring-2 focus-visible:ring-sky-600 {{ request()->is('artikel*') || request()->is('pengetahuan*') ? 'text-sky-700 font-bold bg-sky-50/70 border border-sky-100/60' : 'hover:text-sky-700 hover:bg-slate-50' }}">
                    Edukasi
                </a>
            </nav>

            <!-- Desktop CTA: Tombol 'Hubungi Kami' -->
            <div class="hidden md:flex items-center">
                <a :href="'https://wa.me/' + whatsappNumber + '?text=' + encodeURIComponent('Halo Admin Drainusantara, saluran air di rumah saya sedang mampet. Mohon info teknisi terdekat.')"
                   target="_blank" 
                   rel="noopener noreferrer" 
                   class="bg-emerald-700 hover:bg-emerald-800 text-white font-bold rounded-xl px-5 py-2.5 shadow-sm hover:shadow transition-all inline-flex items-center gap-2 active:scale-98 text-sm">
                    <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24">
                        <path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/>
                    </svg>
                    <span>Hubungi Kami</span>
                </a>
            </div>
        </div>
    </div>
</header>
