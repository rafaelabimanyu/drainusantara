<!-- ====================================================================
     A. SMART MEGA MENU: LAYANAN (GRID 4 + INTERACTIVE DIAGNOSTIC WIDGET)
==================================================================== -->
<div x-cloak 
     x-show="activeMenu === 'layanan'"
     x-transition:enter="transition ease-out duration-200"
     x-transition:enter-start="opacity-0 -translate-y-2"
     x-transition:enter-end="opacity-100 translate-y-0"
     x-transition:leave="transition ease-in duration-150"
     x-transition:leave-start="opacity-100 translate-y-0"
     x-transition:leave-end="opacity-0 -translate-y-2"
     class="absolute top-full inset-x-0 bg-white/98 backdrop-blur-md border-b border-slate-200/90 shadow-lg py-6 hidden md:block rounded-b-2xl">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-12 gap-8 items-stretch">
            
            <!-- Sisi Kiri: Grid 4 Divisi Spesialisasi -->
            <div class="col-span-7 pr-6 border-r border-slate-200/80">
                <div class="flex items-center justify-between pb-3 mb-4 border-b border-slate-100">
                    <span class="text-xs font-mono font-bold text-blue-700 uppercase tracking-wider">
                        4 DIVISI REKAYASA DRAINASE
                    </span>
                    <span class="text-[11px] font-semibold text-emerald-800 bg-emerald-50 px-2.5 py-0.5 rounded-full border border-emerald-200/80">100% Toleransi 0% Kerusakan Ubin</span>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <!-- 1. Saluran Domestik -->
                    <a href="{{ url('/#layanan') }}" @click="activeMenu = null" class="p-4 rounded-xl bg-slate-50 hover:bg-white border border-slate-200/80 hover:border-blue-400 hover:shadow-xs transition-all group">
                        <div class="flex items-center justify-between mb-1.5">
                            <span class="text-xs font-bold text-slate-900 group-hover:text-blue-700">1. Saluran Domestik</span>
                            <span class="text-[9px] font-mono font-bold px-2 py-0.5 bg-blue-100 text-blue-800 rounded-full">RESIDENSIAL</span>
                        </div>
                        <p class="text-[11px] text-slate-600 leading-relaxed">
                            Wastafel dapur, floor drain kamar mandi, kloset, dan pipa talang air dengan spiral lentur tanpa bongkar.
                        </p>
                    </a>

                    <!-- 2. Sedot & Kuras Grease Trap -->
                    <a href="{{ url('/#layanan') }}" @click="activeMenu = null" class="p-4 rounded-xl bg-slate-50 hover:bg-white border border-slate-200/80 hover:border-blue-400 hover:shadow-xs transition-all group">
                        <div class="flex items-center justify-between mb-1.5">
                            <span class="text-xs font-bold text-slate-900 group-hover:text-blue-700">2. Grease Trap Resto</span>
                            <span class="text-[9px] font-mono font-bold px-2 py-0.5 bg-amber-100 text-amber-900 rounded-full">F&B KOMERSIAL</span>
                        </div>
                        <p class="text-[11px] text-slate-600 leading-relaxed">
                            Pembersihan lemak jenuh & sisa minyak kafe/restoran dengan ekstraksi vakum & rotary degreaser bebas bau.
                        </p>
                    </a>

                    <!-- 3. Inspeksi Digital CCTV 30M -->
                    <a href="{{ url('/#layanan') }}" @click="activeMenu = null" class="p-4 rounded-xl bg-slate-50 hover:bg-white border border-slate-200/80 hover:border-blue-400 hover:shadow-xs transition-all group">
                        <div class="flex items-center justify-between mb-1.5">
                            <span class="text-xs font-bold text-slate-900 group-hover:text-blue-700">3. Inspeksi CCTV 30M</span>
                            <span class="text-[9px] font-mono font-bold px-2 py-0.5 bg-emerald-100 text-emerald-800 rounded-full">DIAGNOSTIK IP68</span>
                        </div>
                        <p class="text-[11px] text-slate-600 leading-relaxed">
                            Deteksi visual titik pipa retak, pecah, amblas, atau akar pohon dengan layar monitor HD & rekaman video.
                        </p>
                    </a>

                    <!-- 4. Heavy-Duty Hydro-Jetting -->
                    <a href="{{ url('/#b2b') }}" @click="activeMenu = null" class="p-4 rounded-xl bg-slate-50 hover:bg-white border border-slate-200/80 hover:border-blue-400 hover:shadow-xs transition-all group">
                        <div class="flex items-center justify-between mb-1.5">
                            <span class="text-xs font-bold text-slate-900 group-hover:text-blue-700">4. Hydro-Jetting Industri</span>
                            <span class="text-[9px] font-mono font-bold px-2 py-0.5 bg-slate-200 text-slate-800 rounded-full">PABRIK & GEDUNG</span>
                        </div>
                        <p class="text-[11px] text-slate-600 leading-relaxed">
                            Semburan air bertekanan tinggi merontokkan endapan semen dan kerak lumpur keras pada instalasi pipa diameter besar.
                        </p>
                    </a>
                </div>
            </div>

            <!-- Sisi Kanan: Interactive Diagnostic Telemetry Widget -->
            <div class="col-span-5 flex flex-col justify-between bg-slate-900 text-white rounded-2xl p-6 border border-slate-800 shadow-md">
                <div>
                    <div class="flex items-center justify-between mb-3 pb-2 border-b border-slate-800">
                        <span class="text-[11px] font-mono text-emerald-400 font-bold uppercase tracking-wider flex items-center gap-1.5">
                            <span class="w-2 h-2 bg-red-500 rounded-full animate-ping"></span>
                            DIAGNOSTIC TELEMETRY WIDGET
                        </span>
                        <span class="text-[10px] font-mono text-slate-400">1-KLIK DISPATCH WA</span>
                    </div>

                    <p class="text-xs text-slate-300 mb-3">
                        Pilih jenis titik bermasalah untuk memuat rekomendasi alat & estimasi biaya:
                    </p>

                    <!-- Selector Pills -->
                    <div class="grid grid-cols-3 gap-2 mb-4">
                        <button type="button" @click="diagProblem = 'wastafel'" 
                                :class="diagProblem === 'wastafel' ? 'bg-blue-600 text-white border-blue-400 font-bold' : 'bg-slate-800 text-slate-300 border-slate-700 hover:bg-slate-700'"
                                class="px-2.5 py-2 rounded-xl border text-[11px] font-semibold transition-all">
                            Wastafel
                        </button>
                        <button type="button" @click="diagProblem = 'toilet'" 
                                :class="diagProblem === 'toilet' ? 'bg-blue-600 text-white border-blue-400 font-bold' : 'bg-slate-800 text-slate-300 border-slate-700 hover:bg-slate-700'"
                                class="px-2.5 py-2 rounded-xl border text-[11px] font-semibold transition-all">
                            Kloset / WC
                        </button>
                        <button type="button" @click="diagProblem = 'floordrain'" 
                                :class="diagProblem === 'floordrain' ? 'bg-blue-600 text-white border-blue-400 font-bold' : 'bg-slate-800 text-slate-300 border-slate-700 hover:bg-slate-700'"
                                class="px-2.5 py-2 rounded-xl border text-[11px] font-semibold transition-all">
                            Floor Drain
                        </button>
                        <button type="button" @click="diagProblem = 'greasetrap'" 
                                :class="diagProblem === 'greasetrap' ? 'bg-blue-600 text-white border-blue-400 font-bold' : 'bg-slate-800 text-slate-300 border-slate-700 hover:bg-slate-700'"
                                class="px-2.5 py-2 rounded-xl border text-[11px] font-semibold transition-all">
                            Grease Trap
                        </button>
                        <button type="button" @click="diagProblem = 'talang'" 
                                :class="diagProblem === 'talang' ? 'bg-blue-600 text-white border-blue-400 font-bold' : 'bg-slate-800 text-slate-700 hover:bg-slate-700'"
                                class="px-2.5 py-2 rounded-xl border text-[11px] font-semibold transition-all">
                            Talang Atap
                        </button>
                        <button type="button" @click="diagProblem = 'cctv'" 
                                :class="diagProblem === 'cctv' ? 'bg-blue-600 text-white border-blue-400 font-bold' : 'bg-slate-800 text-slate-300 border-slate-700 hover:bg-slate-700'"
                                class="px-2.5 py-2 rounded-xl border text-[11px] font-semibold transition-all">
                            CCTV 30M
                        </button>
                    </div>

                    <!-- Preview Box -->
                    <div class="bg-slate-950/80 p-4 rounded-xl border border-slate-800 text-xs space-y-2">
                        <div class="flex items-center justify-between text-[11px] font-mono">
                            <span class="text-blue-400 font-bold" x-text="diagnostics[diagProblem].title"></span>
                            <span class="text-emerald-400 font-bold" x-text="diagnostics[diagProblem].est"></span>
                        </div>
                        <p class="text-slate-300 text-[11px] leading-relaxed" x-text="diagnostics[diagProblem].problem"></p>
                        <div class="text-[10px] font-mono text-slate-400 pt-1.5 border-t border-slate-800/80">
                            ALAT: <span class="text-white font-bold" x-text="diagnostics[diagProblem].tool"></span>
                        </div>
                    </div>
                </div>

                <!-- 1-Click WhatsApp Button Action -->
                <div class="mt-4 pt-3 border-t border-slate-800">
                    <a :href="'https://wa.me/' + whatsappNumber + '?text=' + encodeURIComponent(diagnostics[diagProblem].msg)"
                       target="_blank" 
                       rel="noopener noreferrer" 
                       class="w-full flex items-center justify-center gap-2 bg-emerald-700 hover:bg-emerald-800 text-white font-bold text-xs py-3 px-4 rounded-xl border border-emerald-600 shadow-xs transition-colors">
                        <svg class="w-4 h-4 fill-current shrink-0" viewBox="0 0 24 24">
                            <path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/>
                        </svg>
                        <span>Kirim Teknisi Spesialis Masalah Ini</span>
                    </a>
                </div>
            </div>

        </div>
    </div>
</div>
