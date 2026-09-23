<!-- ====================================================================
     B. SMART MEGA MENU: CAKUPAN WILAYAH (QUICK AREA FINDER INTERAKTIF)
==================================================================== -->
<div x-cloak 
     x-show="activeMenu === 'wilayah'"
     x-transition:enter="transition ease-out duration-200"
     x-transition:enter-start="opacity-0 -translate-y-2"
     x-transition:enter-end="opacity-100 translate-y-0"
     x-transition:leave="transition ease-in duration-150"
     x-transition:leave-start="opacity-100 translate-y-0"
     x-transition:leave-end="opacity-0 -translate-y-2"
     class="absolute top-full inset-x-0 bg-white/98 backdrop-blur-md border-b border-slate-200/90 shadow-lg py-6 hidden md:block rounded-b-2xl">
    <template x-if="activeMenu === 'wilayah'">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between pb-3 mb-4 border-b border-slate-200">
                <div>
                    <span class="text-xs font-mono font-bold text-blue-700 uppercase tracking-wider block">QUICK AREA DISPATCH FINDER</span>
                    <span class="text-xs text-slate-500">Filter lokasi kota atau kecamatan untuk konfirmasi armada siaga:</span>
                </div>
                <!-- Mini Search Bar Input -->
                <div class="w-80 relative">
                    <input type="text" 
                           x-model="areaSearch" 
                           placeholder="Ketik kota/kecamatan (contoh: Tebet, Serpong)..." 
                           class="w-full bg-slate-50 border border-slate-300 rounded-xl pl-9 pr-3 py-2 text-xs font-mono text-slate-800 focus:outline-hidden focus:border-blue-700 transition-colors">
                    <svg class="w-4 h-4 text-slate-400 absolute left-3 top-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>
            </div>

            <!-- Filtered Result Cards Grid -->
            <div class="grid grid-cols-4 gap-3 max-h-72 overflow-y-auto pr-1">
                <template x-for="area in areas" :key="area.url">
                    <a :href="area.url" 
                       @click="activeMenu = null"
                       x-show="filterArea(area)"
                       class="p-3.5 rounded-xl bg-slate-50 hover:bg-white border border-slate-200/80 hover:border-blue-400 hover:shadow-xs transition-all block group">
                        <div class="flex items-center justify-between mb-1.5 gap-2">
                            <div class="flex items-center gap-1.5 min-w-0">
                                <span class="text-[9px] font-mono font-bold px-1.5 py-0.5 rounded-full shrink-0"
                                      :class="{
                                          'bg-blue-100 text-blue-800 border border-blue-200': area.type === 'Provinsi',
                                          'bg-slate-200 text-slate-800 border border-slate-300': area.type === 'Kota',
                                          'bg-emerald-100 text-emerald-800 border border-emerald-200': area.type === 'Kecamatan'
                                      }"
                                      x-text="area.badge"></span>
                                <span class="text-xs font-bold text-slate-900 group-hover:text-blue-700 truncate" x-text="area.name"></span>
                            </div>
                            <span class="text-[9px] font-mono text-emerald-700 font-bold bg-emerald-50 px-2 py-0.5 rounded-full shrink-0" x-text="area.eta"></span>
                        </div>
                        <p class="text-[11px] text-slate-500 line-clamp-1" x-html="area.subtitle"></p>
                    </a>
                </template>
            </div>

            <!-- Empty State if search matches nothing -->
            <div x-show="areas.filter(a => filterArea(a)).length === 0" 
                 class="py-6 text-center text-xs text-slate-500 font-mono">
                Wilayah tidak ditemukan dalam daftar cepat. Hubungi hotline kami untuk konfirmasi armada di area Anda.
            </div>
        </div>
    </template>
</div>
