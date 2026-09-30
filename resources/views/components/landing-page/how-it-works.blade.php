<section id="cara-kerja" class="py-16 lg:py-20 bg-white border-b border-slate-200" x-data="mobileCarousel(3, 4000)">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="text-center max-w-3xl mx-auto mb-10 md:mb-14 reveal-soft">
            <span class="text-xs font-bold uppercase tracking-wider text-sky-700 block mb-2">
                Alur Penanganan
            </span>
            <h2 class="text-3xl sm:text-4xl font-extrabold text-slate-900 tracking-tight">
                3 Langkah Cepat Saluran Kembali Plong
            </h2>
            <p class="text-slate-600 text-sm sm:text-base mt-3 leading-relaxed">
                Tanpa ribet, tanpa bongkar keramik, dan tanpa biaya tersembunyi. Solusi saluran air lancar dalam genggaman Anda.
            </p>
            <div class="flex md:hidden items-center justify-center gap-1.5 text-xs text-sky-700 font-medium mt-3" aria-hidden="true">
                <svg class="w-4 h-4 subtle-shift-x shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                </svg>
                <span>Geser langkah kerja</span>
            </div>
        </div>

        <div x-ref="slider"
             @scroll.passive="onScroll()"
             @touchstart="pause()"
             @touchend="resume()"
             @mouseenter="pause()"
             @mouseleave="resume()"
             class="flex md:grid md:grid-cols-3 overflow-x-auto md:overflow-visible snap-x snap-mandatory no-scrollbar gap-4 md:gap-8 pb-4 pt-1 px-4 -mx-4 sm:mx-0 sm:px-0">
            
            <!-- Langkah 01 -->
            <div class="w-[84vw] sm:w-[340px] md:w-auto shrink-0 snap-center bg-slate-50 rounded-xl p-7 border border-slate-200/80 shadow-xs hover:shadow-md hover:border-sky-300 transition-all flex flex-col justify-between card-lift reveal-soft stagger-1">
                <div>
                    <div class="flex items-center justify-between mb-6">
                        <div class="w-11 h-11 rounded-lg bg-sky-700 text-white font-extrabold text-base flex items-center justify-center shadow-xs">
                            01
                        </div>
                        <span class="px-2.5 py-1 rounded-md bg-white border border-slate-200 text-slate-600 text-xs font-semibold">
                            Langkah Awal
                        </span>
                    </div>

                    <h3 class="text-xl font-bold text-slate-900 mb-3 tracking-tight">
                        Hubungi Tim &amp; Ceritakan Masalah
                    </h3>
                    <p class="text-sm text-slate-600 leading-relaxed">
                        Kirim pesan singkat atau foto saluran mampet Anda via WhatsApp. Admin siaga kami merespon dalam hitungan menit untuk memberikan estimasi biaya awal yang transparan.
                    </p>
                </div>

                <div class="mt-6 pt-4 border-t border-slate-200/80 text-xs font-semibold text-sky-700">
                    Respon WhatsApp Sigap &amp; Cepat
                </div>
            </div>

            <!-- Langkah 02 -->
            <div class="w-[84vw] sm:w-[340px] md:w-auto shrink-0 snap-center bg-slate-50 rounded-xl p-7 border border-slate-200/80 shadow-xs hover:shadow-md hover:border-sky-300 transition-all flex flex-col justify-between card-lift reveal-soft stagger-2">
                <div>
                    <div class="flex items-center justify-between mb-6">
                        <div class="w-11 h-11 rounded-lg bg-sky-700 text-white font-extrabold text-base flex items-center justify-center shadow-xs">
                            02
                        </div>
                        <span class="px-2.5 py-1 rounded-md bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs font-bold">
                            Bebas Bongkar
                        </span>
                    </div>

                    <h3 class="text-xl font-bold text-slate-900 mb-3 tracking-tight">
                        Teknisi Tiba &amp; Cek Lokasi (Tanpa Bongkar)
                    </h3>
                    <p class="text-sm text-slate-600 leading-relaxed">
                        Teknisi berseragam rapi tiba di lokasi dengan mesin spiral rotary dan kamera CCTV pipa. Pengecekan dilakukan aman tanpa merusak atau membongkar keramik lantai.
                    </p>
                </div>

                <div class="mt-6 pt-4 border-t border-slate-200/80 text-xs font-semibold text-emerald-700">
                    Mesin Spiral Rotary &amp; APD Steril
                </div>
            </div>

            <!-- Langkah 03 -->
            <div class="w-[84vw] sm:w-[340px] md:w-auto shrink-0 snap-center bg-slate-50 rounded-xl p-7 border border-slate-200/80 shadow-xs hover:shadow-md hover:border-sky-300 transition-all flex flex-col justify-between card-lift reveal-soft stagger-3">
                <div>
                    <div class="flex items-center justify-between mb-6">
                        <div class="w-11 h-11 rounded-lg bg-emerald-600 text-white font-extrabold text-base flex items-center justify-center shadow-xs">
                            03
                        </div>
                        <span class="px-2.5 py-1 rounded-md bg-amber-50 border border-amber-200 text-amber-800 text-xs font-bold">
                            Garansi 30 Hari
                        </span>
                    </div>

                    <h3 class="text-xl font-bold text-slate-900 mb-3 tracking-tight">
                        Saluran Plong, Baru Bayar (Garansi 30 Hari)
                    </h3>
                    <p class="text-sm text-slate-600 leading-relaxed">
                        Aliran air diuji bersama hingga mengalir deras dan plong. Anda baru membayar setelah pekerjaan selesai sempurna, disertai terbitnya nota bukti garansi resmi selama 30 hari.
                    </p>
                </div>

                <div class="mt-6 pt-4 border-t border-slate-200/80 text-xs font-semibold text-amber-700">
                    Jaminan Garansi Tuntas 30 Hari
                </div>
            </div>

        </div>

        <div class="flex md:hidden justify-center items-center gap-1.5 mt-4">
            @for($i = 0; $i < 3; $i++)
                <button type="button" 
                        @click="goTo({{ $i }})"
                        class="h-2 rounded-full transition-all duration-300 ease-out cursor-pointer active:scale-75"
                        :class="active === {{ $i }} ? 'w-6 bg-sky-700' : 'w-2 bg-slate-300 hover:bg-slate-400'"
                        aria-label="Langkah {{ $i + 1 }}">
                </button>
            @endfor
        </div>

    </div>
</section>
