<!-- ====================================================================
     1. HERO SECTION (HUMAN-CENTERED LUXURY EDITORIAL LOOK)
==================================================================== -->
<section class="relative bg-slate-50/70 border-b border-slate-200/80 pt-12 pb-20 lg:pt-20 lg:pb-28 overflow-hidden">
    <!-- Subtle Ambient Background Glow -->
    <div class="absolute top-0 right-0 -mr-24 -mt-24 w-[32rem] h-[32rem] bg-blue-100/40 rounded-full blur-3xl pointer-events-none"></div>
    <div class="absolute bottom-0 left-0 -ml-24 -mb-24 w-[32rem] h-[32rem] bg-slate-200/50 rounded-full blur-3xl pointer-events-none"></div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 lg:gap-14 items-center">
            
            <!-- Hero Left: Warm Editorial Content (60%) -->
            <div class="lg:col-span-7 space-y-6 text-left fade-up">
                
                <!-- Live Standby Status Pill -->
                <div class="inline-flex items-center gap-2.5 px-4 py-2 bg-white border border-slate-200/90 rounded-full text-slate-800 text-xs font-semibold shadow-2xs">
                    <span class="w-2.5 h-2.5 rounded-full bg-red-600 animate-pulse"></span>
                    <span class="tracking-tight">Teknisi Siaga 24 Jam &mdash; Area Jabodetabek & Sekitarnya</span>
                </div>

                <!-- Headline H1 -->
                <h1 class="text-3xl sm:text-5xl lg:text-6xl font-extrabold tracking-tight text-slate-900 leading-[1.14]">
                    Saluran Mampet Beres Hari Ini. <br class="hidden sm:inline">
                    <span class="text-blue-700">Tanpa Bongkar Lantai & Keramik.</span>
                </h1>

                <!-- Subheadline -->
                <p class="text-base sm:text-lg text-slate-600 leading-relaxed max-w-2xl font-normal">
                    Layanan pelancaran wastafel, kloset, dan saluran pipa mampet bergaransi 30 hari. Dikerjakan rapi, cepat, dan higienis menggunakan mesin spiral baja modern serta kamera inspeksi pipa.
                </p>

                <!-- Trust Pillars (3 Ringkas & Jelas) -->
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 pt-1 text-xs sm:text-sm">
                    <div class="bg-white p-3.5 rounded-xl border border-slate-200/80 shadow-2xs flex items-center gap-2.5">
                        <span class="w-6 h-6 rounded-lg bg-emerald-100 text-emerald-800 font-bold flex items-center justify-center shrink-0 text-xs">✓</span>
                        <span class="font-semibold text-slate-900 text-xs">Lantai & Keramik Aman 100%</span>
                    </div>
                    <div class="bg-white p-3.5 rounded-xl border border-slate-200/80 shadow-2xs flex items-center gap-2.5">
                        <span class="w-6 h-6 rounded-lg bg-blue-100 text-blue-800 font-bold flex items-center justify-center shrink-0 text-xs">✓</span>
                        <span class="font-semibold text-slate-900 text-xs">Inspeksi Kamera Pipa</span>
                    </div>
                    <div class="bg-white p-3.5 rounded-xl border border-slate-200/80 shadow-2xs flex items-center gap-2.5">
                        <span class="w-6 h-6 rounded-lg bg-amber-100 text-amber-900 font-bold flex items-center justify-center shrink-0 text-xs">✓</span>
                        <span class="font-semibold text-slate-900 text-xs">Garansi Tertulis 30 Hari</span>
                    </div>
                </div>

                <!-- Dual CTA Buttons -->
                <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3.5 pt-2">
                    <a href="{{ $generalWaUrl }}" target="_blank" rel="noopener noreferrer" 
                       class="inline-flex items-center justify-center gap-3 bg-emerald-700 hover:bg-emerald-800 text-white font-bold text-sm px-7 py-3.5 rounded-xl shadow-xs hover:shadow transition-all active:scale-98">
                        <svg class="w-4 h-4 fill-current shrink-0" viewBox="0 0 24 24">
                            <path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/>
                        </svg>
                        <span>Panggil Teknisi via WhatsApp</span>
                    </a>

                    <a href="#layanan" 
                       class="inline-flex items-center justify-center gap-2 bg-white hover:bg-slate-100 text-slate-800 font-bold text-sm px-6 py-3.5 rounded-xl border border-slate-300/90 shadow-2xs hover:border-slate-400 transition-all">
                        <span>Konsultasi & Estimasi Biaya</span>
                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </a>
                </div>

                <!-- Micro-reassurance -->
                <div class="text-xs text-slate-500 flex items-center gap-2 pt-1 font-medium">
                    <svg class="w-4 h-4 text-emerald-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span>Bayar hanya setelah saluran benar-benar lancar kembali.</span>
                </div>
            </div>

            <!-- Hero Right: Clean Visual Card (40%) -->
            <div class="lg:col-span-5 fade-up delay-150">
                <div class="bg-white rounded-2xl p-5 sm:p-6 border border-slate-200/90 shadow-xs space-y-4">
                    
                    <!-- Clean Photo Frame -->
                    <div class="relative rounded-xl overflow-hidden aspect-[16/10] bg-slate-100 border border-slate-200/80">
                        <picture>
                            <source media="(max-width: 640px)" srcset="{{ asset('images/hero-technician-mobile.webp') }}" type="image/webp">
                            <source srcset="{{ asset('images/hero-technician.webp') }}" type="image/webp">
                            <img 
                                src="{{ asset('images/hero-technician.webp') }}" 
                                alt="Teknisi Spesialis Saluran Mampet Drainusantara" 
                                width="800" 
                                height="500" 
                                loading="eager"
                                fetchpriority="high"
                                decoding="async"
                                class="w-full h-full object-cover"
                            >
                        </picture>
                        
                        <div class="absolute inset-0 bg-gradient-to-t from-slate-900/80 via-transparent to-transparent p-4 flex flex-col justify-between pointer-events-none">
                            <div class="flex justify-between items-center">
                                <span class="bg-emerald-700 text-white text-[10px] font-bold px-2.5 py-1 rounded-md shadow-2xs">
                                    Status: Siap Meluncur
                                </span>
                                <span class="bg-white/90 backdrop-blur-xs text-slate-800 text-[10px] font-semibold px-2 py-0.5 rounded-md border border-slate-200">
                                    Alat: Spiral Rotary Baja
                                </span>
                            </div>

                            <div class="bg-white/95 backdrop-blur-xs text-slate-900 p-3 rounded-xl border border-slate-200 text-xs">
                                <div class="flex items-center justify-between mb-0.5">
                                    <span class="font-bold text-slate-900">Metode Kerja:</span>
                                    <span class="text-emerald-700 font-bold text-[11px]">100% Bebas Bongkar</span>
                                </div>
                                <p class="text-slate-600 text-[11px] leading-relaxed">
                                    Kerak lemak & ampas makanan dikikis tuntas dengan mesin spiral baja meliuk aman di pipa PVC.
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Verified Review Quote Card -->
                    <div class="bg-slate-50/80 rounded-xl p-4 border border-slate-200/80 space-y-2">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-1 text-amber-500">
                                @for($i = 0; $i < 5; $i++)
                                    <svg class="w-3.5 h-3.5 fill-current" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                    </svg>
                                @endfor
                            </div>
                            <span class="text-[11px] text-slate-500 font-medium">Google Review 5.0 ★</span>
                        </div>
                        <p class="text-xs text-slate-700 italic leading-relaxed">
                            "Wastafel dapur mampet berhari-hari langsung lancar dalam 30 menit. Dikerjakan rapi tanpa membongkar keramik dapur."
                        </p>
                        <div class="flex items-center justify-between pt-1 text-[11px] text-slate-500">
                            <span class="font-bold text-slate-900">Ibu Ratna Dewi &bull; Duren Sawit</span>
                            <span class="text-emerald-700 font-semibold">Terverifikasi</span>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>
</section>
