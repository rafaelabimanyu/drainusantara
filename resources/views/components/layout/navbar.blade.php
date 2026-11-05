@props(['navServices' => null])
@php
    $navRegions = \App\Services\RegionService::all();
    $isHome = request()->routeIs('home') && !request()->is('galeri*') && !request()->is('artikel*') && !request()->is('pengetahuan*') && !request()->is('blog*') && !request()->is('area*') && !request()->is('tentang-kami*') && !request()->is('cara-kerja*') && !request()->is('proses-kerja*') && !request()->is('studi-kasus*') && !request()->is('kemitraan*');
    $isAbout = request()->is('tentang-kami*') || request()->routeIs('about*') || request()->routeIs('how-it-works') || request()->is('cara-kerja*') || request()->is('proses-kerja*') || request()->routeIs('equipment.show') || request()->is('kemitraan*') || request()->routeIs('partnership.show');
    $isGallery = request()->is('galeri*') || request()->routeIs('gallery') || request()->is('studi-kasus*') || request()->routeIs('case-study*');
    $isArea = request()->is('area*') || request()->routeIs('area*');
    $isBlog = request()->is('artikel*') || request()->is('pengetahuan*') || request()->is('blog*') || request()->routeIs('articles*');
@endphp

<header class="border-b border-slate-800 bg-slate-900/95 backdrop-blur-md sticky top-0 z-40 transition-all shadow-md text-slate-100"
        @click.outside="activeMenu = null">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16 sm:h-20">
            <a href="{{ url('/') }}" class="flex min-h-11 shrink-0 items-center px-1 sm:px-2.5 py-1.5 rounded-md focus-visible:outline-hidden focus-visible:ring-2 focus-visible:ring-sky-500">
                <img src="{{ asset('images/logo/TEKSBRAND-TAGLINE.webp') }}" srcset="{{ asset('images/logo/TEKSBRAND-TAGLINE-224.webp') }} 224w, {{ asset('images/logo/TEKSBRAND-TAGLINE-448.webp') }} 448w, {{ asset('images/logo/TEKSBRAND-TAGLINE.webp') }} 1198w" sizes="(max-width: 640px) 140px, (max-width: 1280px) 170px, 192px" alt="Drainusantara: Jasa Saluran Tanpa Bongkar" class="block h-auto w-36 sm:w-44 xl:w-48 max-w-full object-contain" width="1198" height="208">
            </a>
            

            <!-- Desktop Navigation Items -->
            <nav class="hidden lg:flex items-center space-x-0.5 xl:space-x-1.5 text-xs xl:text-sm font-semibold text-slate-300" aria-label="Navigasi Utama">
                <!-- 1. Beranda -->
                <a href="{{ route('home') }}" 
                   @click="activeSection = 'home'"
                   class="px-2.5 xl:px-3 py-1.5 xl:py-2 rounded-lg border transition-colors focus-visible:outline-hidden focus-visible:ring-2 focus-visible:ring-sky-500 {{ $isHome ? 'text-sky-400 font-bold bg-slate-800/90 border-slate-700/80' : 'text-slate-300 hover:text-white hover:bg-slate-800/60 border-transparent' }}"
                   @if($isHome)
                   :class="{
                       'text-sky-400 font-bold bg-slate-800/90 border-slate-700/80': activeSection === 'home',
                       'text-slate-300 hover:text-white hover:bg-slate-800/60 border-transparent': activeSection !== 'home'
                   }"
                   @endif>
                    Beranda
                </a>

                <!-- 2. Tentang kami (Interactive Dropdown Popover) -->
                <div class="relative" @click.outside="activeMenu = (activeMenu === 'tentang' ? null : activeMenu)">
                    <button @click="activeMenu = (activeMenu === 'tentang' ? null : 'tentang')"
                            type="button" 
                            class="inline-flex items-center gap-1 xl:gap-1.5 px-2.5 xl:px-3 py-1.5 xl:py-2 rounded-lg border transition-colors focus-visible:outline-hidden focus-visible:ring-2 focus-visible:ring-sky-500 cursor-pointer {{ $isAbout ? 'text-sky-400 font-bold bg-slate-800/90 border-slate-700/80' : 'text-slate-300 hover:text-white hover:bg-slate-800/60 border-transparent' }}"
                            :class="{
                                'text-sky-400 font-bold bg-slate-800/90 border-slate-700/80': activeMenu === 'tentang' || {{ $isAbout ? 'true' : 'false' }},
                                'text-slate-300 hover:text-white hover:bg-slate-800/60 border-transparent': activeMenu !== 'tentang' && !{{ $isAbout ? 'true' : 'false' }}
                            }"
                            aria-expanded="false"
                            :aria-expanded="activeMenu === 'tentang' ? 'true' : 'false'"
                            aria-haspopup="true">
                        <span>Tentang kami</span>
                        <svg class="w-3.5 h-3.5 xl:w-4 xl:h-4 transition-transform duration-200" :class="{ 'rotate-180 text-sky-400': activeMenu === 'tentang', 'text-sky-400': {{ $isAbout ? 'true' : 'false' }}, 'text-slate-400': activeMenu !== 'tentang' && !{{ $isAbout ? 'true' : 'false' }} }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
                         class="absolute top-full left-0 mt-2 w-80 bg-slate-900 border border-slate-800 rounded-xl shadow-2xl p-2 z-50 text-slate-100">
                        
                        <div class="pb-1.5 mb-1 border-b border-slate-800 px-2">
                            <span class="text-[10px] font-bold uppercase tracking-wider text-sky-400">
                                Profil &amp; Standar Kerja
                            </span>
                        </div>

                        <div class="space-y-0.5 max-h-95 overflow-y-auto pr-1 custom-scrollbar-sky">
                            @php
                                $isProfile = request()->routeIs('about.profile') || (request()->routeIs('about') && !request()->routeIs('about.holding') && !request()->routeIs('about.k3') && !request()->routeIs('about.equipment') && !request()->routeIs('about.portfolio') && !request()->routeIs('about.warranty') && !request()->routeIs('about.faq'));
                                $isHowItWorks = request()->routeIs('how-it-works') || request()->is('cara-kerja*') || request()->is('proses-kerja*');
                                $isHolding = request()->routeIs('about.holding');
                                $isK3 = request()->routeIs('about.k3');
                                $isEquip = request()->routeIs('about.equipment') || request()->routeIs('equipment.show');
                                $isPortfolio = request()->routeIs('about.portfolio') || request()->routeIs('partnership.show') || request()->is('kemitraan*');
                                $isWarranty = request()->routeIs('about.warranty');
                                $isFaq = request()->routeIs('about.faq');
                            @endphp

                            <a href="{{ route('about.profile') }}" @click="activeMenu = null" class="block p-2 rounded-lg transition-colors group {{ $isProfile ? 'bg-slate-800 text-sky-400 border border-slate-700/80' : 'hover:bg-slate-800/80 text-slate-100 border border-transparent' }}">
                                <div class="text-xs font-bold {{ $isProfile ? 'text-sky-400' : 'text-slate-100 group-hover:text-sky-400' }} mb-0.5">Profil Perusahaan</div>
                                <p class="text-[11px] {{ $isProfile ? 'text-slate-300' : 'text-slate-400' }} leading-snug">Visi, misi, dan komitmen spesialis pipa tanpa bongkar.</p>
                            </a>
                            
                            <a href="{{ route('how-it-works') }}" @click="activeMenu = null" class="block p-2 rounded-lg transition-colors group {{ $isHowItWorks ? 'bg-slate-800 text-sky-400 border border-slate-700/80' : 'hover:bg-slate-800/80 text-slate-100 border border-transparent' }}">
                                <div class="text-xs font-bold {{ $isHowItWorks ? 'text-sky-400' : 'text-slate-100 group-hover:text-sky-400' }} mb-0.5">Cara Kerja &amp; Standar Proses</div>
                                <p class="text-[11px] {{ $isHowItWorks ? 'text-slate-300' : 'text-slate-400' }} leading-snug">5 tahapan mekanis tanpa bongkar keramik &amp; inspeksi CCTV.</p>
                            </a>
                            
                            <a href="{{ route('about.holding') }}" @click="activeMenu = null" class="block p-2 rounded-lg transition-colors group {{ $isHolding ? 'bg-slate-800 text-sky-400 border border-slate-700/80' : 'hover:bg-slate-800/80 text-slate-100 border border-transparent' }}">
                                <div class="text-xs font-bold {{ $isHolding ? 'text-sky-400' : 'text-slate-100 group-hover:text-sky-400' }} mb-0.5">Induk PT Jawa Jaya Rooter</div>
                                <p class="text-[11px] {{ $isHolding ? 'text-slate-300' : 'text-slate-400' }} leading-snug">Induk perusahaan &amp; jaringan operasional sanitasi.</p>
                            </a>

                            <a href="{{ route('about.k3') }}" @click="activeMenu = null" class="block p-2 rounded-lg transition-colors group {{ $isK3 ? 'bg-slate-800 text-sky-400 border border-slate-700/80' : 'hover:bg-slate-800/80 text-slate-100 border border-transparent' }}">
                                <div class="text-xs font-bold {{ $isK3 ? 'text-sky-400' : 'text-slate-100 group-hover:text-sky-400' }} mb-0.5">SOP K3</div>
                                <p class="text-[11px] {{ $isK3 ? 'text-slate-300' : 'text-slate-400' }} leading-snug">Standar APD teknisi, cover sepatu, &amp; sanitasi pasca kerja.</p>
                            </a>

                            <a href="{{ route('about.equipment') }}" @click="activeMenu = null" class="block p-2 rounded-lg transition-colors group {{ $isEquip ? 'bg-slate-800 text-sky-400 border border-slate-700/80' : 'hover:bg-slate-800/80 text-slate-100 border border-transparent' }}">
                                <div class="text-xs font-bold {{ $isEquip ? 'text-sky-400' : 'text-slate-100 group-hover:text-sky-400' }} mb-0.5">Peralatan &amp; Teknologi</div>
                                <p class="text-[11px] {{ $isEquip ? 'text-slate-300' : 'text-slate-400' }} leading-snug">Mesin spiral rotary Ridgid &amp; kamera inspeksi CCTV IP68.</p>
                            </a>

                            <a href="{{ route('about.portfolio') }}" @click="activeMenu = null" class="block p-2 rounded-lg transition-colors group {{ $isPortfolio ? 'bg-slate-800 text-sky-400 border border-slate-700/80' : 'hover:bg-slate-800/80 text-slate-100 border border-transparent' }}">
                                <div class="text-xs font-bold {{ $isPortfolio ? 'text-sky-400' : 'text-slate-100 group-hover:text-sky-400' }} mb-0.5">Kemitraan</div>
                                <p class="text-[11px] {{ $isPortfolio ? 'text-slate-300' : 'text-slate-400' }} leading-snug">Jaringan kemitraan, instansi, &amp; klien komersial Drainusantara.</p>
                            </a>

                            <a href="{{ route('about.warranty') }}" @click="activeMenu = null" class="block p-2 rounded-lg transition-colors group {{ $isWarranty ? 'bg-slate-800 text-sky-400 border border-slate-700/80' : 'hover:bg-slate-800/80 text-slate-100 border border-transparent' }}">
                                <div class="text-xs font-bold {{ $isWarranty ? 'text-sky-400' : 'text-slate-100 group-hover:text-sky-400' }} mb-0.5">Ketentuan Garansi 30 Hari</div>
                                <p class="text-[11px] {{ $isWarranty ? 'text-slate-300' : 'text-slate-400' }} leading-snug">Jaminan tertulis, No Cure No Pay, &amp; alur klaim re-visit gratis.</p>
                            </a>

                            <a href="{{ route('about.faq') }}" @click="activeMenu = null" class="block p-2 rounded-lg transition-colors group {{ $isFaq ? 'bg-slate-800 text-sky-400 border border-slate-700/80' : 'hover:bg-slate-800/80 text-slate-100 border border-transparent' }}">
                                <div class="text-xs font-bold {{ $isFaq ? 'text-sky-400' : 'text-slate-100 group-hover:text-sky-400' }} mb-0.5">FAQ</div>
                                <p class="text-[11px] {{ $isFaq ? 'text-slate-300' : 'text-slate-400' }} leading-snug">Tanya jawab seputar metode tanpa bongkar, biaya, &amp; soda api.</p>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- 3. Layanan (Hybrid Compact Popover) -->
                <a href="{{ url('/#layanan') }}" 
                   @click="activeSection = 'layanan'"
                   class="px-2.5 xl:px-3 py-1.5 xl:py-2 rounded-lg border transition-colors focus-visible:outline-hidden focus-visible:ring-2 focus-visible:ring-sky-500 text-slate-300 hover:text-white hover:bg-slate-800/60 border-transparent"
                   @if($isHome)
                   :class="{
                       'text-sky-400 font-bold bg-slate-800/90 border-slate-700/80': activeSection === 'layanan',
                       'text-slate-300 hover:text-white hover:bg-slate-800/60 border-transparent': activeSection !== 'layanan'
                   }"
                   @endif>
                    Layanan
                </a>
                <!-- 4. Hasil Kerja -->
                <a href="{{ route('gallery') }}" 
                   class="px-2.5 xl:px-3 py-1.5 xl:py-2 rounded-lg border transition-colors focus-visible:outline-hidden focus-visible:ring-2 focus-visible:ring-sky-500 {{ $isGallery ? 'text-sky-400 font-bold bg-slate-800/90 border-slate-700/80' : 'hover:text-white hover:bg-slate-800/60 text-slate-300 border-transparent' }}">
                    Hasil Kerja
                </a>

                <!-- 5. Area Jangkauan (Direct Dropdown Popover) -->
                <div class="relative" @click.outside="activeMenu = (activeMenu === 'wilayah' ? null : activeMenu)">
                    <button @click="activeMenu = (activeMenu === 'wilayah' ? null : 'wilayah')"
                            type="button" 
                            class="inline-flex items-center gap-1 xl:gap-1.5 px-2.5 xl:px-3 py-1.5 xl:py-2 rounded-lg border transition-colors focus-visible:outline-hidden focus-visible:ring-2 focus-visible:ring-sky-500 cursor-pointer {{ $isArea ? 'text-sky-400 font-bold bg-slate-800/90 border-slate-700/80' : 'text-slate-300 hover:text-white hover:bg-slate-800/60 border-transparent' }}"
                            :class="{
                                'text-sky-400 font-bold bg-slate-800/90 border-slate-700/80': activeMenu === 'wilayah' || {{ $isArea ? 'true' : 'false' }} || ({{ $isHome ? 'true' : 'false' }} && activeSection === 'area'),
                                'text-slate-300 hover:text-white hover:bg-slate-800/60 border-transparent': activeMenu !== 'wilayah' && !{{ $isArea ? 'true' : 'false' }} && (!{{ $isHome ? 'true' : 'false' }} || activeSection !== 'area')
                            }"
                            aria-expanded="false"
                            :aria-expanded="activeMenu === 'wilayah' ? 'true' : 'false'"
                            aria-haspopup="true">
                        <span>Area Jangkauan</span>
                        <svg class="w-3.5 h-3.5 xl:w-4 xl:h-4 transition-transform duration-200" :class="{ 'rotate-180 text-sky-400': activeMenu === 'wilayah', 'text-sky-400': {{ $isArea ? 'true' : 'false' }}, 'text-slate-400': activeMenu !== 'wilayah' && !{{ $isArea ? 'true' : 'false' }} }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
                         class="absolute top-full right-0 mt-2 w-160 bg-slate-900 border border-slate-800 rounded-xl shadow-2xl p-3 z-50 text-slate-100">
                        
                        <!-- Popover Header -->
                        <div class="flex items-center justify-between pb-2 mb-2.5 border-b border-slate-800">
                            <span class="text-xs font-bold text-sky-400 uppercase tracking-wider">
                                Wilayah Jangkauan Armada
                            </span>
                        </div>

                        <!-- 4 Clean Columns -->
                        <div class="grid grid-cols-4 gap-2.5 text-xs">
                            <!-- Col 1: DKI Jakarta -->
                            <div>
                                <div class="text-[10px] font-bold uppercase tracking-wider text-sky-400 mb-1 px-2">
                                    DKI Jakarta
                                </div>
                                <div class="space-y-0.5">
                                    @foreach ($navRegions['dki-jakarta']['cities'] as $city)
                                        @php
                                            $isCityActive = request()->is('area/' . $city['slug'] . '*');
                                        @endphp
                                        <a href="{{ route('area.city', ['city' => $city['slug']]) }}" @click="activeMenu = null" class="block px-2 py-1.5 rounded-md transition-colors font-medium {{ $isCityActive ? 'bg-slate-800 text-sky-400 font-bold border border-slate-700/80' : 'text-slate-300 hover:text-white hover:bg-slate-800/80' }}">
                                            {{ $city['name'] }}
                                        </a>
                                    @endforeach
                                </div>
                            </div>

                            <!-- Col 2: Bodetabek -->
                            <div>
                                <div class="text-[10px] font-bold uppercase tracking-wider text-sky-400 mb-1 px-2">
                                    BODETABEK
                                </div>
                                <div class="space-y-0.5">
                                    @foreach (['bogor', 'depok-cinere', 'tangerang-kota', 'tangerang-selatan', 'bekasi-cikarang'] as $slug)
                                        @php
                                            $city = $navRegions[$slug === 'tangerang-kota' || $slug === 'tangerang-selatan' ? 'banten' : 'jawa-barat']['cities'][$slug];
                                            $isCityActive = request()->is('area/' . $city['slug'] . '*');
                                        @endphp
                                        <a href="{{ route('area.city', ['city' => $city['slug']]) }}" @click="activeMenu = null" class="block px-2 py-1.5 rounded-md transition-colors font-medium {{ $isCityActive ? 'bg-slate-800 text-sky-400 font-bold border border-slate-700/80' : 'text-slate-300 hover:text-white hover:bg-slate-800/80' }}">
                                            {{ $city['name'] }}
                                        </a>
                                    @endforeach
                                </div>
                            </div>

                            <!-- Col 3: Bali -->
                            <div>
                                <div class="text-[10px] font-bold uppercase tracking-wider text-sky-400 mb-1 px-2">
                                    BALI
                                </div>
                                <div class="space-y-0.5">
                                    @if(isset($navRegions['bali']['cities']))
                                        @foreach (['kota-denpasar', 'kabupaten-badung', 'kabupaten-gianyar', 'kabupaten-tabanan'] as $bCitySlug)
                                            @if(isset($navRegions['bali']['cities'][$bCitySlug]))
                                                @php
                                                    $bCity = $navRegions['bali']['cities'][$bCitySlug];
                                                    $isCityActive = request()->is('area/' . $bCity['slug'] . '*');
                                                @endphp
                                                <a href="{{ route('area.city', ['city' => $bCity['slug']]) }}" @click="activeMenu = null" class="block px-2 py-1.5 rounded-md transition-colors font-medium {{ $isCityActive ? 'bg-slate-800 text-sky-400 font-bold border border-slate-700/80' : 'text-slate-300 hover:text-white hover:bg-slate-800/80' }}">
                                                    {{ $bCity['name'] }}
                                                </a>
                                            @endif
                                        @endforeach
                                        <a href="{{ route('area.province', ['province' => 'bali']) }}" @click="activeMenu = null" class="block px-2 py-1 rounded-md text-[11px] text-sky-400 hover:text-sky-300 font-semibold">
                                            + Seluruh Bali &rarr;
                                        </a>
                                    @endif
                                </div>
                            </div>

                            <!-- Col 4: Hub Lainnya -->
                            <div>
                                <div class="text-[10px] font-bold uppercase tracking-wider text-sky-400 mb-1 px-2">
                                    Hub Lainnya
                                </div>
                                <div class="space-y-0.5 mb-2">
                                    @foreach (['semarang' => 'jawa-tengah', 'bandar-lampung' => 'lampung'] as $slug => $province)
                                        @php
                                            $city = $navRegions[$province]['cities'][$slug];
                                            $isCityActive = request()->is('area/' . $city['slug'] . '*');
                                        @endphp
                                        <a href="{{ route('area.city', ['city' => $city['slug']]) }}" @click="activeMenu = null" class="block px-2 py-1.5 rounded-md transition-colors font-medium {{ $isCityActive ? 'bg-slate-800 text-sky-400 font-bold border border-slate-700/80' : 'text-slate-300 hover:text-white hover:bg-slate-800/80' }}">
                                            {{ $city['name'] }}
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <!-- Footer Bar -->
                        <div class="pt-2 mt-2.5 border-t border-slate-800 flex items-center justify-between text-xs">
                            <a href="{{ route('area.index') }}" @click="activeMenu = null" class="text-slate-400 hover:text-white px-2 py-1 rounded-md hover:bg-slate-800/60 transition-colors">
                                Semua Wilayah Layanan
                            </a>
                            <a href="{{ url('/#area') }}" @click="activeSection = 'area'; activeMenu = null" class="text-sky-400 hover:text-sky-300 font-bold px-2 py-1 rounded-md hover:bg-slate-800/60 transition-colors">
                                Lihat Posko &amp; Peta Armada
                            </a>
                        </div>
                    </div>
                </div>

                <!-- 6. Blog -->
                <a href="{{ route('articles.index') }}" 
                   class="px-2.5 xl:px-3 py-1.5 xl:py-2 rounded-lg border transition-colors focus-visible:outline-hidden focus-visible:ring-2 focus-visible:ring-sky-500 {{ $isBlog ? 'text-sky-400 font-bold bg-slate-800/90 border-slate-700/80' : 'hover:text-white hover:bg-slate-800/60 text-slate-300 border-transparent' }}">
                    Blog
                </a>

                <!-- 7. Kontak -->
                <a href="{{ route('contact') }}" 
                   class="px-2.5 xl:px-3 py-1.5 xl:py-2 rounded-lg border transition-colors focus-visible:outline-hidden focus-visible:ring-2 focus-visible:ring-sky-500 {{ request()->routeIs('contact') ? 'text-sky-400 font-bold bg-slate-800/90 border-slate-700/80' : 'hover:text-white hover:bg-slate-800/60 text-slate-300 border-transparent' }}">
                    Kontak
                </a>
            </nav>

            <!-- Desktop CTA: Tunggal (CTA WhatsApp Hijau, 'Cek Estimasi' dihilangkan agar navbar lega & fokus) -->
            <div class="hidden lg:flex items-center">
                <a href="{{ $contextualWaUrl ?? 'https://wa.me/' . ($whatsappNumber ?? '6285609009009') . '?text=' . rawurlencode('Halo Admin Drainusantara, saluran air di rumah saya sedang mampet. Mohon info teknisi terdekat.') }}"
                   :href="'https://wa.me/' + whatsappNumber + '?text=' + encodeURIComponent(contextualWaMsg || 'Halo Admin Drainusantara, saluran air di rumah saya sedang mampet. Mohon info teknisi terdekat.')"
                   target="_blank" 
                   rel="noopener noreferrer" 
                   data-track-location="navbar"
                   class="bg-emerald-600 hover:bg-emerald-500 text-white font-bold rounded-lg xl:rounded-xl px-3.5 xl:px-4 py-2 shadow-sm hover:shadow transition-all inline-flex items-center gap-1.5 xl:gap-2 active:scale-98 text-xs xl:text-sm shrink-0">
                    <svg class="w-4 h-4 fill-current shrink-0" viewBox="0 0 24 24" aria-hidden="true">
                        <path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/>
                    </svg>
                    <span>Hubungi Kami</span>
                </a>
            </div>

            <!-- Mobile & Tablet Actions (Header Responsif untuk Layar < lg) -->
            <div class="flex items-center gap-2 lg:hidden">
                <!-- 1. Tombol WhatsApp Compact Mobile -->
                <a href="{{ $contextualWaUrl ?? 'https://wa.me/' . ($whatsappNumber ?? '6285609009009') . '?text=' . rawurlencode('Halo Admin Drainusantara, saluran air di rumah saya sedang mampet. Mohon info teknisi terdekat.') }}"
                   :href="'https://wa.me/' + whatsappNumber + '?text=' + encodeURIComponent(contextualWaMsg || 'Halo Admin Drainusantara, saluran air di rumah saya sedang mampet. Mohon info teknisi terdekat.')"
                   target="_blank" 
                   rel="noopener noreferrer" 
                   data-track-location="navbar_mobile"
                   class="bg-emerald-600 hover:bg-emerald-500 text-white font-bold rounded-lg px-2.5 sm:px-3 py-1.5 shadow-xs transition-all inline-flex items-center gap-1.5 active:scale-95 text-xs">
                    <svg class="w-3.5 h-3.5 fill-current shrink-0" viewBox="0 0 24 24" aria-hidden="true">
                        <path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/>
                    </svg>
                    <span class="hidden sm:inline">Hubungi Kami</span>
                    <span class="sm:hidden font-medium">WhatsApp</span>
                </a>

                <!-- 2. Tombol Hamburger Menu (Buka Drawer Navigasi) -->
                <button @click="sidebarOpen = true" 
                        type="button" 
                        class="w-9 h-9 flex items-center justify-center rounded-lg border border-slate-700 bg-slate-800/80 hover:bg-slate-700 text-slate-300 hover:text-white transition-colors cursor-pointer active:scale-95 focus-visible:outline-hidden focus-visible:ring-2 focus-visible:ring-sky-500"
                        aria-label="Buka Menu Navigasi"
                        aria-controls="mobile-drawer"
                        :aria-expanded="sidebarOpen ? 'true' : 'false'">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
            </div>
        </div>
    </div>
</header>
