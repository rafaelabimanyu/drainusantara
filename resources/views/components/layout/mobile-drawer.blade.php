<div x-cloak x-show="sidebarOpen" class="fixed inset-0 z-[60] md:hidden" role="dialog" aria-modal="true">
    <div x-show="sidebarOpen"
         x-transition:enter="transition-opacity ease-linear duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition-opacity ease-linear duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         @click="sidebarOpen = false"
         class="fixed inset-0 bg-slate-900/60 backdrop-blur-xs"></div>

    <div x-show="sidebarOpen"
         x-transition:enter="transition ease-in-out duration-300 transform"
         x-transition:enter-start="translate-x-full"
         x-transition:enter-end="translate-x-0"
         x-transition:leave="transition ease-in-out duration-200 transform"
         x-transition:leave-start="translate-x-0"
         x-transition:leave-end="translate-x-full"
         class="fixed inset-y-0 right-0 max-w-xs w-full bg-white border-l border-slate-200 shadow-2xl flex flex-col justify-between overflow-hidden">
        
        <!-- A. Top Header (Simple Brand + Secondary Close) -->
        <div class="flex items-center justify-between px-5 py-4 border-b border-slate-200 shrink-0 bg-white">
            <div class="flex items-center gap-2.5">
                <div class="w-8 h-8 rounded-xl bg-sky-700 text-white flex items-center justify-center font-extrabold text-xs shadow-xs">
                    DN
                </div>
                <div>
                    <span class="font-extrabold text-slate-900 tracking-tight block text-sm leading-tight">DRAINUSANTARA</span>
                    <span class="text-[10px] text-slate-500 font-medium block">Menu Navigasi</span>
                </div>
            </div>
            <button @click="sidebarOpen = false" class="p-2 text-slate-400 hover:text-slate-700 rounded-xl hover:bg-slate-100 focus:outline-hidden transition-colors btn-press cursor-pointer" aria-label="Tutup menu">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <!-- B. Thumb-Friendly Middle Navigation (Stacked Right Above Bottom CTA) -->
        <div class="flex-1 overflow-y-auto px-4 py-3 flex flex-col justify-end space-y-1.5">
            <!-- 1. Beranda -->
            <a href="{{ route('home') }}" 
               @click="sidebarOpen = false" 
               class="flex items-center justify-between px-3.5 py-3 rounded-xl transition-all btn-press min-h-[48px] {{ request()->routeIs('home') && !request()->is('galeri*') && !request()->is('artikel*') && !request()->is('pengetahuan*') && !request()->is('area*') ? 'bg-sky-50 text-sky-800 font-bold border border-sky-200/80 shadow-2xs' : 'text-slate-700 hover:text-sky-700 hover:bg-slate-50 active:bg-sky-50 border border-transparent' }}">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-lg bg-sky-50 text-sky-700 flex items-center justify-center shrink-0 border border-sky-100/60">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                        </svg>
                    </div>
                    <span class="text-xs font-bold">Beranda</span>
                </div>
                <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
            </a>

            <!-- 2. Tentang kami (Collapsible Accordion in Drawer) -->
            <div class="rounded-xl border border-transparent transition-all"
                 :class="{ 'bg-slate-50/80 border-slate-200/70 p-1': tentangDrawerOpen }">
                <button type="button" 
                        @click="tentangDrawerOpen = !tentangDrawerOpen"
                        class="w-full flex items-center justify-between px-3.5 py-3 rounded-xl text-slate-700 hover:text-sky-700 hover:bg-slate-50 active:bg-sky-50 transition-all btn-press min-h-[48px] cursor-pointer"
                        :class="{ 'text-sky-700 font-bold bg-sky-50/60': tentangDrawerOpen || {{ request()->routeIs('about') ? 'true' : 'false' }} }">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-lg bg-sky-50 text-sky-700 flex items-center justify-center shrink-0 border border-sky-100/60">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                            </svg>
                        </div>
                        <span class="text-xs font-bold">Tentang kami</span>
                    </div>
                    <svg class="w-4 h-4 text-slate-400 transition-transform duration-200" :class="{ 'rotate-180 text-sky-700': tentangDrawerOpen }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>

                <!-- Accordion Sub-items (Clean, No Pills) -->
                <div x-cloak x-show="tentangDrawerOpen" x-collapse class="pt-1 pb-1.5 pl-3 pr-1 space-y-1 border-t border-slate-200/60 mt-1">
                    <!-- 1. Struktur Holding J&J Group -->
                    <a href="{{ route('about.holding') }}" 
                       @click="sidebarOpen = false" 
                       class="flex items-center px-3 py-2.5 rounded-lg text-xs font-semibold text-slate-700 hover:text-sky-700 hover:bg-white active:bg-sky-50 min-h-[44px] transition-colors">
                        <span>Struktur Holding J&amp;J Group</span>
                    </a>

                    <!-- 2. SOP K3 -->
                    <a href="{{ route('about.k3') }}" 
                       @click="sidebarOpen = false" 
                       class="flex items-center px-3 py-2.5 rounded-lg text-xs font-semibold text-slate-700 hover:text-sky-700 hover:bg-white active:bg-sky-50 min-h-[44px] transition-colors">
                        <span>SOP K3</span>
                    </a>

                    <!-- 3. Profil Perusahaan -->
                    <a href="{{ route('about.profile') }}" 
                       @click="sidebarOpen = false" 
                       class="flex items-center px-3 py-2.5 rounded-lg text-xs font-semibold text-slate-700 hover:text-sky-700 hover:bg-white active:bg-sky-50 min-h-[44px] transition-colors">
                        <span>Profil Perusahaan</span>
                    </a>

                    <!-- 4. Peralatan & Teknologi -->
                    <a href="{{ route('about.equipment') }}" 
                       @click="sidebarOpen = false" 
                       class="flex items-center px-3 py-2.5 rounded-lg text-xs font-semibold text-slate-700 hover:text-sky-700 hover:bg-white active:bg-sky-50 min-h-[44px] transition-colors">
                        <span>Peralatan &amp; Teknologi</span>
                    </a>

                    <!-- 5. Klien / Portofolio (Perusahaan Yang Menggunakan Jasa Kami) -->
                    <a href="{{ route('about.portfolio') }}" 
                       @click="sidebarOpen = false" 
                       class="flex items-center px-3 py-2.5 rounded-lg text-xs font-semibold text-slate-700 hover:text-sky-700 hover:bg-white active:bg-sky-50 min-h-[44px] transition-colors">
                        <span>Perusahaan &amp; Portofolio Klien</span>
                    </a>

                    <!-- 6. Ketentuan Garansi 30 Hari -->
                    <a href="{{ route('about.warranty') }}" 
                       @click="sidebarOpen = false" 
                       class="flex items-center px-3 py-2.5 rounded-lg text-xs font-semibold text-slate-700 hover:text-sky-700 hover:bg-white active:bg-sky-50 min-h-[44px] transition-colors">
                        <span>Ketentuan Garansi 30 Hari</span>
                    </a>

                    <!-- 7. FAQ -->
                    <a href="{{ route('about.faq') }}" 
                       @click="sidebarOpen = false" 
                       class="flex items-center px-3 py-2.5 rounded-lg text-xs font-semibold text-slate-700 hover:text-sky-700 hover:bg-white active:bg-sky-50 min-h-[44px] transition-colors">
                        <span>FAQ</span>
                    </a>
                </div>
            </div>

            <!-- 3. Layanan -->
            <a href="{{ url('/#layanan') }}" 
               @click="sidebarOpen = false" 
               class="flex items-center justify-between px-3.5 py-3 rounded-xl text-slate-700 hover:text-sky-700 hover:bg-slate-50 active:bg-sky-50 transition-all btn-press min-h-[48px] border border-transparent">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-lg bg-sky-50 text-sky-700 flex items-center justify-center shrink-0 border border-sky-100/60">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                    </div>
                    <span class="text-xs font-bold">Layanan</span>
                </div>
                <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
            </a>

            <!-- 4. Hasil kerja -->
            <a href="{{ route('gallery') }}" 
               @click="sidebarOpen = false" 
               class="flex items-center justify-between px-3.5 py-3 rounded-xl transition-all btn-press min-h-[48px] {{ request()->is('galeri*') ? 'bg-sky-50 text-sky-800 font-bold border border-sky-200/80 shadow-2xs' : 'text-slate-700 hover:text-sky-700 hover:bg-slate-50 active:bg-sky-50 border border-transparent' }}">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-lg bg-sky-50 text-sky-700 flex items-center justify-center shrink-0 border border-sky-100/60">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <span class="text-xs font-bold">Hasil kerja</span>
                </div>
                <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
            </a>

            <!-- 5. Area Jangkauan -->
            <button type="button" 
                    @click="sidebarOpen = false; mobileSearchOpen = true" 
                    class="w-full flex items-center justify-between px-3.5 py-3 rounded-xl text-slate-700 hover:text-sky-700 hover:bg-slate-50 active:bg-sky-50 transition-all btn-press min-h-[48px] border border-transparent text-left cursor-pointer">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-lg bg-sky-50 text-sky-700 flex items-center justify-center shrink-0 border border-sky-100/60">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                    </div>
                    <div>
                        <span class="text-xs font-bold block leading-tight">Area Jangkauan</span>
                        <span class="text-[10px] text-slate-500 font-medium">Cari armada teknisi siaga</span>
                    </div>
                </div>
                <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
            </button>

            <!-- 6. Edukasi -->
            <a href="{{ route('articles.index') }}" 
               @click="sidebarOpen = false" 
               class="flex items-center justify-between px-3.5 py-3 rounded-xl transition-all btn-press min-h-[48px] {{ request()->is('artikel*') || request()->is('pengetahuan*') ? 'bg-sky-50 text-sky-800 font-bold border border-sky-200/80 shadow-2xs' : 'text-slate-700 hover:text-sky-700 hover:bg-slate-50 active:bg-sky-50 border border-transparent' }}">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-lg bg-sky-50 text-sky-700 flex items-center justify-center shrink-0 border border-sky-100/60">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                        </svg>
                    </div>
                    <span class="text-xs font-bold">Edukasi</span>
                </div>
                <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
            </a>
        </div>

        <!-- C. Sticky Bottom Thumb Action Zone -->
        <div class="p-4 border-t border-slate-200 bg-slate-50/95 backdrop-blur-xs space-y-2 shrink-0 pb-safe pb-4">
            <!-- 1. Primary Action: WhatsApp Siaga Darurat (48px Touch Target) -->
            <a :href="'https://wa.me/' + whatsappNumber + '?text=' + encodeURIComponent('Halo Admin Drainusantara, saluran air di rumah saya sedang mampet. Mohon info teknisi terdekat.')" 
               target="_blank" 
               rel="noopener noreferrer" 
               class="w-full flex items-center justify-center gap-2 bg-emerald-600 hover:bg-emerald-700 text-white font-bold h-12 px-4 rounded-xl shadow-xs transition-colors text-xs sm:text-sm btn-press">
                <svg class="w-4 h-4 fill-current shrink-0" viewBox="0 0 24 24">
                    <path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/>
                </svg>
                <span>Hubungi Teknisi Siaga 24 Jam</span>
            </a>

            <!-- 2. Thumb-Friendly Close Button (Direct Ergonomic Dismiss) -->
            <button @click="sidebarOpen = false" 
                    type="button" 
                    class="w-full flex items-center justify-center gap-1.5 h-11 rounded-xl bg-white border border-slate-300 text-slate-700 hover:bg-slate-100 hover:text-slate-900 font-bold text-xs transition-colors btn-press cursor-pointer">
                <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
                <span>Tutup Menu</span>
            </button>
        </div>
    </div>
</div>
