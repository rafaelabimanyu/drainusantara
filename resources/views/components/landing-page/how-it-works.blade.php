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
                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                </svg>
                <span>Geser langkah kerja</span>
            </div>
        </div>

            <div x-ref="slider" tabindex="0" role="region" aria-label="Langkah penanganan - geser untuk melihat lainnya"
             @scroll.passive="onScroll()"
             @touchstart="pause()"
             @touchend="resume()"
             @touchcancel="resume()"
             class="flex md:grid md:grid-cols-3 overflow-x-auto md:overflow-visible snap-x snap-mandatory no-scrollbar gap-4 md:gap-8 pb-4 pt-1 px-4 -mx-4 sm:mx-0 sm:px-0">
            
            <!-- Langkah 01 -->
            <div class="w-[84vw] sm:w-85 md:w-auto shrink-0 snap-center bg-slate-50 rounded-xl p-7 border border-slate-200/80 shadow-xs hover:shadow-md hover:border-sky-300 transition-all card-lift reveal-soft stagger-1">
                <div>
                    <div class="mb-5">
                        <div class="w-11 h-11 rounded-lg bg-sky-700 text-white font-extrabold text-base flex items-center justify-center shadow-xs">
                            01
                        </div>
                    </div>

                    <h3 class="text-xl font-bold text-slate-900 mb-3 tracking-tight">
                        Hubungi Tim &amp; Ceritakan Masalah
                    </h3>
                    <p class="text-sm text-slate-600 leading-relaxed">
                        Kirim pesan singkat atau foto saluran mampet Anda via WhatsApp. Admin siaga kami merespon dalam hitungan menit untuk memberikan estimasi biaya awal yang transparan.
                    </p>
                </div>
            </div>

            <!-- Langkah 02 -->
            <div class="w-[84vw] sm:w-85 md:w-auto shrink-0 snap-center bg-slate-50 rounded-xl p-7 border border-slate-200/80 shadow-xs hover:shadow-md hover:border-sky-300 transition-all card-lift reveal-soft stagger-2">
                <div>
                    <div class="mb-5">
                        <div class="w-11 h-11 rounded-lg bg-sky-700 text-white font-extrabold text-base flex items-center justify-center shadow-xs">
                            02
                        </div>
                    </div>

                    <h3 class="text-xl font-bold text-slate-900 mb-3 tracking-tight">
                        Teknisi Tiba &amp; Cek Lokasi (Tanpa Bongkar)
                    </h3>
                    <p class="text-sm text-slate-600 leading-relaxed">
                        Teknisi berseragam rapi tiba di lokasi dengan mesin spiral rotary dan kamera CCTV pipa. Pengecekan dilakukan aman tanpa merusak atau membongkar keramik lantai.
                    </p>
                </div>
            </div>

            <!-- Langkah 03 -->
            <div class="w-[84vw] sm:w-85 md:w-auto shrink-0 snap-center bg-slate-50 rounded-xl p-7 border border-slate-200/80 shadow-xs hover:shadow-md hover:border-sky-300 transition-all card-lift reveal-soft stagger-3">
                <div>
                    <div class="mb-5">
                        <div class="w-11 h-11 rounded-lg bg-sky-700 text-white font-extrabold text-base flex items-center justify-center shadow-xs">
                            03
                        </div>
                    </div>

                    <h3 class="text-xl font-bold text-slate-900 mb-3 tracking-tight">
                        Saluran Plong, Baru Bayar (Garansi 30 Hari)
                    </h3>
                    <p class="text-sm text-slate-600 leading-relaxed">
                        Aliran air diuji bersama hingga mengalir deras dan plong. Anda baru membayar setelah pekerjaan selesai sempurna, disertai terbitnya nota bukti garansi resmi selama 30 hari.
                    </p>
                </div>
            </div>

        </div>

        <!-- Mobile Slide Counter -->
        <div class="flex items-center justify-center gap-3 mt-4 md:hidden text-xs text-slate-500 font-mono">
            <button type="button" @click="goTo(Math.max(0, active - 1))"
                    :disabled="active === 0"
                    :class="active === 0 ? 'opacity-40 cursor-not-allowed' : 'hover:bg-slate-100 hover:text-slate-900 cursor-pointer'"
                    class="p-1.5 rounded-md border border-slate-200 transition-colors"
                    aria-label="Langkah sebelumnya">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            </button>
            <span>Langkah <strong class="text-slate-900" x-text="active + 1">1</strong> dari 3</span>
            <button type="button" @click="goTo(Math.min(2, active + 1))"
                    :disabled="active === 2"
                    :class="active === 2 ? 'opacity-40 cursor-not-allowed' : 'hover:bg-slate-100 hover:text-slate-900 cursor-pointer'"
                    class="p-1.5 rounded-md border border-slate-200 transition-colors"
                    aria-label="Langkah berikutnya">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            </button>
        </div>

    </div>
</section>
