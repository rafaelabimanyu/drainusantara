<!-- ====================================================================
     2. ALUR '3 LANGKAH PRAKTIS' (#cara-kerja)
==================================================================== -->
<section id="cara-kerja" class="py-16 lg:py-24 bg-white border-b border-slate-200/80" x-data="mobileCarousel(3, 4000)">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Section Header -->
        <div class="text-center max-w-3xl mx-auto mb-12 md:mb-16 fade-up">
            <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-blue-50 border border-blue-200 text-blue-900 text-xs font-semibold rounded-full uppercase tracking-wider mb-2">
                PROSES KERJA MUDAH
            </span>
            <h2 class="text-3xl sm:text-4xl font-extrabold text-slate-900 tracking-tight">
                3 Langkah Praktis Saluran Kembali Lancar
            </h2>
            <p class="text-slate-600 text-sm sm:text-base mt-3 leading-relaxed">
                Tanpa membongkar ubin lantai, tanpa bahaya soda api, dan tanpa biaya tersembunyi.
            </p>
            <div class="flex md:hidden items-center justify-center gap-1.5 text-xs text-blue-700 font-medium mt-3">
                <svg class="w-4 h-4 animate-bounce-x" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                </svg>
                <span>Geser kartu untuk melihat alur pengerjaan</span>
            </div>
        </div>

        <!-- 3 Cards Grid -->
        <div x-ref="slider"
             @scroll.passive="onScroll()"
             @touchstart="pause()"
             @touchend="resume()"
             @mouseenter="pause()"
             @mouseleave="resume()"
             class="flex md:grid md:grid-cols-3 overflow-x-auto md:overflow-visible snap-x snap-mandatory no-scrollbar gap-5 md:gap-8 pb-4 pt-1 px-4 -mx-4 sm:mx-0 sm:px-0">
            
            <!-- Step 01 -->
            <div class="w-[84vw] sm:w-[340px] md:w-auto shrink-0 snap-center bg-slate-50/80 rounded-2xl p-7 border border-slate-200/80 hover:border-blue-400 transition-all flex flex-col justify-between fade-up delay-100">
                <div>
                    <div class="flex items-center justify-between mb-6">
                        <div class="w-11 h-11 rounded-xl bg-slate-900 text-white font-mono font-bold text-base flex items-center justify-center shadow-2xs">
                            01
                        </div>
                        <span class="px-2.5 py-1 rounded-full bg-white border border-slate-200 text-slate-700 text-xs font-medium">
                            KONSULTASI GRATIS
                        </span>
                    </div>

                    <h3 class="text-xl font-bold text-slate-900 mb-3 tracking-tight">
                        Hubungi Tim & Sampaikan Kendala
                    </h3>
                    <p class="text-sm text-slate-600 leading-relaxed">
                        Kirim pesan singkat atau foto lokasi saluran mampet via WhatsApp. Admin siaga memberikan estimasi biaya yang jelas dan transparan.
                    </p>
                </div>

                <div class="mt-6 pt-4 border-t border-slate-200/80 flex items-center gap-2 text-xs font-medium text-blue-700">
                    <span class="w-2 h-2 bg-emerald-500 rounded-full"></span>
                    <span>Respon WhatsApp &lt; 15 Menit</span>
                </div>
            </div>

            <!-- Step 02 -->
            <div class="w-[84vw] sm:w-[340px] md:w-auto shrink-0 snap-center bg-slate-50/80 rounded-2xl p-7 border border-slate-200/80 hover:border-blue-400 transition-all flex flex-col justify-between fade-up delay-200">
                <div>
                    <div class="flex items-center justify-between mb-6">
                        <div class="w-11 h-11 rounded-xl bg-slate-900 text-white font-mono font-bold text-base flex items-center justify-center shadow-2xs">
                            02
                        </div>
                        <span class="px-2.5 py-1 rounded-full bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs font-semibold">
                            TANPA BONGKAR
                        </span>
                    </div>

                    <h3 class="text-xl font-bold text-slate-900 mb-3 tracking-tight">
                        Teknisi Tiba & Pengerjaan Spiral
                    </h3>
                    <p class="text-sm text-slate-600 leading-relaxed">
                        Teknisi ramah & rapi tiba di lokasi membawa mesin spiral baja fleksibel. Pengerjaan dilakukan bersih tanpa merusak ubin keramik.
                    </p>
                </div>

                <div class="mt-6 pt-4 border-t border-slate-200/80 flex items-center gap-2 text-xs font-medium text-emerald-800">
                    <span class="w-2 h-2 bg-emerald-500 rounded-full"></span>
                    <span>Pengerjaan Rapi & Steril</span>
                </div>
            </div>

            <!-- Step 03 -->
            <div class="w-[84vw] sm:w-[340px] md:w-auto shrink-0 snap-center bg-slate-50/80 rounded-2xl p-7 border border-slate-200/80 hover:border-blue-400 transition-all flex flex-col justify-between fade-up delay-300">
                <div>
                    <div class="flex items-center justify-between mb-6">
                        <div class="w-11 h-11 rounded-xl bg-emerald-700 text-white font-mono font-bold text-base flex items-center justify-center shadow-2xs">
                            03
                        </div>
                        <span class="px-2.5 py-1 rounded-full bg-amber-50 border border-amber-200 text-amber-900 text-xs font-semibold">
                            GARANSI 30 HARI
                        </span>
                    </div>

                    <h3 class="text-xl font-bold text-slate-900 mb-3 tracking-tight">
                        Saluran Plong, Baru Bayar
                    </h3>
                    <p class="text-sm text-slate-600 leading-relaxed">
                        Aliran air diuji bersama hingga benar-benar mengalir lancar. Pembayaran dilakukan setelah selesai disertai nota garansi resmi 30 hari.
                    </p>
                </div>

                <div class="mt-6 pt-4 border-t border-slate-200/80 flex items-center gap-2 text-xs font-medium text-amber-900">
                    <span class="w-2 h-2 bg-amber-500 rounded-full"></span>
                    <span>Nota Resmi Garansi 30 Hari</span>
                </div>
            </div>

        </div>

    </div>
</section>
