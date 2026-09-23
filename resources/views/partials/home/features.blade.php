<!-- ====================================================================
     4. 4 PILAR KEUNGGULAN & KENYAMANAN PELANGGAN (#keunggulan)
==================================================================== -->
<section id="keunggulan" class="py-16 lg:py-24 bg-white border-b border-slate-200/80" x-data="mobileCarousel(4, 4000)">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Clean Warm Panel -->
        <div class="bg-slate-50/80 rounded-2xl p-7 sm:p-12 border border-slate-200/90 shadow-2xs fade-up">
            
            <!-- Header -->
            <div class="text-center max-w-3xl mx-auto mb-12">
                <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-white border border-slate-200 text-blue-700 text-xs font-semibold rounded-full uppercase tracking-wider mb-2 shadow-2xs">
                    STANDAR KUALITAS LAYANAN
                </span>
                <h2 class="text-3xl sm:text-4xl font-extrabold text-slate-900 tracking-tight">
                    Komitmen Kenyamanan & Keamanan Pipa Anda
                </h2>
                <p class="text-slate-600 text-sm sm:text-base mt-3 leading-relaxed">
                    Kombinasi peralatan spiral baja fleksibel dengan kamera inspeksi visual untuk hasil maksimal tanpa merusak hunian Anda.
                </p>
            </div>

            <!-- 4 Pillars Grid -->
            <div x-ref="slider"
                 @scroll.passive="onScroll()"
                 @touchstart="pause()"
                 @touchend="resume()"
                 @mouseenter="pause()"
                 @mouseleave="resume()"
                 class="flex md:grid md:grid-cols-2 lg:grid-cols-4 overflow-x-auto md:overflow-visible snap-x snap-mandatory no-scrollbar gap-5 pb-4 pt-1 px-1 -mx-1 sm:mx-0 sm:px-0">
                
                <!-- Pillar 01 -->
                <div class="w-[82vw] sm:w-[320px] md:w-auto shrink-0 snap-center p-6 rounded-xl bg-white border border-slate-200/90 shadow-2xs hover:border-blue-400 transition-all flex flex-col justify-between">
                    <div>
                        <div class="w-10 h-10 rounded-xl bg-blue-50 text-blue-700 font-bold text-base flex items-center justify-center mb-4 border border-blue-200/80">
                            01
                        </div>
                        <h3 class="text-base font-bold text-slate-900 mb-2 tracking-tight">Tanpa Membongkar Keramik</h3>
                        <p class="text-xs text-slate-600 leading-relaxed">
                            Spiral baja fleksibel berputar meliuk mengikuti belokan pipa tanpa perlu merusak lantai keramik atau cor beton.
                        </p>
                    </div>
                    <div class="mt-5 pt-4 border-t border-slate-100 text-[11px] font-medium text-emerald-700">
                        ✓ Hemat Biaya Renovasi Lantai
                    </div>
                </div>

                <!-- Pillar 02 -->
                <div class="w-[82vw] sm:w-[320px] md:w-auto shrink-0 snap-center p-6 rounded-xl bg-white border border-slate-200/90 shadow-2xs hover:border-blue-400 transition-all flex flex-col justify-between">
                    <div>
                        <div class="w-10 h-10 rounded-xl bg-blue-50 text-blue-700 font-bold text-base flex items-center justify-center mb-4 border border-blue-200/80">
                            02
                        </div>
                        <h3 class="text-base font-bold text-slate-900 mb-2 tracking-tight">Inspeksi Kamera Pipa 30M</h3>
                        <p class="text-xs text-slate-600 leading-relaxed">
                            Kamera inspeksi kedap air menjangkau hingga 30 meter untuk melihat posisi sumbatan, retak, atau akar secara jelas.
                        </p>
                    </div>
                    <div class="mt-5 pt-4 border-t border-slate-100 text-[11px] font-medium text-blue-700">
                        ✓ Diagnosa Tepat Sasaran
                    </div>
                </div>

                <!-- Pillar 03 -->
                <div class="w-[82vw] sm:w-[320px] md:w-auto shrink-0 snap-center p-6 rounded-xl bg-white border border-slate-200/90 shadow-2xs hover:border-blue-400 transition-all flex flex-col justify-between">
                    <div>
                        <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-700 font-bold text-base flex items-center justify-center mb-4 border border-emerald-200/80">
                            03
                        </div>
                        <h3 class="text-base font-bold text-slate-900 mb-2 tracking-tight">Garansi Tertulis 30 Hari</h3>
                        <p class="text-xs text-slate-600 leading-relaxed">
                            Setiap pengerjaan dilengkapi nota fisik garansi 30 hari. Jika terjadi kendala ulang pada titik yang sama, teknisi datang gratis.
                        </p>
                    </div>
                    <div class="mt-5 pt-4 border-t border-slate-100 text-[11px] font-medium text-emerald-700">
                        ✓ Jaminan Kepuasan Pelanggan
                    </div>
                </div>

                <!-- Pillar 04 -->
                <div class="w-[82vw] sm:w-[320px] md:w-auto shrink-0 snap-center p-6 rounded-xl bg-white border border-slate-200/90 shadow-2xs hover:border-blue-400 transition-all flex flex-col justify-between">
                    <div>
                        <div class="w-10 h-10 rounded-xl bg-blue-50 text-blue-700 font-bold text-base flex items-center justify-center mb-4 border border-blue-200/80">
                            04
                        </div>
                        <h3 class="text-base font-bold text-slate-900 mb-2 tracking-tight">Pengerjaan Rapi & Steril</h3>
                        <p class="text-xs text-slate-600 leading-relaxed">
                            Teknisi berseragam rapi, menjaga kebersihan area pengerjaan, dan meninggalkan area dapur atau kamar mandi dalam keadaan bersih.
                        </p>
                    </div>
                    <div class="mt-5 pt-4 border-t border-slate-100 text-[11px] font-medium text-slate-500">
                        ✓ Area Ditinggalkan Bersih
                    </div>
                </div>

            </div>

        </div>

    </div>
</section>
