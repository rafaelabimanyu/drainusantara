<div x-cloak x-show="mobileSearchOpen" class="fixed inset-0 z-[60] md:hidden" role="dialog" aria-modal="true">
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
         class="fixed inset-x-0 bottom-0 max-h-[85vh] bg-white rounded-t-2xl border-t border-slate-200 p-5 shadow-2xl flex flex-col overflow-hidden pb-4">
        <template x-if="mobileSearchOpen">
            <div class="flex flex-col flex-1 overflow-hidden">
                <!-- Sheet Grab Bar Handle -->
                <div class="w-12 h-1.5 bg-slate-300 rounded-full mx-auto mb-3 shrink-0"></div>

                <div class="flex items-center justify-between pb-3 border-b border-slate-200">
                    <div class="flex items-center gap-2">
                        <div class="w-7 h-7 rounded-lg bg-sky-50 text-sky-700 border border-sky-100 flex items-center justify-center">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                        </div>
                        <div>
                            <span class="font-extrabold text-slate-900 text-sm block leading-tight">Quick Area Finder</span>
                            <span class="text-[10px] text-slate-500 font-medium">Cari armada teknisi siaga di kota Anda</span>
                        </div>
                    </div>
                    <button @click="mobileSearchOpen = false" class="p-2 text-slate-400 hover:text-slate-700 rounded-lg hover:bg-slate-100 btn-press cursor-pointer" aria-label="Tutup pencarian">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>

                <!-- Search Input with Clear Button -->
                <div class="mt-3 relative">
                    <input type="text"
                           x-model="areaSearch"
                           placeholder="Ketik nama kota atau kecamatan (contoh: Ciracas, Tebet)..."
                           class="w-full bg-slate-50 border border-slate-300 rounded-xl pl-9 pr-10 py-2.5 text-xs text-slate-800 focus:outline-hidden focus:border-sky-700 transition-colors">
                    <svg class="w-4 h-4 text-slate-400 absolute left-3 top-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                    <button x-show="areaSearch" 
                            @click="areaSearch = ''" 
                            type="button" 
                            class="absolute right-2.5 top-2.5 p-1 text-slate-400 hover:text-slate-700 transition-colors cursor-pointer"
                            aria-label="Hapus kata kunci pencarian">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <!-- Result List with Generous Bottom Clearance (Anti-Overlap) -->
                <div class="mt-3 overflow-y-auto space-y-2 flex-1 max-h-[50vh] pr-1 pb-4">
                    <template x-for="area in areas" :key="area.url">
                        <a :href="area.url" 
                           @click="mobileSearchOpen = false" 
                           x-show="filterArea(area)"
                           class="block p-3.5 rounded-xl bg-slate-50 border border-slate-200/90 hover:border-sky-400 hover:bg-white transition-all btn-press">
                            <div class="flex items-center justify-between gap-2">
                                <div class="flex items-center gap-2 min-w-0">
                                    <span class="text-[9px] font-bold px-2 py-0.5 rounded-md shrink-0"
                                          :class="{
                                              'bg-sky-100 text-sky-800 border border-sky-200': area.type === 'Provinsi',
                                              'bg-indigo-100 text-indigo-800 border border-indigo-200': area.type === 'Kota',
                                              'bg-emerald-100 text-emerald-800 border border-emerald-200': area.type === 'Kecamatan'
                                          }"
                                          x-text="area.badge"></span>
                                    <span class="text-xs font-bold text-slate-900 truncate" x-text="area.name"></span>
                                </div>
                                <span class="text-[10px] font-semibold text-emerald-700 bg-emerald-50 border border-emerald-200/60 px-2 py-0.5 rounded-md shrink-0" x-text="area.eta"></span>
                            </div>
                            <p class="text-[11px] text-slate-500 mt-1 line-clamp-1" x-html="area.subtitle"></p>
                        </a>
                    </template>
                    <div x-show="areas.filter(a => filterArea(a)).length === 0" 
                         class="py-8 text-center text-xs text-slate-500">
                        Wilayah tidak ditemukan. Hubungi hotline kami untuk konfirmasi teknisi di area Anda.
                    </div>
                </div>

                <!-- Sticky Bottom Thumb Close Bar (Thumb-Friendly) -->
                <div class="pt-3 mt-2 border-t border-slate-200 shrink-0">
                    <button @click="mobileSearchOpen = false" 
                            type="button" 
                            class="w-full flex items-center justify-center gap-1.5 h-11 rounded-xl bg-slate-100 hover:bg-slate-200 border border-slate-300 text-slate-700 hover:text-slate-900 font-bold text-xs transition-colors btn-press cursor-pointer">
                        <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                        <span>Tutup Pencarian</span>
                    </button>
                </div>
            </div>
        </template>
    </div>
</div>

<!-- Searchable Areas JSON (Evaluated on-demand by Alpine, non-render-blocking) -->
<script type="application/json" id="drainusantara-areas-data">
    {!! json_encode(\App\Services\RegionService::getSearchableItems(), JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}
</script>
