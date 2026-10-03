<section id="keunggulan" class="py-16 lg:py-24 bg-slate-50/70 border-b border-slate-200 content-auto" x-data="mobileCarousel(5, 4000)">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="text-center max-w-3xl mx-auto mb-10 md:mb-14 reveal-soft">
            <span class="text-xs font-bold uppercase tracking-wider text-sky-700 block mb-2">
                Standar Teknologi &amp; Pelayanan
            </span>
            <h2 class="text-3xl sm:text-4xl font-extrabold text-slate-900 tracking-tight">
                Mengapa Memilih Layanan Drainusantara?
            </h2>
            <p class="text-slate-600 text-sm sm:text-base mt-3 leading-relaxed">
                Kombinasi mesin drain cleaner mekanis modern, transparansi biaya di awal, dan jaminan garansi resmi untuk menuntaskan masalah pipa hunian Anda.
            </p>
            <div class="flex md:hidden items-center justify-center gap-1.5 text-xs text-sky-700 font-medium mt-3" aria-hidden="true">
                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                </svg>
                <span>Geser keunggulan armada</span>
            </div>
        </div>

        <div x-ref="slider"
             @scroll.passive="onScroll()"
             @touchstart="pause()"
             @touchend="resume()"
             @mouseenter="pause()"
             @mouseleave="resume()"
             class="flex md:grid md:grid-cols-2 lg:grid-cols-3 overflow-x-auto md:overflow-visible snap-x snap-mandatory no-scrollbar gap-4 lg:gap-6 pb-4 pt-1 px-1 -mx-1 sm:mx-0 sm:px-0">
            
            <!-- Card 1 (Featured: Col Span 2 on Desktop): Spiral Baja Tanpa Bongkar -->
            <div class="w-[85vw] sm:w-[340px] md:w-auto lg:col-span-2 shrink-0 snap-center p-6 sm:p-8 rounded-xl bg-linear-to-br from-sky-50/70 via-white to-slate-50/60 border border-sky-200/80 hover:border-sky-400 card-lift reveal-soft stagger-1 shadow-xs">
                <div>
                    <div class="mb-4">
                        <div class="w-11 h-11 rounded-lg bg-sky-100 border border-sky-200 text-sky-700 flex items-center justify-center shrink-0">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                            </svg>
                        </div>
                    </div>
                    <h3 class="text-xl sm:text-2xl font-extrabold text-slate-900 mb-2 tracking-tight">Teknologi Spiral Baja Tanpa Bongkar Keramik</h3>
                    <p class="text-sm text-slate-600 leading-relaxed">
                        Kabel baja fleksibel berkekuatan torsi tinggi masuk mengikuti belokan leher angsa pipa PVC. Mengikis endapan lemak beku, serabut rambut, dan kotoran padat tanpa membongkar lantai keramik atau merusak dinding hunian.
                    </p>
                </div>
            </div>

            <!-- Card 2: Inspeksi Visual Kamera CCTV 30M -->
            <div class="w-[85vw] sm:w-[340px] md:w-auto lg:col-span-1 shrink-0 snap-center p-6 rounded-xl bg-white border border-slate-200/90 hover:border-slate-400 card-lift reveal-soft stagger-2 shadow-xs">
                <div>
                    <div class="mb-4">
                        <div class="w-10 h-10 rounded-lg bg-sky-50 border border-sky-200 text-sky-700 flex items-center justify-center shrink-0">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                            </svg>
                        </div>
                    </div>
                    <h3 class="text-lg font-bold text-slate-900 mb-2 tracking-tight">Inspeksi Kamera CCTV 30M</h3>
                    <p class="text-sm text-slate-600 leading-relaxed">
                        Kamera endoskopi tahan air menjangkau hingga kedalaman 30 meter. Mendiagnosis titik sumbatan, retak pipa, atau intrusi akar pohon langsung pada monitor teknisi.
                    </p>
                </div>
            </div>

            <!-- Card 3: Biaya Transparan Mulai Rp 400.000 -->
            <div class="w-[85vw] sm:w-[340px] md:w-auto lg:col-span-1 shrink-0 snap-center p-6 rounded-xl bg-white border border-slate-200/90 hover:border-emerald-500 card-lift reveal-soft stagger-3 shadow-xs">
                <div>
                    <div class="mb-4">
                        <div class="w-10 h-10 rounded-lg bg-emerald-50 border border-emerald-200 text-emerald-700 flex items-center justify-center shrink-0">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                    </div>
                    <h3 class="text-lg font-bold text-slate-900 mb-2 tracking-tight">Estimasi Biaya Jelas Mulai Rp 400.000</h3>
                    <p class="text-sm text-slate-600 leading-relaxed">
                        Total biaya disepakati bersama sebelum mesin dinyalakan, tanpa sistem hitungan per meter yang menjebak. Anda hanya membayar setelah saluran diuji lancar tuntas (No Cure No Pay).
                    </p>
                </div>
            </div>

            <!-- Card 4: Garansi Resmi 30 Hari -->
            <div class="w-[85vw] sm:w-[340px] md:w-auto lg:col-span-1 shrink-0 snap-center p-6 rounded-xl bg-white border border-slate-200/90 hover:border-sky-300 card-lift reveal-soft stagger-2 shadow-xs">
                <div>
                    <div class="mb-4">
                        <div class="w-10 h-10 rounded-lg bg-sky-50 border border-sky-200 text-sky-700 flex items-center justify-center shrink-0">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/>
                            </svg>
                        </div>
                    </div>
                    <h3 class="text-lg font-bold text-slate-900 mb-2 tracking-tight">Garansi Resmi 30 Hari</h3>
                    <p class="text-sm text-slate-600 leading-relaxed">
                        Dilengkapi nota pengerjaan resmi. Jika saluran pada titik yang sama mengalami kendala dalam 30 hari kalender, teknisi kami tangani ulang tanpa biaya jasa tambahan.
                    </p>
                </div>
            </div>

            <!-- Card 5: Kerja Higienis & APD Steril -->
            <div class="w-[85vw] sm:w-[340px] md:w-auto lg:col-span-1 shrink-0 snap-center p-6 rounded-xl bg-white border border-slate-200/90 hover:border-sky-300 card-lift reveal-soft stagger-3 shadow-xs">
                <div>
                    <div class="mb-4">
                        <div class="w-10 h-10 rounded-lg bg-sky-50 border border-sky-200 text-sky-700 flex items-center justify-center shrink-0">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                        </div>
                    </div>
                    <h3 class="text-lg font-bold text-slate-900 mb-2 tracking-tight">Kerja Higienis &amp; APD Steril</h3>
                    <p class="text-sm text-slate-600 leading-relaxed">
                        Teknisi mengenakan seragam rapi, sarung tangan khusus, dan cover pelindung alas kaki. Area kerja dibersihkan serta disanitasi kembali setelah tindakan selesai.
                    </p>
                </div>
            </div>

        </div>

        <div class="flex md:hidden justify-center items-center gap-1 mt-6">
            @for($i = 0; $i < 5; $i++)
                <button type="button" 
                        @click="goTo({{ $i }})"
                        class="min-w-[28px] min-h-[28px] p-2 inline-flex items-center justify-center cursor-pointer active:scale-90"
                        aria-label="Keunggulan {{ $i + 1 }}">
                    <span class="h-2 rounded-full transition-all duration-300 block"
                          :class="active === {{ $i }} ? 'w-6 bg-sky-700' : 'w-2 bg-slate-300 hover:bg-slate-400'"></span>
                </button>
            @endfor
        </div>

    </div>
</section>
