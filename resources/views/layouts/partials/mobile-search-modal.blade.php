<!-- ====================================================================
     MOBILE QUICK AREA FINDER (SLIDE-UP SHEET MODAL)
==================================================================== -->
<div x-cloak x-show="mobileSearchOpen" class="fixed inset-0 z-50 md:hidden" role="dialog" aria-modal="true">
    <div x-show="mobileSearchOpen"
         x-transition:enter="transition-opacity ease-linear duration-200"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition-opacity ease-linear duration-150"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         @click="mobileSearchOpen = false"
         class="fixed inset-0 bg-slate-900/60 backdrop-blur-xs"></div>

    <div x-show="mobileSearchOpen"
         x-transition:enter="transition ease-out duration-300 transform"
         x-transition:enter-start="translate-y-full"
         x-transition:enter-end="translate-y-0"
         x-transition:leave="transition ease-in duration-200 transform"
         x-transition:leave-start="translate-y-0"
         x-transition:leave-end="translate-y-full"
         class="fixed inset-x-0 bottom-0 max-h-[82vh] bg-white rounded-t-2xl border-t border-slate-200 p-5 shadow-2xl flex flex-col overflow-hidden">
        <template x-if="mobileSearchOpen">
            <div class="flex flex-col flex-1 overflow-hidden">
                <div class="flex items-center justify-between pb-3 border-b border-slate-200">
                    <div class="flex items-center gap-2">
                        <svg class="w-4 h-4 text-blue-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                        <span class="font-extrabold text-slate-900 text-sm">Quick Area Dispatch</span>
                    </div>
                    <button @click="mobileSearchOpen = false" class="p-1.5 text-slate-400 hover:text-slate-700" aria-label="Tutup pencarian">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>

                <div class="mt-3">
                    <input type="text"
                           x-model="areaSearch"
                           placeholder="Ketik nama kota atau kecamatan..."
                           class="w-full bg-slate-50 border border-slate-300 rounded-xl px-3.5 py-2 text-xs font-mono text-slate-800 focus:outline-hidden focus:border-blue-700">
                </div>

                <div class="mt-3 overflow-y-auto space-y-2 flex-1 max-h-[50vh] pr-1">
                    <template x-for="area in areas" :key="area.url">
                        <a :href="area.url" 
                           @click="mobileSearchOpen = false"
                           x-show="filterArea(area)"
                           class="block p-3 rounded-xl bg-slate-50 border border-slate-200 hover:border-blue-400 transition-colors">
                            <div class="flex items-center justify-between gap-2">
                                <div class="flex items-center gap-1.5 min-w-0">
                                    <span class="text-[9px] font-mono font-bold px-1.5 py-0.5 rounded-full shrink-0"
                                          :class="{
                                              'bg-blue-100 text-blue-800 border border-blue-200': area.type === 'Provinsi',
                                              'bg-slate-200 text-slate-800 border border-slate-300': area.type === 'Kota',
                                              'bg-emerald-100 text-emerald-800 border border-emerald-200': area.type === 'Kecamatan'
                                          }"
                                          x-text="area.badge"></span>
                                    <span class="text-xs font-bold text-slate-900 truncate" x-text="area.name"></span>
                                </div>
                                <span class="text-[10px] font-mono font-bold text-emerald-700 bg-emerald-50 px-1.5 py-0.5 rounded-full shrink-0" x-text="area.eta"></span>
                            </div>
                            <p class="text-[11px] text-slate-500 mt-1 line-clamp-1" x-html="area.subtitle"></p>
                        </a>
                    </template>
                    <div x-show="areas.filter(a => filterArea(a)).length === 0" 
                         class="py-6 text-center text-xs text-slate-500 font-mono">
                        Wilayah tidak ditemukan. Hubungi hotline kami untuk konfirmasi armada di area Anda.
                    </div>
                </div>
            </div>
        </template>
    </div>
</div>
