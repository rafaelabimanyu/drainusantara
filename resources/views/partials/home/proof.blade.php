<!-- ====================================================================
     5. BEFORE / AFTER PROOF OF WORK (#galeri-before-after)
==================================================================== -->
<section id="galeri-before-after" class="py-16 lg:py-24 bg-slate-50 border-b border-slate-200" x-data="mobileCarousel(3, 4500)">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Section Header -->
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-6 mb-12 fade-up">
            <div>
                <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-white border border-slate-200 text-slate-900 text-xs font-mono font-bold rounded-full uppercase tracking-wider mb-2 shadow-2xs">
                    DOKUMENTASI NYATA LAPANGAN
                </span>
                <h2 class="text-3xl sm:text-4xl font-extrabold text-slate-900 tracking-tight">
                    Bukti Komparasi Hasil Pelancaran Saluran Mampet Sebelum & Sesudah
                </h2>
                <p class="text-slate-600 text-sm sm:text-base mt-2 max-w-2xl">
                    Dokumentasi efektivitas pelancaran mesin spiral rotary dan inspeksi CCTV sonar Drainusantara di lapangan.
                </p>
            </div>
            <div>
                <a href="{{ url('/galeri') }}" class="inline-flex items-center gap-2 text-xs font-bold text-blue-700 hover:text-blue-800 bg-white hover:bg-blue-50 border border-slate-200 px-5 py-3 rounded-xl shadow-2xs transition-colors">
                    <span>Lihat Seluruh Dokumentasi</span>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                    </svg>
                </a>
            </div>
        </div>

        <!-- 3 Comparison Split Cards -->
        <div x-ref="slider"
             @scroll.passive="onScroll()"
             @touchstart="pause()"
             @touchend="resume()"
             @mouseenter="pause()"
             @mouseleave="resume()"
             class="flex lg:grid lg:grid-cols-3 overflow-x-auto lg:overflow-visible snap-x snap-mandatory no-scrollbar gap-5 lg:gap-8 pb-4 pt-1 px-4 -mx-4 sm:mx-0 sm:px-0">
            
            <!-- Comparison 1 -->
            <div class="w-[85vw] sm:w-[350px] lg:w-auto shrink-0 snap-center bg-white rounded-2xl border border-slate-200/90 overflow-hidden shadow-2xs hover:shadow-md transition-all fade-up delay-100 flex flex-col justify-between">
                <div>
                    <div class="grid grid-cols-2 border-b border-slate-100">
                        <!-- Before -->
                        <div class="relative aspect-[4/3] bg-slate-900 overflow-hidden border-r border-slate-100">
                            <img 
                                src="https://images.unsplash.com/photo-1584622650111-993a426fbf0a?auto=format&fit=crop&w=500&q=80" 
                                alt="Sebelum: Pipa Wastafel Mampet Kerak Lemak" 
                                class="w-full h-full object-cover grayscale contrast-125"
                                width="500"
                                height="375"
                                loading="lazy"
                                decoding="async"
                            >
                            <span class="absolute top-2.5 left-2.5 bg-red-600 text-white text-[9px] font-mono font-bold px-2 py-0.5 rounded-md shadow-2xs">
                                SEBELUM (MAMPET)
                            </span>
                        </div>
                        <!-- After -->
                        <div class="relative aspect-[4/3] bg-slate-900 overflow-hidden">
                            <img 
                                src="https://images.unsplash.com/photo-1585704032915-c3400ca199e7?auto=format&fit=crop&w=500&q=80" 
                                alt="Sesudah: Pipa Wastafel Bersih Plong" 
                                class="w-full h-full object-cover contrast-110"
                                width="500"
                                height="375"
                                loading="lazy"
                                decoding="async"
                            >
                            <span class="absolute top-2.5 left-2.5 bg-emerald-700 text-white text-[9px] font-mono font-bold px-2 py-0.5 rounded-md shadow-2xs">
                                SESUDAH (PLONG)
                            </span>
                        </div>
                    </div>

                    <div class="p-6">
                        <div class="text-[11px] font-mono text-blue-700 font-bold uppercase mb-1">RESTO F&B JAKARTA UTARA</div>
                        <h3 class="text-base font-bold text-slate-900 mb-2">Bak Cuci Piring dari Kerak Lemak Padat</h3>
                        <p class="text-xs text-slate-600 leading-relaxed">
                            Endapan lemak sepanjang 10 meter dikikis tuntas dengan spiral fleksibel rotary tanpa membongkar keramik dapur.
                        </p>
                    </div>
                </div>

                <div class="p-6 pt-0 border-t border-slate-100 mt-4 text-xs font-mono text-slate-500 flex justify-between items-center bg-slate-50/50">
                    <span>Durasi: 40 Mnt</span>
                    <span class="text-emerald-800 font-bold">Status: Plong Lancar</span>
                </div>
            </div>

            <!-- Comparison 2 -->
            <div class="w-[85vw] sm:w-[350px] lg:w-auto shrink-0 snap-center bg-white rounded-2xl border border-slate-200/90 overflow-hidden shadow-2xs hover:shadow-md transition-all fade-up delay-150 flex flex-col justify-between">
                <div>
                    <div class="grid grid-cols-2 border-b border-slate-100">
                        <!-- Before -->
                        <div class="relative aspect-[4/3] bg-slate-900 overflow-hidden border-r border-slate-100">
                            <img 
                                src="https://images.unsplash.com/photo-1584622781564-1d987f7333c1?auto=format&fit=crop&w=500&q=80" 
                                alt="Sebelum: Toilet Meluap Tersumbat" 
                                class="w-full h-full object-cover grayscale contrast-125"
                                width="500"
                                height="375"
                                loading="lazy"
                                decoding="async"
                            >
                            <span class="absolute top-2.5 left-2.5 bg-red-600 text-white text-[9px] font-mono font-bold px-2 py-0.5 rounded-md shadow-2xs">
                                SEBELUM (MELUAP)
                            </span>
                        </div>
                        <!-- After -->
                        <div class="relative aspect-[4/3] bg-slate-900 overflow-hidden">
                            <img 
                                src="https://images.unsplash.com/photo-1507652313519-d4e9174996dd?auto=format&fit=crop&w=500&q=80" 
                                alt="Sesudah: Toilet Duduk Lancar" 
                                class="w-full h-full object-cover contrast-110"
                                width="500"
                                height="375"
                                loading="lazy"
                                decoding="async"
                            >
                            <span class="absolute top-2.5 left-2.5 bg-emerald-700 text-white text-[9px] font-mono font-bold px-2 py-0.5 rounded-md shadow-2xs">
                                SESUDAH (LANCAR)
                            </span>
                        </div>
                    </div>

                    <div class="p-6">
                        <div class="text-[11px] font-mono text-blue-700 font-bold uppercase mb-1">KLUSTER RESIDENSIAL TANGSEL</div>
                        <h3 class="text-base font-bold text-slate-900 mb-2">Penarikan Sumbatan Tisu Leher Angsa</h3>
                        <p class="text-xs text-slate-600 leading-relaxed">
                            Penarikan benda asing dari lekukan leher angsa kloset duduk lantai 2 dalam 35 menit tanpa melepas kloset.
                        </p>
                    </div>
                </div>

                <div class="p-6 pt-0 border-t border-slate-100 mt-4 text-xs font-mono text-slate-500 flex justify-between items-center bg-slate-50/50">
                    <span>Durasi: 35 Mnt</span>
                    <span class="text-emerald-800 font-bold">Status: Bebas Bongkar</span>
                </div>
            </div>

            <!-- Comparison 3 -->
            <div class="w-[85vw] sm:w-[350px] lg:w-auto shrink-0 snap-center bg-white rounded-2xl border border-slate-200/90 overflow-hidden shadow-2xs hover:shadow-md transition-all fade-up delay-200 flex flex-col justify-between">
                <div>
                    <div class="grid grid-cols-2 border-b border-slate-100">
                        <!-- Before -->
                        <div class="relative aspect-[4/3] bg-slate-900 overflow-hidden border-r border-slate-100">
                            <img 
                                src="https://images.unsplash.com/photo-1581092335397-9583fe92d232?auto=format&fit=crop&w=500&q=80" 
                                alt="Sebelum: Intrusi Akar di Jalur Pipa" 
                                class="w-full h-full object-cover grayscale contrast-125"
                                width="500"
                                height="375"
                                loading="lazy"
                                decoding="async"
                            >
                            <span class="absolute top-2.5 left-2.5 bg-red-600 text-white text-[9px] font-mono font-bold px-2 py-0.5 rounded-md shadow-2xs">
                                CCTV: INTRUSI AKAR
                            </span>
                        </div>
                        <!-- After -->
                        <div class="relative aspect-[4/3] bg-slate-900 overflow-hidden">
                            <img 
                                src="https://images.unsplash.com/photo-1581092160607-ee22621dd758?auto=format&fit=crop&w=500&q=80" 
                                alt="Sesudah: Akar Terpotong Tuntas" 
                                class="w-full h-full object-cover contrast-110"
                                width="500"
                                height="375"
                                loading="lazy"
                                decoding="async"
                            >
                            <span class="absolute top-2.5 left-2.5 bg-emerald-700 text-white text-[9px] font-mono font-bold px-2 py-0.5 rounded-md shadow-2xs">
                                CCTV: TERPOTONG
                            </span>
                        </div>
                    </div>

                    <div class="p-6">
                        <div class="text-[11px] font-mono text-blue-700 font-bold uppercase mb-1">RUKO KANTOR KOTA SEMARANG</div>
                        <h3 class="text-base font-bold text-slate-900 mb-2">Pemotongan Akar Pohon Penembus Pipa</h3>
                        <p class="text-xs text-slate-600 leading-relaxed">
                            Inspeksi kamera CCTV mendeteksi akar pohon menembus pipa bawah tanah. Dipotong tuntas dengan mata spiral baja pemotong.
                        </p>
                    </div>
                </div>

                <div class="p-6 pt-0 border-t border-slate-100 mt-4 text-xs font-mono text-slate-500 flex justify-between items-center bg-slate-50/50">
                    <span>Kedalaman: 18 Meter</span>
                    <span class="text-emerald-800 font-bold">Status: Video Record</span>
                </div>
            </div>

        </div>

    </div>
</section>
