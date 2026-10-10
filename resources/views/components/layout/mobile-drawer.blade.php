<dialog x-cloak x-ref="drawerDialog" id="mobile-drawer"
     @cancel.prevent="sidebarOpen = false"
     @close="if (!$el.open) sidebarOpen = false"
     @resize.window="if (window.innerWidth >= 1024) sidebarOpen = false"
     @keydown.tab="trapDrawerFocus($event)"
     x-data="{
         trigger: null,
         rootOverflow: '',
         bodyOverflow: '',
         trapDrawerFocus(e) {
             const drawerEl = $refs.drawerPanel;
             if (!drawerEl) return;
             const focusables = Array.from(drawerEl.querySelectorAll('button:not([disabled]), [href], input:not([disabled]), select:not([disabled]), textarea:not([disabled]), [tabindex]:not([tabindex=\'-1\'])'))
                 .filter(el => el.offsetParent !== null && window.getComputedStyle(el).visibility !== 'hidden');
             if (focusables.length === 0) return;
             const first = focusables[0];
             const last = focusables[focusables.length - 1];
             if (e.shiftKey) {
                 if (document.activeElement === first || !drawerEl.contains(document.activeElement)) {
                     last.focus();
                     e.preventDefault();
                 }
             } else {
                 if (document.activeElement === last || !drawerEl.contains(document.activeElement)) {
                     first.focus();
                     e.preventDefault();
                 }
             }
         }
     }"
     x-init="$watch('sidebarOpen', value => {
         if (value) {
             trigger = document.activeElement;
             rootOverflow = document.documentElement.style.overflow;
             bodyOverflow = document.body.style.overflow;
             document.documentElement.style.overflow = 'hidden';
             document.body.style.overflow = 'hidden';
             $nextTick(() => {
                 if (!sidebarOpen) return;
                 $refs.drawerDialog.showModal();
                 $refs.closeButton.focus();
             });
         } else {
             if ($refs.drawerDialog.open) $refs.drawerDialog.close();
             document.documentElement.style.overflow = rootOverflow;
             document.body.style.overflow = bodyOverflow;
             if (trigger?.isConnected) trigger.focus({ preventScroll: true });
         }
     })"
     class="fixed inset-0 z-60 lg:hidden"
     style="margin: 0; width: 100%; height: 100%; max-width: none; max-height: none; padding: 0; border: 0; background: transparent"
     aria-labelledby="mobile-drawer-title">

    <!-- Backdrop overlay -->
    <div x-show="sidebarOpen"
         x-transition:enter="transition-opacity ease-linear duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition-opacity ease-linear duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         @click="sidebarOpen = false"
         class="fixed inset-0 bg-slate-900/60 backdrop-blur-xs"
         aria-hidden="true"></div>

    <!-- Slide-in Drawer Container -->
    <div x-ref="drawerPanel"
         x-show="sidebarOpen"
         x-transition:enter="transition ease-in-out duration-300 transform"
         x-transition:enter-start="translate-x-full"
         x-transition:enter-end="translate-x-0"
         x-transition:leave="transition ease-in-out duration-200 transform"
         x-transition:leave-start="translate-x-0"
         x-transition:leave-end="translate-x-full"
         class="fixed inset-y-0 right-0 max-w-xs w-full bg-white border-l border-slate-200 shadow-2xl flex flex-col justify-between overflow-hidden">
        
       
        <div class="flex items-center justify-between px-5 py-3.5 border-b border-slate-200 shrink-0 bg-slate-300">
            <h2 id="mobile-drawer-title" class="min-w-0 pr-3">
                <img src="{{ asset('images/logo/TEKSBRAND-TAGLINE.webp') }}" srcset="{{ asset('images/logo/TEKSBRAND-TAGLINE-224.webp') }} 224w, {{ asset('images/logo/TEKSBRAND-TAGLINE-448.webp') }} 448w, {{ asset('images/logo/TEKSBRAND-TAGLINE.webp') }} 1198w" sizes="224px" alt="Drainusantara — Menu &amp; Layanan" class="block h-auto w-52 max-w-full object-contain" width="1198" height="208">
            </h2>
            <button @click="sidebarOpen = false" 
                    x-ref="closeButton"
                    type="button"
                    class="w-11 h-11 flex items-center justify-center text-slate-500 hover:text-slate-800 rounded-lg hover:bg-slate-100 focus:outline-hidden focus:ring-2 focus:ring-sky-600 transition-colors btn-press cursor-pointer" 
                    aria-label="Tutup menu navigasi">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

       
        <div class="flex-1 overflow-y-auto px-4 py-3 flex flex-col justify-start space-y-1">
            <!-- 1. Beranda -->
            <a href="{{ route('home') }}" 
               @click="sidebarOpen = false" 
               class="flex items-center justify-between px-3.5 py-2.5 rounded-lg transition-all btn-press min-h-11 focus:outline-hidden focus:ring-2 focus:ring-sky-600 {{ request()->routeIs('home') && !request()->is('galeri*') && !request()->is('artikel*') && !request()->is('pengetahuan*') && !request()->is('area*') && !request()->is('tentang-kami*') ? 'bg-sky-50 text-sky-800 font-bold border border-sky-200/80' : 'text-slate-700 hover:text-sky-700 hover:bg-slate-50 active:bg-sky-50 border border-transparent' }}">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-md bg-sky-50 text-sky-700 flex items-center justify-center shrink-0 border border-sky-100" aria-hidden="true">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                        </svg>
                    </div>
                    <span class="text-sm font-semibold">Beranda</span>
                </div>
                <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
            </a>

          
            <a href="{{ route('gallery') }}" 
               @click="sidebarOpen = false" 
               class="flex items-center justify-between px-3.5 py-2.5 rounded-lg transition-all btn-press min-h-11 focus:outline-hidden focus:ring-2 focus:ring-sky-600 {{ request()->is('galeri*') ? 'bg-sky-50 text-sky-800 font-bold border border-sky-200/80' : 'text-slate-700 hover:text-sky-700 hover:bg-slate-50 active:bg-sky-50 border border-transparent' }}">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-md bg-sky-50 text-sky-700 flex items-center justify-center shrink-0 border border-sky-100" aria-hidden="true">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <span class="text-sm font-semibold">Hasil Kerja &amp; Dokumentasi</span>
                </div>
                <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
            </a>

            
            <a href="{{ route('about.warranty') }}" 
               @click="sidebarOpen = false" 
               class="flex items-center justify-between px-3.5 py-2.5 rounded-lg transition-all btn-press min-h-11 focus:outline-hidden focus:ring-2 focus:ring-sky-600 {{ request()->routeIs('about.warranty') ? 'bg-sky-50 text-sky-800 font-bold border border-sky-200/80' : 'text-slate-700 hover:text-sky-700 hover:bg-slate-50 active:bg-sky-50 border border-transparent' }}">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-md bg-sky-50 text-sky-700 flex items-center justify-center shrink-0 border border-sky-100" aria-hidden="true">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                        </svg>
                    </div>
                    <div>
                        <span class="text-sm font-semibold block leading-tight">Garansi 30 Hari</span>
                        <span class="text-xs text-slate-500 font-normal">Ketentuan nota tertulis resmi</span>
                    </div>
                </div>
                <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
            </a>

           
            <a href="{{ route('about.faq') }}" 
               @click="sidebarOpen = false" 
               class="flex items-center justify-between px-3.5 py-2.5 rounded-lg transition-all btn-press min-h-11 focus:outline-hidden focus:ring-2 focus:ring-sky-600 {{ request()->routeIs('about.faq') ? 'bg-sky-50 text-sky-800 font-bold border border-sky-200/80' : 'text-slate-700 hover:text-sky-700 hover:bg-slate-50 active:bg-sky-50 border border-transparent' }}">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-md bg-sky-50 text-sky-700 flex items-center justify-center shrink-0 border border-sky-100" aria-hidden="true">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <span class="text-sm font-semibold">Tanya Jawab (FAQ)</span>
                </div>
                <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
            </a>

           
            <a href="{{ route('articles.index') }}" 
               @click="sidebarOpen = false" 
               class="flex items-center justify-between px-3.5 py-2.5 rounded-lg transition-all btn-press min-h-11 focus:outline-hidden focus:ring-2 focus:ring-sky-600 {{ request()->is('artikel*') || request()->is('pengetahuan*') ? 'bg-sky-50 text-sky-800 font-bold border border-sky-200/80' : 'text-slate-700 hover:text-sky-700 hover:bg-slate-50 active:bg-sky-50 border border-transparent' }}">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-md bg-sky-50 text-sky-700 flex items-center justify-center shrink-0 border border-sky-100" aria-hidden="true">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                        </svg>
                    </div>
                    <span class="text-sm font-semibold">Edukasi &amp; Tips Saluran</span>
                </div>
                <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
            </a>

            <!-- 8. Profil Perusahaan & Legalitas (Accordion Ringkas untuk Info Korporat) -->
            <div class="rounded-lg border border-transparent transition-all mt-1"
                 :class="{ 'bg-slate-50 border-slate-200/80 p-1': tentangDrawerOpen }">
                <button type="button" 
                        @click="tentangDrawerOpen = !tentangDrawerOpen"
                        aria-expanded="false" :aria-expanded="tentangDrawerOpen"
                        aria-controls="drawer-company-links"
                        class="w-full flex items-center justify-between px-3.5 py-2.5 rounded-lg text-slate-700 hover:text-sky-700 hover:bg-slate-50 active:bg-sky-50 transition-all btn-press min-h-11 cursor-pointer focus:outline-hidden focus:ring-2 focus:ring-sky-600"
                        :class="{ 'text-sky-700 font-bold bg-sky-50/70': tentangDrawerOpen || {{ request()->routeIs('about*') && !request()->routeIs('about.warranty') && !request()->routeIs('about.faq') ? 'true' : 'false' }} }">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-md bg-slate-100 text-slate-600 flex items-center justify-center shrink-0 border border-slate-200" aria-hidden="true">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                            </svg>
                        </div>
                        <span class="text-sm font-semibold">Profil &amp; Legalitas Usaha</span>
                    </div>
                    <svg class="w-4 h-4 text-slate-400 transition-transform duration-200" :class="{ 'rotate-180 text-sky-700': tentangDrawerOpen }" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>

                <!-- Sub-items Korporat -->
                <div id="drawer-company-links" x-cloak x-show="tentangDrawerOpen" class="pt-1 pb-1 pl-3 pr-1 space-y-0.5 border-t border-slate-200/70 mt-1">
                    <a href="{{ route('about.profile') }}" 
                       @click="sidebarOpen = false" 
                       class="flex items-center px-3 py-2 rounded-md text-xs font-semibold text-slate-700 hover:text-sky-700 hover:bg-white active:bg-sky-50 min-h-11 transition-colors focus:outline-hidden focus:ring-2 focus:ring-sky-600">
                        <span>Profil Perusahaan</span>
                    </a>

                    <a href="{{ route('about.holding') }}" 
                       @click="sidebarOpen = false" 
                       class="flex items-center px-3 py-2 rounded-md text-xs font-semibold text-slate-700 hover:text-sky-700 hover:bg-white active:bg-sky-50 min-h-11 transition-colors focus:outline-hidden focus:ring-2 focus:ring-sky-600">
                        <span>Struktur Holding J&amp;J Group</span>
                    </a>

                    <a href="{{ route('about.k3') }}" 
                       @click="sidebarOpen = false" 
                       class="flex items-center px-3 py-2 rounded-md text-xs font-semibold text-slate-700 hover:text-sky-700 hover:bg-white active:bg-sky-50 min-h-11 transition-colors focus:outline-hidden focus:ring-2 focus:ring-sky-600">
                        <span>Standar Operasional &amp; SOP K3</span>
                    </a>

                    <a href="{{ route('about.equipment') }}" 
                       @click="sidebarOpen = false" 
                       class="flex items-center px-3 py-2 rounded-md text-xs font-semibold text-slate-700 hover:text-sky-700 hover:bg-white active:bg-sky-50 min-h-11 transition-colors focus:outline-hidden focus:ring-2 focus:ring-sky-600">
                        <span>Peralatan &amp; Mesin Rooter</span>
                    </a>

                    <a href="{{ route('about.portfolio') }}" 
                       @click="sidebarOpen = false" 
                       class="flex items-center px-3 py-2 rounded-md text-xs font-semibold text-slate-700 hover:text-sky-700 hover:bg-white active:bg-sky-50 min-h-11 transition-colors focus:outline-hidden focus:ring-2 focus:ring-sky-600">
                        <span>Portofolio Klien &amp; B2B</span>
                    </a>
                </div>
            </div>
        </div>

        <!-- C. Ergonomic Sticky Bottom Zone -->
        <div class="p-4 border-t border-slate-200 bg-slate-50/95 backdrop-blur-xs space-y-2 shrink-0 pb-safe pb-4">
            <!-- 1. Primary Action: WhatsApp Siaga Darurat (48px Touch Target, WCAG AAA Contrast) -->
            <a href="https://wa.me/{{ config('app.whatsapp_number') ?: '6281234567890' }}?text={{ rawurlencode('Halo Admin Drainusantara, saluran air di rumah saya sedang mampet. Mohon info teknisi terdekat.') }}"
                       :href="'https://wa.me/' + whatsappNumber + '?text=' + encodeURIComponent('Halo Admin Drainusantara, saluran air di rumah saya sedang mampet. Mohon info teknisi terdekat.')"
               target="_blank" 
               rel="noopener noreferrer" 
               class="w-full flex items-center justify-center gap-2 bg-emerald-700 hover:bg-emerald-800 text-white font-bold h-12 px-4 rounded-xl shadow-xs transition-colors text-sm btn-press focus:outline-hidden focus:ring-2 focus:ring-emerald-600 focus:ring-offset-2">
                <svg class="w-4 h-4 fill-current shrink-0" viewBox="0 0 24 24" aria-hidden="true">
                    <path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/>
                </svg>
                <span>Hubungi Teknisi Siaga 24 Jam</span>
            </a>

            <!-- 2. Thumb-Friendly Close Button (Direct Ergonomic Dismiss) -->
            <button @click="sidebarOpen = false" 
                    type="button" 
                    class="w-full flex items-center justify-center gap-1.5 h-11 rounded-xl bg-white border border-slate-300 text-slate-700 hover:bg-slate-100 hover:text-slate-900 font-bold text-xs transition-colors btn-press cursor-pointer focus:outline-hidden focus:ring-2 focus:ring-sky-600">
                <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
                <span>Tutup Menu</span>
            </button>
        </div>
    </div>
</dialog>
