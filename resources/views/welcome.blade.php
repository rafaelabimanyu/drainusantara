@extends('layouts.app')

@section('content')
@php
    $whatsappNumber = config('app.whatsapp_number') ?: '6281234567890';
    $generalWaText = urlencode("Halo Admin Drainusantara, saluran air di rumah saya sedang mampet. Mohon info teknisi terdekat.");
    $generalWaUrl = "https://wa.me/{$whatsappNumber}?text={$generalWaText}";

    // 6 Problem Catalogs Berorientasi Kebutuhan Rumah & Komersial
    $problemCatalogs = [
        [
            'code' => 'DN-01',
            'title' => 'Wastafel & Cuci Piring',
            'category' => 'Dapur & Residensial',
            'badge' => 'Paling Sering',
            'badge_color' => 'bg-amber-100 text-amber-800 border-amber-200',
            'tool_tag' => 'Mesin Spiral Rotary K-50 Ridgid',
            'cable_spec' => 'Spiral Lentur 16mm Khusus Sifon PVC',
            'problem_desc' => 'Air bak cuci piring meluap atau lambat surut karena tumpukan minyak goreng beku, lemak sisa masakan, dan ampas makanan yang membatu di leher angsa.',
            'specs' => [
                'Mengikis kerak minyak & lemak 100% tuntas',
                'Aman untuk pipa leher angsa sifon PVC',
                'Pengerjaan rapi 30–45 menit tanpa kotor',
                'Garansi resmi 30 hari nota tertulis',
            ],
            'price' => 400000,
            'wa_text' => 'Halo Drainusantara, saya butuh penanganan untuk Wastafel & Bak Cuci Piring mampet. Mohon info jadwal teknisi terdekat.',
        ],
        [
            'code' => 'DN-02',
            'title' => 'Kloset & WC Meluap',
            'category' => 'Toilet & Kamar Mandi',
            'badge' => 'Darurat 24 Jam',
            'badge_color' => 'bg-red-100 text-red-800 border-red-200',
            'tool_tag' => 'Rooter Heavy Duty Rigid K-60',
            'cable_spec' => 'Spiral Torsi Meliuk Anti-Kinking',
            'problem_desc' => 'Kloset duduk atau jongkok meluap saat disiram akibat sumbatan tisu basah, pembalut, kain, atau kerak kotoran yang tersangkut di lekukan porselen.',
            'specs' => [
                '100% tanpa membongkar dudukan kloset porselen',
                'Daya putar meliuk aman di leher angsa keramik',
                'Teknisi ber-APD bersih, bersarung tangan & sepatu cover',
                'Garansi resmi 30 hari nota tertulis',
            ],
            'price' => 400000,
            'wa_text' => 'Halo Drainusantara, saya butuh bantuan darurat untuk Kloset / Toilet tersumbat tanpa bongkar keramik. Mohon segera kirim teknisi.',
        ],
        [
            'code' => 'DN-03',
            'title' => 'Floor Drain Kamar Mandi',
            'category' => 'Kamar Mandi & Saluran Lantai',
            'badge' => 'Solusi Higienis',
            'badge_color' => 'bg-sky-100 text-sky-800 border-sky-200',
            'tool_tag' => 'Rooter Fleksibel Spiral Karbon',
            'cable_spec' => 'Spiral Baja Anti-Karat & Tahan Lekukan',
            'problem_desc' => 'Air mandi menggenang di lantai dan memicu bau got tak sedap karena jalinan rambut rontok dan residu busa sabun yang menebal di jalur pipa pembuangan.',
            'specs' => [
                'Melilit & menarik gumpalan rambut dan kerak sabun',
                'Menghilangkan bau got & melancarkan aliran air',
                'Melayani pipa diameter 2 hingga 4 inch',
                'Garansi resmi 30 hari nota tertulis',
            ],
            'price' => 400000,
            'wa_text' => 'Halo Drainusantara, saya butuh penanganan Floor Drain Kamar Mandi yang menggenang dan berbau got. Mohon info teknisi terdekat.',
        ],
        [
            'code' => 'DN-04',
            'title' => 'Talang Rooftop & Pipa Atap',
            'category' => 'Rooftop & Eksterior Gedung',
            'badge' => 'Musim Hujan',
            'badge_color' => 'bg-emerald-100 text-emerald-800 border-emerald-200',
            'tool_tag' => 'Spiral Baja Jangkauan Panjang 22mm',
            'cable_spec' => 'Kabel Spiral Heavy Duty Hingga 30 Meter',
            'problem_desc' => 'Pipa pembuangan talang atap meluap oleh endapan lumut tebal, pasir dak semen, dan dedaunan kering yang memicu kebocoran plafon rumah.',
            'specs' => [
                'Jangkauan kabel panjang menembus pipa vertikal',
                'Membersihkan endapan lumpur, lumut, & dedaunan',
                'Mencegah rembesan air hujan ke plafon hunian',
                'Garansi resmi 30 hari nota tertulis',
            ],
            'price' => 400000,
            'wa_text' => 'Halo Drainusantara, pipa talang rooftop kami tersumbat dedaunan dan meluap. Mohon info teknisi untuk penanganan.',
        ],
        [
            'code' => 'DN-05',
            'title' => 'Kuras Grease Trap & Lemak',
            'category' => 'Komersial F&B & Restoran',
            'badge' => 'B2B & Restoran',
            'badge_color' => 'bg-purple-100 text-purple-800 border-purple-200',
            'tool_tag' => 'Ekstraksi Vakum & Rotary Degreaser',
            'cable_spec' => 'Pembersih Dinding Pipa Minyak Komersial',
            'problem_desc' => 'Bak perangkap lemak (grease trap) dapur resto, kafe, atau rumah penuh kerak minyak padat berbau menyengat dan mengancam kelancaran operasional.',
            'specs' => [
                'Pembersihan lemak jenuh & sisa minyak komersial',
                'Perawatan berkala bebas bau untuk dapur resto & kafe',
                'Tersedia faktur pajak resmi & dokumen B2B',
                'Garansi resmi 30 hari nota tertulis',
            ],
            'price' => 400000,
            'wa_text' => 'Halo Drainusantara, kami ingin memesan pembersihan Grease Trap / Sedot Lemak untuk restoran/kafe kami. Mohon info penawaran.',
        ],
        [
            'code' => 'DN-06',
            'title' => 'Inspeksi CCTV Pipa 30M',
            'category' => 'Diagnostik & Investigasi',
            'badge' => 'Teknologi Presisi',
            'badge_color' => 'bg-indigo-100 text-indigo-800 border-indigo-200',
            'tool_tag' => 'Endoscopic Push-Camera IP68 HD 1080P',
            'cable_spec' => 'Kabel Dorong Fiber Optic 30 Meter',
            'problem_desc' => 'Investigasi visual kamera kedap air untuk melihat langsung posisi tepat pipa retak, pecah, sambungan lepas, kemiringan kurang, atau intrusi akar di dalam tanah.',
            'specs' => [
                'Kamera tahan air IP68 dengan lampu LED 1080P HD',
                'Layar monitor realtime & dokumentasi rekaman video',
                'Menemukan titik masalah presisi tanpa tebak-tebak',
                'Disertai laporan hasil inspeksi teknis lengkap',
            ],
            'price' => 400000,
            'wa_text' => 'Halo Drainusantara, saya ingin menjadwalkan Inspeksi Kamera CCTV Pipa 30M untuk diagnosa saluran yang sering mampet. Mohon info ketersediaan unit.',
        ],
    ];
@endphp

<!-- ====================================================================
     1. HERO SECTION (MINIMALIS, BERSIH, LEGA & HIGH-CONVERSION)
==================================================================== -->
<section class="relative bg-white border-b border-slate-200 pt-10 pb-16 lg:pt-16 lg:pb-24">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 lg:gap-14 items-center">
            
            <!-- Hero Left: Konten Esensial & Bernapas -->
            <div class="lg:col-span-7 space-y-6 text-left">
                
                <!-- Status Area Jangkauan -->
                <div class="inline-flex items-center px-3 py-1 bg-slate-100 border border-slate-200 rounded-md text-xs font-semibold text-slate-700 reveal-fade">
                    <span>Armada Siaga: Jabodetabek, Semarang &amp; Bandar Lampung</span>
                </div>

                <!-- Headline Lugas & Faktual -->
                <h1 class="text-3xl sm:text-5xl lg:text-6xl font-extrabold tracking-tight text-slate-900 leading-tight sm:leading-[1.12] reveal-soft">
                    Jasa Saluran Mampet & Tukang Pipa Tersumbat <br>
                    <span class="text-sky-700">Tanpa Bongkar Keramik & Bergaransi.</span>
                </h1>

                <!-- Sub-Headline: Jelas & Singkat -->
                <p class="text-base sm:text-lg text-slate-600 leading-relaxed max-w-2xl reveal-soft delay-100">
                    Jasa pelancaran saluran pipa mampet untuk rumah tinggal, ruko, dan resto di Jabodetabek, Semarang, dan Lampung. Mengatasi wastafel dapur berlemak, kloset meluap, serta floor drain buntu menggunakan mesin spiral baja Ridgid tanpa membongkar lantai keramik. Garansi tertulis 30 hari.
                </p>

                <!-- Value Checkpoints (Inline Minimalis Tanpa Box Tebal) -->
                <div class="flex flex-wrap items-center gap-x-6 gap-y-2 text-xs sm:text-sm font-semibold text-slate-700 pt-1 reveal-soft delay-150">
                    <span class="flex items-center gap-1.5">
                        <span class="text-emerald-700 font-bold select-none text-base">✓</span>
                        <span>Keramik Utuh</span>
                    </span>
                    <span class="flex items-center gap-1.5">
                        <span class="text-sky-700 font-bold select-none text-base">✓</span>
                        <span>Kamera CCTV Pipa 30M</span>
                    </span>
                    <span class="flex items-center gap-1.5">
                        <span class="text-emerald-700 font-bold select-none text-base">✓</span>
                        <span>Garansi 30 Hari</span>
                    </span>
                </div>

                <!-- Dual CTA: WhatsApp Action Utama & Rincian Biaya -->
                <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-4 pt-2 reveal-soft delay-200">
                    <a href="{{ $generalWaUrl }}" 
                       target="_blank" 
                       rel="noopener noreferrer" 
                       class="btn-press inline-flex items-center justify-center gap-3 bg-emerald-600 hover:bg-emerald-700 active:bg-emerald-800 text-white font-bold text-base px-7 py-3.5 rounded-md shadow-xs transition-colors focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2 min-h-[48px]">
                        <svg class="w-5 h-5 fill-current shrink-0" viewBox="0 0 24 24" aria-hidden="true">
                            <path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/>
                        </svg>
                        <span>Konsultasi Saluran Mampet (WA)</span>
                    </a>

                    <a href="#layanan" 
                       class="btn-press inline-flex items-center justify-center gap-2 bg-white hover:bg-slate-50 active:bg-slate-100 text-slate-800 font-bold text-base px-6 py-3.5 rounded-md border border-slate-300 shadow-xs transition-colors focus:outline-none focus:ring-2 focus:ring-slate-400 focus:ring-offset-2 min-h-[48px]">
                        <span>Lihat Biaya Layanan</span>
                        <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </a>
                </div>

                <!-- Jaminan Ringkas Bawah CTA -->
                <div class="text-xs text-slate-500 flex flex-wrap items-center gap-x-4 gap-y-1 font-medium pt-0.5 reveal-soft delay-200">
                    <span>Bebas Asam / Soda Api Merusak</span>
                    <span>&bull;</span>
                    <span>Bayar Hanya Setelah Saluran Plong</span>
                </div>
            </div>

            <!-- Hero Right: Tampilan Foto Dokumentasi Rapi & Elegan -->
            <div class="lg:col-span-5 reveal-soft delay-150">
                <div class="bg-white rounded-lg p-3 sm:p-4 border border-slate-200 shadow-sm space-y-3 card-lift">
                    
                    <!-- Foto Utama Kerja Teknisi & Mesin Rooter (LCP Optimized) -->
                    <div class="relative rounded-md overflow-hidden aspect-[16/11] bg-slate-900 border border-slate-200">
                        <picture>
                            <source media="(max-width: 640px)" srcset="{{ asset('images/hero-technician-mobile.webp') }}" type="image/webp">
                            <source srcset="{{ asset('images/hero-technician.webp') }}" type="image/webp">
                            <img 
                                src="{{ asset('images/hero-technician.webp') }}" 
                                alt="Teknisi Drainusantara Pelancaran Saluran Tanpa Bongkar" 
                                width="800" 
                                height="550" 
                                loading="eager"
                                fetchpriority="high"
                                decoding="async"
                                class="w-full h-full object-cover"
                            >
                        </picture>
                        <div class="absolute inset-0 p-3 flex flex-col justify-between pointer-events-none">
                            <div class="flex justify-between items-center">
                                <span class="bg-emerald-700/95 text-white text-[11px] font-bold px-2.5 py-1 rounded-sm shadow-xs">
                                    Bebas Bongkar Keramik
                                </span>
                                <span class="bg-slate-900/90 text-sky-300 text-[10px] font-bold px-2 py-0.5 rounded-sm border border-slate-700 uppercase tracking-wide">
                                    Inspeksi CCTV 30M
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- 2 Poin Penegasan Spesifikasi & Jaminan yang Ramping -->
                    <div class="grid grid-cols-2 gap-2 text-xs">
                        <div class="p-2.5 bg-slate-50 rounded-md border border-slate-200">
                            <span class="text-slate-500 text-[11px] block">Peralatan:</span>
                            <span class="font-bold text-slate-800">Mesin Spiral Rotary</span>
                        </div>
                        <div class="p-2.5 bg-slate-50 rounded-md border border-slate-200">
                            <span class="text-slate-500 text-[11px] block">Jaminan:</span>
                            <span class="font-bold text-emerald-700">Garansi 30 Hari</span>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>
</section>

<!-- ====================================================================
     2. ALUR '3 LANGKAH MUDAH' (EDUKATIF & RAMAH PENGGUNA BARU)
==================================================================== -->
<section id="cara-kerja" class="py-16 lg:py-20 bg-white border-b border-slate-200" x-data="mobileCarousel(3, 4000)">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Section Header -->
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
            <!-- Mobile Swipe Hint -->
            <div class="flex md:hidden items-center justify-center gap-1.5 text-xs text-sky-700 font-medium mt-3">
                <svg class="w-4 h-4 animate-bounce-x" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                </svg>
                <span>Geser kartu untuk melihat langkah &bull; Auto-scroll aktif</span>
            </div>
        </div>

        <!-- 3 Sequential Cards Carousel on Mobile, Grid on Desktop -->
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
                        Hubungi Tim & Ceritakan Masalah
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
                        Teknisi Tiba & Cek Lokasi (Tanpa Bongkar)
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

        <!-- Mobile Carousel Dots Indicator -->
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

<!-- ====================================================================
     3. KATALOG MASALAH BERORIENTASI KEBUTUHAN RUMAH (6 LAYANAN SPESIALIS)
==================================================================== -->
@php
    $itemsLayanan = (isset($services) && $services->isNotEmpty()) ? $services : collect($problemCatalogs);
@endphp
<section id="layanan" class="py-16 lg:py-24 bg-slate-50 border-b border-slate-200" x-data="mobileCarousel({{ count($itemsLayanan) }}, 4000)">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Section Header -->
        <div class="text-center max-w-3xl mx-auto mb-10 md:mb-14 reveal-soft">
            <span class="text-xs font-bold uppercase tracking-wider text-sky-700 block mb-2">
                Katalog Spesialis Masalah
            </span>
            <h2 class="text-3xl sm:text-4xl font-extrabold text-slate-900 tracking-tight">
                Layanan Penanganan Saluran Pipa Mampet
            </h2>
            <p class="text-slate-600 text-sm sm:text-base mt-3 leading-relaxed">
                Pembersihan kerak pipa buangan wastafel, kloset duduk, floor drain, talang, dan grease trap menggunakan mesin spiral baja rotary. Dikerjakan dari lubang pipa eksisting tanpa merusak lantai keramik.
            </p>
            <!-- Mobile Swipe Hint -->
            <div class="flex md:hidden items-center justify-center gap-1.5 text-xs text-sky-700 font-medium mt-3">
                <svg class="w-4 h-4 animate-bounce-x" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                </svg>
                <span>Geser untuk melihat opsi layanan &bull; Auto-scroll aktif</span>
            </div>
        </div>

        <!-- Problem Cards Carousel on Mobile, Grid on Desktop -->
        <div x-ref="slider"
             @scroll.passive="onScroll()"
             @touchstart="pause()"
             @touchend="resume()"
             @mouseenter="pause()"
             @mouseleave="resume()"
             class="flex md:grid md:grid-cols-2 lg:grid-cols-3 overflow-x-auto md:overflow-visible snap-x snap-mandatory no-scrollbar gap-4 lg:gap-6 pb-4 pt-1 px-4 -mx-4 sm:mx-0 sm:px-0">
            @foreach($itemsLayanan as $catalog)
                @php
                    $isModel = $catalog instanceof \App\Models\Service;
                    $title = $isModel ? $catalog->name : $catalog['title'];
                    $slug = $isModel ? $catalog->slug : \Illuminate\Support\Str::slug($catalog['title']);
                    $desc = $isModel ? ($catalog->short_description ?: ($catalog->description ?: 'Pelancaran saluran mampet tanpa bongkar keramik.')) : $catalog['problem_desc'];
                    $price = $isModel ? ($catalog->price_starting_from ?: 400000) : $catalog['price'];
                    $features = $isModel ? ($catalog->features ?: []) : ($catalog['specs'] ?? []);
                    
                    // Smart Category Badge
                    $category = 'Layanan Spesialis';
                    $lowerName = strtolower($title);
                    if (str_contains($lowerName, 'wastafel') || str_contains($lowerName, 'dapur') || str_contains($lowerName, 'sink')) {
                        $category = 'Dapur & Residensial';
                    } elseif (str_contains($lowerName, 'kloset') || str_contains($lowerName, 'wc') || str_contains($lowerName, 'toilet')) {
                        $category = 'Toilet & Kamar Mandi';
                    } elseif (str_contains($lowerName, 'floor drain') || str_contains($lowerName, 'kamar mandi')) {
                        $category = 'Kamar Mandi & Lantai';
                    } elseif (str_contains($lowerName, 'cctv') || str_contains($lowerName, 'kamera')) {
                        $category = 'Diagnostik IP68';
                    } elseif (str_contains($lowerName, 'grease') || str_contains($lowerName, 'lemak') || str_contains($lowerName, 'resto')) {
                        $category = 'F&B Komersial';
                    } elseif (str_contains($lowerName, 'talang') || str_contains($lowerName, 'atap')) {
                        $category = 'Talang & Saluran Atap';
                    } elseif (!$isModel && isset($catalog['category'])) {
                        $category = $catalog['category'];
                    }

                    $waMessage = $isModel 
                        ? "Halo Drainusantara, saya butuh penanganan untuk {$title}. Mohon info jadwal teknisi terdekat."
                        : ($catalog['wa_text'] ?? "Halo Drainusantara, saya butuh penanganan untuk {$title}.");
                    $specificWaUrl = "https://wa.me/{$whatsappNumber}?text=" . urlencode($waMessage);
                @endphp
                <div id="layanan-{{ $slug }}" class="w-[84vw] sm:w-[340px] md:w-auto shrink-0 snap-center bg-white rounded-lg border border-slate-200 shadow-xs hover:border-sky-300 hover:shadow-sm transition-all duration-200 flex flex-col justify-between p-5 sm:p-6 group card-lift reveal-soft delay-{{ min($loop->iteration * 50, 300) }}">
                    <div>
                        <!-- Category Badge -->
                        <div class="flex items-center text-xs mb-3">
                            <span class="font-bold text-sky-800 bg-sky-50 px-2.5 py-0.5 rounded-md border border-sky-200">
                                {{ $category }}
                            </span>
                        </div>

                        <!-- Service Title -->
                        <h3 class="text-lg font-bold tracking-tight text-slate-900 group-hover:text-sky-700 transition-colors mb-2">
                            {{ $title }}
                        </h3>

                        <!-- Penjelasan Singkat -->
                        <p class="text-xs sm:text-sm text-slate-600 leading-relaxed mb-4">
                            {{ $desc }}
                        </p>

                        <!-- Features Specs (if available) -->
                        @if(!empty($features) && is_array($features))
                            <ul class="space-y-1.5 text-xs text-slate-600 mb-3 pt-2 border-t border-slate-100">
                                @foreach(array_slice($features, 0, 3) as $feat)
                                    <li class="flex items-center gap-1.5">
                                        <svg class="w-3.5 h-3.5 text-emerald-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                        </svg>
                                        <span>{{ $feat }}</span>
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                    </div>

                    <!-- Footer: Harga + Simple CTA -->
                    <div class="pt-4 mt-5 border-t border-slate-100 flex items-center justify-between gap-3">
                        <div>
                            <span class="text-[11px] text-slate-500 block leading-none mb-1">Tarif Mulai:</span>
                            <div class="text-base sm:text-lg font-extrabold text-slate-900 tracking-tight">
                                Mulai Rp {{ number_format($price, 0, ',', '.') }}
                            </div>
                        </div>

                        <a href="{{ $specificWaUrl }}" target="_blank" rel="noopener noreferrer" 
                           class="btn-press inline-flex items-center justify-center bg-emerald-600 hover:bg-emerald-700 active:bg-emerald-800 text-white font-bold text-xs sm:text-sm px-4 py-2.5 rounded-md shadow-xs transition-colors focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2 min-h-[44px]">
                            <span>Pesan via WA</span>
                        </a>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Mobile Carousel Dots Indicator -->
        <div class="flex md:hidden justify-center items-center gap-1.5 mt-4">
            @for($i = 0; $i < count($itemsLayanan); $i++)
                <button type="button" 
                        @click="goTo({{ $i }})"
                        class="h-2 rounded-full transition-all duration-300 ease-out cursor-pointer active:scale-75"
                        :class="active === {{ $i }} ? 'w-6 bg-sky-700' : 'w-2 bg-slate-300 hover:bg-slate-400'"
                        aria-label="Layanan {{ $i + 1 }}">
                </button>
            @endfor
        </div>

    </div>
</section>

<!-- ====================================================================
     4. 5 KEUNGGULAN UTAMA DRAINUSANTARA (CLEAN ENGINEERING & HIGIENIS)
==================================================================== -->
<section id="keunggulan" class="py-16 lg:py-24 bg-slate-50/70 border-b border-slate-200" x-data="mobileCarousel(5, 4000)">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Section Header -->
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
            <!-- Mobile Swipe Hint -->
            <div class="flex md:hidden items-center justify-center gap-1.5 text-xs text-sky-700 font-medium mt-3">
                <svg class="w-4 h-4 animate-bounce-x" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                </svg>
                <span>Geser untuk melihat 5 keunggulan &bull; Auto-scroll aktif</span>
            </div>
        </div>

        <!-- 5 Cards: Carousel on Mobile, 2+3 Grid on Desktop -->
        <div x-ref="slider"
             @scroll.passive="onScroll()"
             @touchstart="pause()"
             @touchend="resume()"
             @mouseenter="pause()"
             @mouseleave="resume()"
             class="flex md:grid md:grid-cols-2 lg:grid-cols-3 overflow-x-auto md:overflow-visible snap-x snap-mandatory no-scrollbar gap-4 lg:gap-6 pb-4 pt-1 px-1 -mx-1 sm:mx-0 sm:px-0">
            
            <!-- Card 1 (Featured: Col Span 2 on Desktop): Spiral Baja Tanpa Bongkar -->
            <div class="w-[85vw] sm:w-[340px] md:w-auto lg:col-span-2 shrink-0 snap-center p-6 sm:p-8 rounded-xl bg-linear-to-br from-sky-50/70 via-white to-slate-50/60 border border-sky-200/80 hover:border-sky-400 card-lift reveal-soft stagger-1 flex flex-col justify-between shadow-xs">
                <div>
                    <div class="flex flex-wrap items-center justify-between gap-3 mb-4">
                        <span class="inline-flex items-center px-2.5 py-1 bg-sky-600 text-white text-xs font-semibold rounded-md shadow-2xs">
                            Rekayasa Mekanis Modern
                        </span>
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
                    <!-- Highlight Badges -->
                    <div class="flex flex-wrap gap-2 mt-4">
                        <span class="text-xs px-2.5 py-1 rounded-md bg-white border border-slate-200 text-slate-700 font-medium shadow-2xs">
                            Mesin Ridgid K-60
                        </span>
                        <span class="text-xs px-2.5 py-1 rounded-md bg-white border border-slate-200 text-slate-700 font-medium shadow-2xs">
                            Aman untuk Pipa AW &amp; D
                        </span>
                        <span class="text-xs px-2.5 py-1 rounded-md bg-white border border-slate-200 text-slate-700 font-medium shadow-2xs">
                            Hemat Biaya Renovasi
                        </span>
                    </div>
                </div>
                <div class="mt-6 pt-4 border-t border-sky-100 text-xs font-semibold text-sky-800 flex items-center gap-2">
                    <svg class="w-4 h-4 text-sky-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    Solusi mekanis efisien tanpa risiko kebocoran pipa akibat getaran ekstrem
                </div>
            </div>

            <!-- Card 2: Inspeksi Visual Kamera CCTV 30M -->
            <div class="w-[85vw] sm:w-[340px] md:w-auto lg:col-span-1 shrink-0 snap-center p-6 rounded-xl bg-white border border-slate-200/90 hover:border-slate-400 card-lift reveal-soft stagger-2 flex flex-col justify-between shadow-xs">
                <div>
                    <div class="flex items-center justify-between mb-4">
                        <span class="inline-flex items-center px-2.5 py-1 bg-slate-100 border border-slate-200 text-slate-700 text-xs font-medium rounded-md">
                            Kamera IP68
                        </span>
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
                <div class="mt-6 pt-4 border-t border-slate-100 text-xs font-semibold text-slate-600 flex items-center gap-2">
                    <svg class="w-4 h-4 text-sky-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                    Diagnosa visual akurat dengan dokumentasi
                </div>
            </div>

            <!-- Card 3: Biaya Transparan Mulai Rp 400.000 -->
            <div class="w-[85vw] sm:w-[340px] md:w-auto lg:col-span-1 shrink-0 snap-center p-6 rounded-xl bg-white border border-slate-200/90 hover:border-emerald-500 card-lift reveal-soft stagger-3 flex flex-col justify-between shadow-xs">
                <div>
                    <div class="flex items-center justify-between mb-4">
                        <span class="inline-flex items-center px-2.5 py-1 bg-emerald-600 text-white text-xs font-semibold rounded-md shadow-2xs">
                            Biaya Pasti di Awal
                        </span>
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
                <div class="mt-6 pt-4 border-t border-emerald-100 text-xs font-semibold text-emerald-800 flex items-center gap-2">
                    <svg class="w-4 h-4 text-emerald-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    Bayar hanya jika pipa sudah lancar plong (No Cure No Pay)
                </div>
            </div>

            <!-- Card 4: Garansi Resmi 30 Hari -->
            <div class="w-[85vw] sm:w-[340px] md:w-auto lg:col-span-1 shrink-0 snap-center p-6 rounded-xl bg-white border border-slate-200/90 hover:border-sky-300 card-lift reveal-soft stagger-4 flex flex-col justify-between shadow-xs">
                <div>
                    <div class="flex items-center justify-between mb-4">
                        <span class="inline-flex items-center px-2.5 py-1 bg-amber-50 border border-amber-200 text-amber-900 text-xs font-semibold rounded-md">
                            Jaminan Tertulis
                        </span>
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
                <div class="mt-6 pt-4 border-t border-slate-100 text-xs font-semibold text-slate-600 flex items-center gap-2">
                    <svg class="w-4 h-4 text-sky-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4"/>
                    </svg>
                    Proteksi purna jual dengan surat garansi
                </div>
            </div>

            <!-- Card 5: Kerja Higienis & APD Steril -->
            <div class="w-[85vw] sm:w-[340px] md:w-auto lg:col-span-1 shrink-0 snap-center p-6 rounded-xl bg-white border border-slate-200/90 hover:border-sky-300 card-lift reveal-soft delay-250 flex flex-col justify-between shadow-xs">
                <div>
                    <div class="flex items-center justify-between mb-4">
                        <span class="inline-flex items-center px-2.5 py-1 bg-slate-100 border border-slate-200 text-slate-700 text-xs font-semibold rounded-md">
                            Standar Higienis
                        </span>
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
                <div class="mt-6 pt-4 border-t border-slate-100 text-xs font-semibold text-slate-600 flex items-center gap-2">
                    <svg class="w-4 h-4 text-teal-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    Area toilet &amp; dapur tetap bersih bebas bau
                </div>
            </div>

        </div>

        <!-- Mobile Carousel Dots Indicator (5 Dots) -->
        <div class="flex md:hidden justify-center items-center gap-1.5 mt-6">
            @for($i = 0; $i < 5; $i++)
                <button type="button" 
                        @click="goTo({{ $i }})"
                        class="h-2 rounded-full transition-all duration-300 ease-out cursor-pointer active:scale-75"
                        :class="active === {{ $i }} ? 'w-6 bg-sky-700' : 'w-2 bg-slate-300 hover:bg-slate-400'"
                        aria-label="Keunggulan {{ $i + 1 }}">
                </button>
            @endfor
        </div>

    </div>
</section>

<!-- ====================================================================
     5. KOMPARASI FOTO BEFORE & AFTER (BUKTI HASIL KERJA NYATA)
==================================================================== -->
<section id="galeri-before-after" class="py-16 lg:py-24 bg-slate-50 border-b border-slate-200" x-data="mobileCarousel(3, 4500)">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Section Header -->
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-6 mb-10 md:mb-12 reveal-soft">
            <div>
                <span class="text-xs font-bold uppercase tracking-wider text-sky-700 block mb-2">
                    Dokumentasi Pengerjaan
                </span>
                <h2 class="text-3xl sm:text-4xl font-extrabold text-slate-900 tracking-tight">
                    Komparasi Sebelum &amp; Sesudah Pengerjaan
                </h2>
                <p class="text-slate-600 text-sm sm:text-base mt-2 max-w-2xl">
                    Bukti nyata efektivitas mesin rooter mekanik spiral baja dan kamera inspeksi CCTV pipa Drainusantara di lapangan.
                </p>
                <!-- Mobile Swipe Hint -->
                <div class="flex lg:hidden items-center gap-1.5 text-xs text-sky-700 font-medium mt-3">
                    <svg class="w-4 h-4 animate-bounce-x" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                    </svg>
                    <span>Geser untuk melihat bukti komparasi &bull; Auto-scroll aktif</span>
                </div>
            </div>
            <div>
                <a href="{{ url('/galeri') }}" class="inline-flex items-center gap-2 text-sm font-bold text-sky-700 hover:text-sky-800 bg-white hover:bg-sky-50 border border-slate-200 px-5 py-3 rounded-xl shadow-xs transition-colors btn-press">
                    <span>Lihat Semua Dokumentasi</span>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                    </svg>
                </a>
            </div>
        </div>

        <!-- 3 Comparison Split Cards Carousel on Mobile, Grid on Desktop -->
        <div x-ref="slider"
             @scroll.passive="onScroll()"
             @touchstart="pause()"
             @touchend="resume()"
             @mouseenter="pause()"
             @mouseleave="resume()"
             class="flex lg:grid lg:grid-cols-3 overflow-x-auto lg:overflow-visible snap-x snap-mandatory no-scrollbar gap-4 lg:gap-8 pb-4 pt-1 px-4 -mx-4 sm:mx-0 sm:px-0">
            
            <!-- Komparasi 1: Pipa Wastafel Dapur -->
            <div class="w-[85vw] sm:w-[350px] lg:w-auto shrink-0 snap-center bg-white rounded-xl border border-slate-200/90 overflow-hidden shadow-xs hover:shadow-md transition-all card-lift reveal-soft stagger-1 flex flex-col justify-between">
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
                            <span class="absolute top-2.5 left-2.5 bg-red-600 text-white text-[10px] font-bold px-2 py-0.5 rounded-md shadow-xs">
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
                            <span class="absolute top-2.5 left-2.5 bg-emerald-600 text-white text-[10px] font-bold px-2 py-0.5 rounded-md shadow-xs">
                                SESUDAH (PLONG)
                            </span>
                        </div>
                    </div>

                    <div class="p-6">
                        <div class="text-xs text-sky-700 font-bold uppercase mb-1">KASUS: RESTO F&B JAKARTA UTARA</div>
                        <h3 class="text-base font-bold text-slate-900 mb-2">Pelancaran Bak Cuci Piring dari Kerak Lemak Padat</h3>
                        <p class="text-xs text-slate-600 leading-relaxed">
                            Endapan lemak sepanjang 10 meter dikikis tuntas dengan spiral fleksibel rotary tanpa membongkar keramik lantai dapur.
                        </p>
                    </div>
                </div>

                <div class="p-6 pt-0 border-t border-slate-100 mt-4 text-xs text-slate-500 flex justify-between items-center bg-slate-50/50">
                    <span>Durasi: 40 Menit</span>
                    <span class="text-emerald-700 font-bold">Status: Plong Lancar</span>
                </div>
            </div>

            <!-- Komparasi 2: Toilet Kloset Duduk -->
            <div class="w-[85vw] sm:w-[350px] lg:w-auto shrink-0 snap-center bg-white rounded-xl border border-slate-200/90 overflow-hidden shadow-xs hover:shadow-md transition-all card-lift reveal-soft stagger-2 flex flex-col justify-between">
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
                            <span class="absolute top-2.5 left-2.5 bg-red-600 text-white text-[10px] font-bold px-2 py-0.5 rounded-md shadow-xs">
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
                            <span class="absolute top-2.5 left-2.5 bg-emerald-600 text-white text-[10px] font-bold px-2 py-0.5 rounded-md shadow-xs">
                                SESUDAH (LANCAR)
                            </span>
                        </div>
                    </div>

                    <div class="p-6">
                        <div class="text-xs text-sky-700 font-bold uppercase mb-1">KASUS: RUMAH TINGGAL TANGERANG SELATAN</div>
                        <h3 class="text-base font-bold text-slate-900 mb-2">Penarikan Sumbatan Tisu di Leher Angsa Kloset</h3>
                        <p class="text-xs text-slate-600 leading-relaxed">
                            Penarikan benda asing dari lekukan leher angsa porselen kloset duduk lantai 2 dalam waktu 35 menit tanpa mencopot kloset.
                        </p>
                    </div>
                </div>

                <div class="p-6 pt-0 border-t border-slate-100 mt-4 text-xs text-slate-500 flex justify-between items-center bg-slate-50/50">
                    <span>Durasi: 35 Menit</span>
                    <span class="text-emerald-700 font-bold">Status: Bebas Bongkar</span>
                </div>
            </div>

            <!-- Komparasi 3: Deteksi Kamera CCTV -->
            <div class="w-[85vw] sm:w-[350px] lg:w-auto shrink-0 snap-center bg-white rounded-xl border border-slate-200/90 overflow-hidden shadow-xs hover:shadow-md transition-all card-lift reveal-soft stagger-3 flex flex-col justify-between">
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
                            <span class="absolute top-2.5 left-2.5 bg-red-600 text-white text-[10px] font-bold px-2 py-0.5 rounded-md shadow-xs">
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
                            <span class="absolute top-2.5 left-2.5 bg-emerald-600 text-white text-[10px] font-bold px-2 py-0.5 rounded-md shadow-xs">
                                CCTV: BERSIH TUNTAS
                            </span>
                        </div>
                    </div>

                    <div class="p-6">
                        <div class="text-xs text-sky-700 font-bold uppercase mb-1">KASUS: RUKO KANTOR KOTA SEMARANG</div>
                        <h3 class="text-base font-bold text-slate-900 mb-2">Deteksi & Pemotongan Akar Pohon Penembus Pipa</h3>
                        <p class="text-xs text-slate-600 leading-relaxed">
                            Inspeksi kamera CCTV mendeteksi akar pohon menembus sambungan pipa bawah tanah. Dipotong tuntas dengan mata spiral baja pemotong.
                        </p>
                    </div>
                </div>

                <div class="p-6 pt-0 border-t border-slate-100 mt-4 text-xs text-slate-500 flex justify-between items-center bg-slate-50/50">
                    <span>Kedalaman: 18 Meter</span>
                    <span class="text-emerald-700 font-bold">Status: Rekaman Lengkap</span>
                </div>
            </div>

        </div>

        <!-- Mobile Carousel Dots Indicator -->
        <div class="flex lg:hidden justify-center items-center gap-1.5 mt-4">
            @for($i = 0; $i < 3; $i++)
                <button type="button" 
                        @click="goTo({{ $i }})"
                        class="h-2 rounded-full transition-all duration-300 cursor-pointer"
                        :class="active === {{ $i }} ? 'w-6 bg-sky-700' : 'w-2 bg-slate-300'"
                        aria-label="Dokumentasi {{ $i + 1 }}">
                </button>
            @endfor
        </div>

    </div>
</section>

<!-- ====================================================================
     5B. PORTOFOLIO KLIEN B2B & MITRA KOMERSIAL (CAROUSEL SHOWCASE)
==================================================================== -->
@php
    $b2bProjects = (isset($portfolios) && $portfolios->isNotEmpty()) ? $portfolios : collect([
        (object)[
            'client_name' => "D'Cost Seafood Restaurant",
            'client_type' => 'Restoran & F&B Komersial',
            'location' => 'Mall Kelapa Gading, Jakarta Utara',
            'image' => 'https://images.unsplash.com/photo-1517248135467-4c7edcad34c4?auto=format&fit=crop&w=800&q=80',
            'project_title' => 'Pengurasan & De-Greasing Grease Trap 800 Liter',
            'description' => 'Pembersihan kerak minyak jenuh dan lumpur lemak pada bak perangkap lemak dapur komersial sepanjang 25 meter. Dikerjakan malam hari (after-hours) tanpa mengganggu operasional restoran.',
            'specs' => ['Mesin Rooter Spiral K-60', 'After-Hours Service', 'Faktur Pajak B2B & BAST'],
            'guarantee' => 'Garansi Resmi 30 Hari'
        ],
        (object)[
            'client_name' => 'The Alana Hotel & Conference Center',
            'client_type' => 'Perhotelan Bintang 4',
            'location' => 'Sentul City, Bogor',
            'image' => 'https://images.unsplash.com/photo-1566073771259-6a8506099945?auto=format&fit=crop&w=800&q=80',
            'project_title' => 'Pelancaran Saluran Pembuangan Kamar Mandi 42 Kamar',
            'description' => 'Pembersihan endapan busa sabun dan gumpalan rambut pada jalur pipa vertikal kamar mandi tamu. Teknisi ber-APD higienis, pengerjaan cepat dan hening tanpa keluhan dari tamu menginap.',
            'specs' => ['Spiral Baja Lentur 16mm', 'Bebas Suara Bising', 'APD Steril & Rapi'],
            'guarantee' => 'Garansi Resmi 30 Hari'
        ],
        (object)[
            'client_name' => 'Food Court Living World',
            'client_type' => 'Pusat Kuliner Komersial',
            'location' => 'Alam Sutera, Tangerang Selatan',
            'image' => 'https://images.unsplash.com/photo-1555396273-367ea4eb4db5?auto=format&fit=crop&w=800&q=80',
            'project_title' => 'Inspeksi CCTV & Pelancaran Manhole Utama 16 Tenant',
            'description' => 'Penanganan pipa buang komunal grease trap yang meluap ke area servis. Deteksi koordinat endapan lemak beku dengan kamera CCTV pipa 30 meter dan pembersihan mekanis tuntas.',
            'specs' => ['Kamera CCTV IP68 30M', 'Spiral Heavy Duty 22mm', '100% Tanpa Bongkar'],
            'guarantee' => 'Garansi Resmi 30 Hari'
        ],
        (object)[
            'client_name' => 'Gedung Menara Sudirman',
            'client_type' => 'Gedung Perkantoran Bertingkat',
            'location' => 'SCBD, Jakarta Selatan',
            'image' => 'https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?auto=format&fit=crop&w=800&q=80',
            'project_title' => 'Pelancaran Saluran Pipa Talang Rooftop Vertikal 18 Lantai',
            'description' => 'Ekstraksi endapan lumpur dak beton, lumut, dan dedaunan yang menyumbat jalur pembuangan air hujan utama menjelang musim penghujan agar terhindar dari rembesan ke plafon tenant.',
            'specs' => ['Rooter Baja Jangkauan Panjang', 'Sertifikasi K3 Ketinggian', 'Dokumentasi Video CCTV'],
            'guarantee' => 'Garansi Resmi 30 Hari'
        ],
        (object)[
            'client_name' => 'PT Indofood CBP Sukses Makmur',
            'client_type' => 'Fasilitas Manufaktur & Industri',
            'location' => 'Kawasan Industri Cikarang, Bekasi',
            'image' => 'https://images.unsplash.com/photo-1581091226825-a6a2a5aee158?auto=format&fit=crop&w=800&q=80',
            'project_title' => 'Pembersihan Jalur Limbah Domestik Kantin Kapasitas 1.200 Porsi',
            'description' => 'Pengerukan kerak lemak dan residu sisa makanan pada bak kontrol utama kantin pabrik. Menggunakan mesin spiral torsi tinggi bebas bahan kimia berbahaya sehingga aman bagi lingkungan.',
            'specs' => ['Rotary Cleaner Industri', 'Metode Ramah Lingkungan', 'Dokumen BAST Lengkap'],
            'guarantee' => 'Garansi Resmi 30 Hari'
        ],
    ]);
    $b2bWaUrl = "https://wa.me/{$whatsappNumber}?text=" . urlencode("Halo Admin Drainusantara, saya ingin konsultasi penanganan saluran pipa & grease trap untuk perusahaan/gedung kami. Mohon info survey lokasi.");
@endphp

<section id="portofolio-b2b" class="py-16 lg:py-20 bg-slate-50 border-b border-slate-200" 
         x-data="{
             active: 0,
             total: {{ count($b2bProjects) }},
             timer: null,
             _observer: null,
             init() {
                 if (typeof window === 'undefined') return;
                 if ('IntersectionObserver' in window && this.$refs.b2bSlider) {
                     this._observer = new IntersectionObserver((entries) => {
                         entries.forEach(entry => {
                             if (entry.isIntersecting && window.innerWidth < 1024) {
                                 this.startAuto();
                             } else {
                                 this.pause();
                             }
                         });
                     }, { threshold: 0.2 });
                     this._observer.observe(this.$refs.b2bSlider);
                 } else if (window.innerWidth < 1024) {
                     this.startAuto();
                 }
             },
             startAuto() {
                 if (window.innerWidth >= 1024) return;
                 this.pause();
                 this.timer = setInterval(() => { this.next(); }, 4500);
             },
             pause() {
                 if (this.timer) {
                     clearInterval(this.timer);
                     this.timer = null;
                 }
             },
             resume() {
                 if (window.innerWidth >= 1024) return;
                 this.startAuto();
             },
             next() {
                 this.goTo((this.active + 1) % this.total);
             },
             prev() {
                 this.goTo((this.active - 1 + this.total) % this.total);
             },
             goTo(index) {
                 this.active = index;
                 const slider = this.$refs.b2bSlider;
                 if (slider) {
                     const cards = slider.children;
                     if (cards[index]) {
                         const targetLeft = Math.max(0, cards[index].offsetLeft - slider.offsetLeft - 8);
                         slider.scrollTo({ 
                             left: targetLeft, 
                             behavior: 'smooth' 
                         });
                     }
                 }
             },
             onScroll() {
                 if (!this.$refs.b2bSlider) return;
                 const slider = this.$refs.b2bSlider;
                 const scrollLeft = slider.scrollLeft;
                 const cardWidth = slider.firstElementChild ? slider.firstElementChild.offsetWidth : 320;
                 const newIndex = Math.round(scrollLeft / cardWidth);
                 if (newIndex >= 0 && newIndex < this.total && newIndex !== this.active) {
                     this.active = newIndex;
                 }
             }
         }">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Section Header with Prev / Next Navigation -->
        <div class="flex flex-col md:flex-row items-start md:items-end justify-between gap-6 mb-10 md:mb-12">
            <div class="reveal-soft">
                <span class="text-xs font-bold uppercase tracking-wider text-sky-700 block mb-2">
                    Layanan Komersial &amp; Gedung
                </span>
                <h2 class="text-2xl sm:text-3xl lg:text-4xl font-extrabold text-slate-900 tracking-tight">
                    Dipercaya Perusahaan F&amp;B, Perhotelan &amp; Gedung Bertingkat
                </h2>
                <p class="text-slate-600 text-xs sm:text-sm mt-2 max-w-2xl leading-relaxed">
                    Solusi pemeliharaan saluran pipa limbah dan grease trap berkala dengan standar kepatuhan K3, sertifikat garansi pengerjaan, dan faktur pajak resmi.
                </p>
            </div>

            <!-- Desktop Carousel Controls -->
            <div class="hidden sm:flex items-center gap-2 shrink-0 reveal-soft delay-100">
                <button type="button" 
                        @click="prev()" 
                        class="w-10 h-10 rounded-xl bg-white hover:bg-sky-50 text-slate-700 hover:text-sky-700 border border-slate-200/90 hover:border-sky-300 transition-all shadow-2xs flex items-center justify-center cursor-pointer btn-press"
                        aria-label="Proyek Sebelumnya">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                    </svg>
                </button>
                <button type="button" 
                        @click="next()" 
                        class="w-10 h-10 rounded-xl bg-white hover:bg-sky-50 text-slate-700 hover:text-sky-700 border border-slate-200/90 hover:border-sky-300 transition-all shadow-2xs flex items-center justify-center cursor-pointer btn-press"
                        aria-label="Proyek Berikutnya">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </button>
            </div>
        </div>

        <!-- Carousel Slider Track -->
        <div x-ref="b2bSlider"
             @scroll.passive="onScroll()"
             @touchstart="pause()"
             @touchend="resume()"
             @mouseenter="pause()"
             @mouseleave="resume()"
             class="flex overflow-x-auto snap-x snap-mandatory no-scrollbar gap-5 lg:gap-6 pb-4 pt-1 px-1 -mx-1 sm:mx-0 sm:px-0">
            @foreach($b2bProjects as $project)
                <div class="w-[85vw] sm:w-[350px] lg:w-[calc(33.333%-1rem)] shrink-0 snap-center relative rounded-xl border border-slate-700/50 overflow-hidden min-h-[320px] sm:min-h-[340px] flex flex-col justify-between p-6 group transition-all duration-300 hover:border-sky-400/80 shadow-md card-lift">
                    <!-- Background Photo with Subtle Blur & Clear Visibility -->
                    <div class="absolute inset-0 z-0 overflow-hidden pointer-events-none">
                        <img src="{{ $project->image ?? 'https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?auto=format&fit=crop&w=800&q=80' }}" 
                             alt="{{ $project->client_name }}" 
                             loading="lazy"
                             class="w-full h-full object-cover blur-[1px] scale-105 brightness-[0.92] group-hover:scale-110 transition-transform duration-700">
                        <!-- Gradient Overlay: Transparent at top so the photo is clearly recognizable, dark at bottom for crisp text contrast -->
                        <div class="absolute inset-0 bg-gradient-to-t from-slate-950 via-slate-950/70 via-55% to-transparent"></div>
                    </div>

                    <!-- Content Relative z-10 -->
                    <div class="relative z-10">
                        <!-- Top Meta: Sector Badge & Location -->
                        <div class="flex items-center justify-between gap-2 mb-4">
                            <span class="inline-flex items-center px-2.5 py-1 bg-slate-900/80 backdrop-blur-xs text-sky-300 text-[11px] font-bold rounded-md border border-slate-700/70">
                                {{ $project->client_type }}
                            </span>
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 bg-slate-900/80 backdrop-blur-xs text-slate-200 text-[11px] font-medium rounded-md border border-slate-700/70 truncate max-w-[150px]">
                                <svg class="w-3 h-3 text-sky-400 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                                <span class="truncate">{{ $project->location }}</span>
                            </span>
                        </div>

                        <!-- Client Name -->
                        <h3 class="text-lg sm:text-xl font-bold text-white tracking-tight line-clamp-1 mb-1 group-hover:text-sky-300 transition-colors drop-shadow-xs">
                            {{ $project->client_name }}
                        </h3>

                        <!-- Project Title -->
                        <div class="text-xs font-semibold text-sky-400/90 mb-3 drop-shadow-2xs">
                            {{ $project->project_title }}
                        </div>

                        <!-- Simplified Description -->
                        <p class="text-xs sm:text-sm text-slate-200/90 leading-relaxed line-clamp-3">
                            {{ $project->description }}
                        </p>
                    </div>

                    <!-- Bottom Bar: Guarantee & Tag -->
                    <div class="relative z-10 mt-5 pt-3.5 border-t border-white/15 flex items-center justify-between text-xs">
                        <span class="inline-flex items-center gap-1.5 font-bold text-emerald-400">
                            <svg class="w-3.5 h-3.5 text-emerald-400" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                            </svg>
                            <span>{{ $project->guarantee ?? 'Garansi Resmi 30 Hari' }}</span>
                        </span>
                        <span class="text-[11px] font-semibold text-slate-300 bg-white/10 px-2 py-0.5 rounded border border-white/10">
                            Bebas Bongkar
                        </span>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Carousel Dots Indicator -->
        <div class="flex justify-center items-center gap-1.5 mt-5">
            @for($i = 0; $i < count($b2bProjects); $i++)
                <button type="button" 
                        @click="goTo({{ $i }})"
                        class="h-2 rounded-full transition-all duration-300 cursor-pointer"
                        :class="active === {{ $i }} ? 'w-6 bg-sky-700' : 'w-2 bg-slate-300'"
                        aria-label="Proyek B2B {{ $i + 1 }}">
                </button>
            @endfor
        </div>

        <!-- B2B Direct Consultation Banner -->
        <div class="mt-10 bg-white rounded-xl border border-slate-200 p-5 sm:p-6 flex flex-col sm:flex-row items-center justify-between gap-4 shadow-2xs reveal-soft">
            <div class="flex items-center gap-3.5 text-center sm:text-left">
                <div class="w-11 h-11 rounded-xl bg-sky-50 border border-sky-200 text-sky-700 flex items-center justify-center shrink-0 hidden sm:flex">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                    </svg>
                </div>
                <div>
                    <h4 class="text-sm sm:text-base font-bold text-slate-900">Butuh Survei Lokasi atau Penawaran Kontrak B2B?</h4>
                    <p class="text-xs text-slate-500 mt-0.5">Tersedia invoice resmi, faktur pajak PPN, Berita Acara (BAST), dan penanganan di luar jam operasional bisnis.</p>
                </div>
            </div>
            <a href="{{ $b2bWaUrl }}" target="_blank" rel="noopener noreferrer" 
               class="shrink-0 inline-flex items-center gap-2 px-5 py-2.5 rounded-lg bg-emerald-600 hover:bg-emerald-700 text-white text-xs sm:text-sm font-bold transition-colors shadow-2xs btn-press">
                <span>Konsultasi B2B via WhatsApp</span>
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                </svg>
            </a>
        </div>

    </div>
</section>

<!-- ====================================================================
     6. EDUKASI & ARTIKEL PIPA: PANDUAN TEKNIS DRAINASE RESIDENSIAL
==================================================================== -->
<section id="edukasi" class="py-16 lg:py-24 bg-white border-b border-slate-200" x-data="mobileCarousel({{ max(1, count($articles)) }}, 4500)">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Section Header -->
        <div class="text-center max-w-3xl mx-auto mb-10 md:mb-14 reveal-soft">
            <span class="text-xs font-bold uppercase tracking-wider text-sky-700 block mb-2">
                Panduan Teknis &amp; Sanitasi
            </span>
            <h2 class="text-3xl sm:text-4xl font-extrabold text-slate-900 tracking-tight">
                Edukasi &amp; Tips Perawatan Saluran Pipa
            </h2>
            <p class="text-slate-600 text-sm sm:text-base mt-3 leading-relaxed">
                Pelajari langkah pencegahan pipa mampet, bahaya bahan kimia korosif, dan standar pemeliharaan sanitasi hunian Anda.
            </p>
            <!-- Mobile Swipe Hint -->
            <div class="flex lg:hidden items-center justify-center gap-1.5 text-xs text-sky-700 font-medium mt-3">
                <svg class="w-4 h-4 animate-bounce-x" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                </svg>
                <span>Geser artikel &bull; Auto-scroll aktif</span>
            </div>
        </div>

        <!-- Dynamic Articles: Carousel on Mobile (<lg), 3-Column Grid on Desktop (>=lg) -->
        <div x-ref="slider"
             @scroll.passive="onScroll()"
             @touchstart="pause()"
             @touchend="resume()"
             @mouseenter="pause()"
             @mouseleave="resume()"
             class="flex lg:grid lg:grid-cols-3 overflow-x-auto lg:overflow-visible snap-x snap-mandatory no-scrollbar gap-5 lg:gap-8 pb-4 pt-1 px-4 -mx-4 sm:mx-0 sm:px-0">
            @forelse($articles as $article)
                <article class="w-[85vw] sm:w-[350px] lg:w-auto shrink-0 snap-center bg-white rounded-xl border border-slate-200/90 overflow-hidden hover:border-sky-300 hover:shadow-md transition-all flex flex-col justify-between group card-lift reveal-soft delay-{{ min($loop->iteration * 75, 300) }}">
                    <div>
                        <!-- Thumbnail Image -->
                        <div class="relative aspect-[16/10] bg-slate-100 overflow-hidden border-b border-slate-100">
                            <img 
                                src="{{ $article->thumbnail ?: 'https://placehold.co/800x500/0284c7/ffffff?text=' . urlencode($article->title) }}" 
                                alt="{{ $article->title }}" 
                                class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300"
                                width="600"
                                height="375"
                                loading="lazy"
                                decoding="async"
                            >
                            <span class="absolute top-3 left-3 bg-white/95 backdrop-blur-xs text-sky-800 text-[11px] font-bold px-2.5 py-1 rounded-md shadow-2xs border border-slate-200/80">
                                {{ $article->category ?? 'Tips & Edukasi' }}
                            </span>
                        </div>

                        <!-- Card Content -->
                        <div class="p-6">
                            <div class="flex items-center gap-2 text-xs text-slate-400 mb-2.5">
                                <span>{{ $article->published_at ? $article->published_at->format('d M Y') : $article->created_at->format('d M Y') }}</span>
                                <span>&bull;</span>
                                <span class="text-slate-500 font-medium">4 Menit Baca</span>
                            </div>

                            <h3 class="text-base sm:text-lg font-bold text-slate-900 group-hover:text-sky-700 transition-colors line-clamp-2 leading-snug">
                                <a href="{{ route('articles.show', $article->slug) }}">
                                    {{ $article->title }}
                                </a>
                            </h3>

                            <p class="text-xs sm:text-sm text-slate-600 leading-relaxed mt-2.5 line-clamp-3">
                                {{ $article->excerpt ?? Str::limit(strip_tags($article->content), 120) }}
                            </p>
                        </div>
                    </div>

                    <!-- Footer Link -->
                    <div class="p-6 pt-0 border-t border-slate-100 mt-4 flex items-center justify-between text-xs">
                        <a href="{{ route('articles.show', $article->slug) }}" class="font-bold text-sky-700 group-hover:text-sky-800 inline-flex items-center transition-colors">
                            <span>Baca Selengkapnya</span>
                        </a>
                        <span class="text-slate-400 text-[11px]">Tim Ahli Drainusantara</span>
                    </div>
                </article>
            @empty
                <div class="w-full col-span-3 text-center py-12 bg-slate-50 rounded-xl border border-slate-200 p-8">
                    <p class="text-slate-500 text-sm">Belum ada artikel yang diterbitkan.</p>
                </div>
            @endforelse
        </div>

        <!-- Mobile Carousel Dots Indicator -->
        @if(count($articles) > 1)
        <div class="flex lg:hidden justify-center items-center gap-1.5 mt-5">
            @for($i = 0; $i < count($articles); $i++)
                <button type="button" 
                        @click="goTo({{ $i }})"
                        class="h-2 rounded-full transition-all duration-300 cursor-pointer"
                        :class="active === {{ $i }} ? 'w-6 bg-sky-700' : 'w-2 bg-slate-300'"
                        aria-label="Artikel {{ $i + 1 }}">
                </button>
            @endfor
        </div>
        @endif

        <!-- Section Bottom CTA: View All Articles -->
        <div class="mt-10 sm:mt-12 text-center reveal-soft">
            <a href="{{ route('articles.index') }}" 
               class="inline-flex items-center justify-center gap-2 px-6 py-3 bg-white hover:bg-slate-50 text-slate-800 hover:text-sky-700 font-bold text-xs sm:text-sm rounded-xl border border-slate-200 shadow-2xs hover:shadow-xs transition-all btn-press">
                <span>Lihat Semua Artikel &amp; Panduan Edukasi Sanitasi</span>
                <svg class="w-4 h-4 text-sky-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                </svg>
            </a>
        </div>

    </div>
</section>

<!-- ====================================================================
     7. WILAYAH JANGKAUAN TEKNIS (TECHNICAL AREA BOARD - 3 CARDS)
==================================================================== -->
<section id="area" class="bg-slate-50 border-b border-slate-200 py-16 lg:py-20" x-data="mobileCarousel(3, 4500)">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Section Header -->
        <div class="flex flex-col lg:flex-row items-start lg:items-center justify-between gap-6 mb-10 md:mb-12 reveal-soft">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl bg-sky-700 text-white flex items-center justify-center shrink-0 shadow-xs">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                </div>
                <div>
                    <h2 class="text-2xl sm:text-3xl font-extrabold tracking-tight text-slate-900">Wilayah Jangkauan Armada Drainusantara</h2>
                    <p class="text-xs sm:text-sm text-slate-600 mt-1">Posko teknisi siaga di seluruh Jabodetabek, Semarang, dan Lampung dengan respon WhatsApp sigap &amp; cepat.</p>
                </div>
            </div>

            <div class="inline-flex items-center px-3.5 py-1.5 bg-white border border-slate-200 rounded-md text-xs font-bold text-slate-800 shadow-2xs">
                <span>Armada Siaga 24 Jam</span>
            </div>
        </div>

        <!-- 3 Cards Grid (Desktop: 3 Columns, Mobile: Horizontal Carousel) -->
        <div x-ref="slider"
             @scroll.passive="onScroll()"
             @touchstart="pause()"
             @touchend="resume()"
             @mouseenter="pause()"
             @mouseleave="resume()"
             class="flex lg:grid lg:grid-cols-3 overflow-x-auto lg:overflow-visible snap-x snap-mandatory no-scrollbar gap-5 lg:gap-6 pb-4 pt-1 px-1 -mx-1 sm:mx-0 sm:px-0 items-stretch">
            
            <!-- Card 1: DKI JAKARTA -->
            <div class="w-[85vw] sm:w-[350px] lg:w-auto shrink-0 snap-center bg-white rounded-xl p-6 sm:p-7 border border-slate-200/90 hover:border-sky-400 hover:shadow-xs transition-all flex flex-col justify-between card-lift reveal-soft stagger-1">
                <div>
                    <!-- Card Header -->
                    <div class="flex items-center justify-between gap-3 mb-4">
                        <span class="inline-flex items-center px-2.5 py-1 bg-sky-50 border border-sky-200 text-sky-800 text-xs font-semibold rounded-md">
                            Posko Pusat Siaga 24 Jam
                        </span>
                        <div class="w-9 h-9 rounded-lg bg-sky-50 border border-sky-200 text-sky-700 flex items-center justify-center shrink-0">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                            </svg>
                        </div>
                    </div>

                    <h3 class="text-xl font-bold text-slate-900 tracking-tight mb-2">DKI Jakarta</h3>
                    
                    <!-- Deskripsi Singkat -->
                    <p class="text-xs sm:text-sm text-slate-600 leading-relaxed mb-5">
                        Armada teknisi siaga 24 jam menjangkau 5 kota administrasi. Siap menangani perumahan, apartemen, ruko, restoran, hingga gedung perkantoran.
                    </p>

                    <!-- Area Layanan Utama (Grid 2 Kolom) -->
                    <div class="pt-4 border-t border-slate-100">
                        <span class="text-xs font-bold uppercase tracking-wider text-slate-400 block mb-2.5">
                            Area Layanan Utama:
                        </span>
                        <div class="grid grid-cols-2 gap-2">
                            <a href="{{ route('area.city', ['city' => 'jakarta-selatan']) }}" class="p-2.5 rounded-lg bg-slate-50 hover:bg-sky-50 text-slate-800 hover:text-sky-700 border border-slate-200/80 hover:border-sky-300 transition-colors flex flex-col justify-between">
                                <div class="font-semibold text-xs text-slate-900 truncate">Jakarta Selatan</div>
                                <div class="text-[11px] text-slate-500 mt-1 line-clamp-1">Kebayoran, Kemang, Tebet</div>
                            </a>
                            <a href="{{ route('area.city', ['city' => 'jakarta-barat']) }}" class="p-2.5 rounded-lg bg-slate-50 hover:bg-sky-50 text-slate-800 hover:text-sky-700 border border-slate-200/80 hover:border-sky-300 transition-colors flex flex-col justify-between">
                                <div class="font-semibold text-xs text-slate-900 truncate">Jakarta Barat</div>
                                <div class="text-[11px] text-slate-500 mt-1 line-clamp-1">Kebon Jeruk, Puri, Grogol</div>
                            </a>
                            <a href="{{ route('area.city', ['city' => 'jakarta-timur']) }}" class="p-2.5 rounded-lg bg-slate-50 hover:bg-sky-50 text-slate-800 hover:text-sky-700 border border-slate-200/80 hover:border-sky-300 transition-colors flex flex-col justify-between">
                                <div class="font-semibold text-xs text-slate-900 truncate">Jakarta Timur</div>
                                <div class="text-[11px] text-slate-500 mt-1 line-clamp-1">Duren Sawit, Cakung, Ciracas</div>
                            </a>
                            <a href="{{ route('area.city', ['city' => 'jakarta-utara']) }}" class="p-2.5 rounded-lg bg-slate-50 hover:bg-sky-50 text-slate-800 hover:text-sky-700 border border-slate-200/80 hover:border-sky-300 transition-colors flex flex-col justify-between">
                                <div class="font-semibold text-xs text-slate-900 truncate">Jakarta Utara</div>
                                <div class="text-[11px] text-slate-500 mt-1 line-clamp-1">Kelapa Gading, PIK, Sunter</div>
                            </a>
                            <a href="{{ route('area.city', ['city' => 'jakarta-pusat']) }}" class="col-span-2 p-2.5 rounded-lg bg-slate-50 hover:bg-sky-50 text-slate-800 hover:text-sky-700 border border-slate-200/80 hover:border-sky-300 transition-colors flex items-center justify-between">
                                <div class="font-semibold text-xs text-slate-900">Jakarta Pusat</div>
                                <div class="text-[11px] text-slate-500">Menteng, Cempaka Putih, Kemayoran</div>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Footer Card / CTA -->
                <div class="mt-6 pt-4 border-t border-slate-100 flex items-center justify-between gap-3">
                    <a href="{{ route('area.province', ['province' => 'dki-jakarta']) }}" class="text-xs font-bold text-sky-700 hover:text-sky-800 hover:underline">
                        Lihat 44 Kecamatan &rarr;
                    </a>
                    @php
                        $waJktText = urlencode("Halo Drainusantara, saya butuh teknisi saluran mampet untuk area DKI Jakarta. Mohon info jadwal kedatangan.");
                    @endphp
                    <a href="https://wa.me/{{ $whatsappNumber }}?text={{ $waJktText }}" target="_blank" rel="noopener noreferrer"
                       class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold transition-colors shadow-2xs btn-press">
                        <span>Panggil Teknisi</span>
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                        </svg>
                    </a>
                </div>
            </div>

            <!-- Card 2: BODETABEK -->
            <div class="w-[85vw] sm:w-[350px] lg:w-auto shrink-0 snap-center bg-white rounded-xl p-6 sm:p-7 border border-slate-200/90 hover:border-sky-400 hover:shadow-xs transition-all flex flex-col justify-between card-lift reveal-soft stagger-2">
                <div>
                    <!-- Card Header -->
                    <div class="flex items-center justify-between gap-3 mb-4">
                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs font-semibold rounded-md">
                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-600"></span>
                            Kawasan Penyangga Ibu Kota
                        </span>
                        <div class="w-9 h-9 rounded-lg bg-emerald-50 border border-emerald-200 text-emerald-700 flex items-center justify-center shrink-0">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                            </svg>
                        </div>
                    </div>

                    <h3 class="text-xl font-bold text-slate-900 tracking-tight mb-2">BODETABEK</h3>
                    
                    <!-- Deskripsi Singkat -->
                    <p class="text-xs sm:text-sm text-slate-600 leading-relaxed mb-5">
                        Posko teknisi tersebar di koridor perumahan dan klaster hunian penyangga ibu kota. Respon cepat tangani pipa mampet tanpa bongkar lantai ubin maupun keramik.
                    </p>

                    <!-- Area Layanan Utama (Grid 2 Kolom) -->
                    <div class="pt-4 border-t border-slate-100">
                        <span class="text-xs font-bold uppercase tracking-wider text-slate-400 block mb-2.5">
                            Area Layanan Utama:
                        </span>
                        <div class="grid grid-cols-2 gap-2">
                            <a href="{{ route('area.city', ['city' => 'bogor']) }}" class="p-2.5 rounded-lg bg-slate-50 hover:bg-sky-50 text-slate-800 hover:text-sky-700 border border-slate-200/80 hover:border-sky-300 transition-colors flex flex-col justify-between">
                                <div class="font-semibold text-xs text-slate-900 truncate">Bogor &amp; Sentul</div>
                                <div class="text-[11px] text-slate-500 mt-1 line-clamp-1">Sentul City, Cibinong, Bogor Kota</div>
                            </a>
                            <a href="{{ route('area.city', ['city' => 'depok-cinere']) }}" class="p-2.5 rounded-lg bg-slate-50 hover:bg-sky-50 text-slate-800 hover:text-sky-700 border border-slate-200/80 hover:border-sky-300 transition-colors flex flex-col justify-between">
                                <div class="font-semibold text-xs text-slate-900 truncate">Depok &amp; Cinere</div>
                                <div class="text-[11px] text-slate-500 mt-1 line-clamp-1">Margonda, Sawangan, Cinere</div>
                            </a>
                            <a href="{{ route('area.city', ['city' => 'tangerang-kota']) }}" class="p-2.5 rounded-lg bg-slate-50 hover:bg-sky-50 text-slate-800 hover:text-sky-700 border border-slate-200/80 hover:border-sky-300 transition-colors flex flex-col justify-between">
                                <div class="font-semibold text-xs text-slate-900 truncate">Tangerang Kota</div>
                                <div class="text-[11px] text-slate-500 mt-1 line-clamp-1">Cipondoh, Karawaci, Ciledug</div>
                            </a>
                            <a href="{{ route('area.city', ['city' => 'tangerang-selatan']) }}" class="p-2.5 rounded-lg bg-slate-50 hover:bg-sky-50 text-slate-800 hover:text-sky-700 border border-slate-200/80 hover:border-sky-300 transition-colors flex flex-col justify-between">
                                <div class="font-semibold text-xs text-slate-900 truncate">Tangsel</div>
                                <div class="text-[11px] text-slate-500 mt-1 line-clamp-1">BSD City, Bintaro, Serpong</div>
                            </a>
                            <a href="{{ route('area.city', ['city' => 'bekasi-cikarang']) }}" class="col-span-2 p-2.5 rounded-lg bg-slate-50 hover:bg-sky-50 text-slate-800 hover:text-sky-700 border border-slate-200/80 hover:border-sky-300 transition-colors flex items-center justify-between">
                                <div class="font-semibold text-xs text-slate-900">Bekasi &amp; Cikarang</div>
                                <div class="text-[11px] text-slate-500">Bekasi Barat, Harapan Indah, Cikarang</div>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Footer Card / CTA -->
                <div class="mt-6 pt-4 border-t border-slate-100 flex items-center justify-between gap-3">
                    <span class="text-xs text-slate-500 font-medium">Banten &amp; Jabar</span>
                    @php
                        $waBodetabekText = urlencode("Halo Drainusantara, saya butuh teknisi saluran mampet untuk area Bodetabek. Mohon info teknisi terdekat.");
                    @endphp
                    <a href="https://wa.me/{{ $whatsappNumber }}?text={{ $waBodetabekText }}" target="_blank" rel="noopener noreferrer"
                       class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold transition-colors shadow-2xs btn-press">
                        <span>Panggil Teknisi</span>
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                        </svg>
                    </a>
                </div>
            </div>

            <!-- Card 3: SEMARANG & BANDAR LAMPUNG -->
            <div class="w-[85vw] sm:w-[350px] lg:w-auto shrink-0 snap-center bg-white rounded-xl p-6 sm:p-7 border border-slate-200/90 hover:border-sky-400 hover:shadow-xs transition-all flex flex-col justify-between card-lift reveal-soft stagger-3">
                <div>
                    <!-- Card Header -->
                    <div class="flex items-center justify-between gap-3 mb-4">
                        <span class="inline-flex items-center px-2.5 py-1 bg-indigo-50 border border-indigo-200 text-indigo-800 text-xs font-semibold rounded-md">
                            Hub Jawa Tengah &amp; Sumatera
                        </span>
                        <div class="w-9 h-9 rounded-lg bg-indigo-50 border border-indigo-200 text-indigo-700 flex items-center justify-center shrink-0">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                    </div>

                    <h3 class="text-xl font-bold text-slate-900 tracking-tight mb-2">Semarang &amp; Bandar Lampung</h3>
                    
                    <!-- Deskripsi Singkat -->
                    <p class="text-xs sm:text-sm text-slate-600 leading-relaxed mb-5">
                        Posko regional siaga melayani rumah tinggal, industri, instansi, restoran, dan perhotelan dengan mesin spiral mekanis bergaransi resmi 30 hari.
                    </p>

                    <!-- Area Layanan Utama (Grid 2 Kolom) -->
                    <div class="pt-4 border-t border-slate-100">
                        <span class="text-xs font-bold uppercase tracking-wider text-slate-400 block mb-2.5">
                            Area Layanan Utama:
                        </span>
                        <div class="grid grid-cols-2 gap-2">
                            <!-- Semarang -->
                            <a href="{{ route('area.city', ['city' => 'semarang']) }}" class="p-3 rounded-lg bg-slate-50 hover:bg-sky-50 text-slate-800 hover:text-sky-700 border border-slate-200/80 hover:border-sky-300 transition-colors flex flex-col justify-between">
                                <div>
                                    <div class="font-semibold text-xs text-slate-900 truncate">Kota Semarang</div>
                                    <span class="text-[10px] text-sky-700 font-bold bg-sky-50 px-1.5 py-0.5 rounded border border-sky-200 inline-block mt-1">Jawa Tengah</span>
                                </div>
                                <div class="text-[11px] text-slate-500 mt-2 line-clamp-2">Candisari, Banyumanik, Simpang Lima, Tembalang, Ngaliyan</div>
                            </a>

                            <!-- Bandar Lampung -->
                            <a href="{{ route('area.city', ['city' => 'bandar-lampung']) }}" class="p-3 rounded-lg bg-slate-50 hover:bg-sky-50 text-slate-800 hover:text-sky-700 border border-slate-200/80 hover:border-sky-300 transition-colors flex flex-col justify-between">
                                <div>
                                    <div class="font-semibold text-xs text-slate-900 truncate">Bandar Lampung</div>
                                    <span class="text-[10px] text-indigo-700 font-bold bg-indigo-50 px-2 py-0.5 rounded border border-indigo-200 inline-block mt-1">Sumatera</span>
                                </div>
                                <div class="text-[11px] text-slate-500 mt-2 line-clamp-2">Kedaton, Tanjung Karang, Way Halim, Teluk Betung, Rajabasa</div>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Footer Card / CTA -->
                <div class="mt-6 pt-4 border-t border-slate-100 flex items-center justify-between gap-3">
                    <div class="flex items-center gap-2 text-xs font-bold">
                        <a href="{{ route('area.province', ['province' => 'jawa-tengah']) }}" class="text-sky-700 hover:underline">Jateng</a>
                        <span class="text-slate-300">&bull;</span>
                        <a href="{{ route('area.province', ['province' => 'lampung']) }}" class="text-sky-700 hover:underline">Lampung</a>
                    </div>
                    @php
                        $waRegionalText = urlencode("Halo Drainusantara, saya butuh teknisi saluran mampet untuk area Semarang / Bandar Lampung. Mohon info jadwal kedatangan.");
                    @endphp
                    <a href="https://wa.me/{{ $whatsappNumber }}?text={{ $waRegionalText }}" target="_blank" rel="noopener noreferrer"
                       class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold transition-colors shadow-2xs btn-press">
                        <span>Panggil Teknisi</span>
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                        </svg>
                    </a>
                </div>
            </div>

        </div>

        <!-- Mobile Carousel Dots Indicator (3 Dots) -->
        <div class="flex lg:hidden justify-center items-center gap-1.5 mt-5">
            @for($i = 0; $i < 3; $i++)
                <button type="button" 
                        @click="goTo({{ $i }})"
                        class="h-2 rounded-full transition-all duration-300 cursor-pointer"
                        :class="active === {{ $i }} ? 'w-6 bg-sky-700' : 'w-2 bg-slate-300'"
                        aria-label="Wilayah {{ $i + 1 }}">
                </button>
            @endfor
        </div>

        <!-- Full Directory Banner Link -->
        <div class="mt-8 bg-sky-50/80 border border-sky-200/80 rounded-xl p-5 flex flex-col sm:flex-row items-center justify-between gap-4">
            <div class="flex items-center gap-3 text-xs sm:text-sm text-slate-700">
                <svg class="w-5 h-5 text-sky-700 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                </svg>
                <span>Cari kecamatan atau kota spesifik lainnya? Buka peta direktori lengkap seluruh provinsi layanan kami.</span>
            </div>
            <a href="{{ route('area.index') }}" class="shrink-0 inline-flex items-center gap-2 px-5 py-2.5 bg-sky-700 hover:bg-sky-800 text-white text-xs font-bold rounded-lg transition-colors shadow-xs">
                <span>Lihat Direktori Seluruh Area</span>
                <span>&rarr;</span>
            </a>
        </div>

    </div>
</section>

<!-- ====================================================================
     8. PENGALAMAN NYATA BERSAMA DRAINUSANTARA (CERITA DARI LAPANGAN)
==================================================================== -->
@php
    $displayStories = collect([
        (object)[
            'case_badge' => 'Wastafel Dapur',
            'status' => 'Bebas Bongkar',
            'comment' => 'Awalnya panik wastafel dapur meluap pas lagi siap-siap masak. Takut banget kalau harus bobok keramik kitchen set. Mas teknisi datang cepat bawa mesin spiral, sekitar 35 menit leher angsa bersih, air langsung lancar dan dapur ditinggal dalam kondisi rapi.',
            'customer_name' => 'Ibu Ratna Dewi',
            'customer_role_or_location' => 'Duren Sawit, Jakarta Timur',
            'initial' => 'R'
        ],
        (object)[
            'case_badge' => 'Kloset Lantai 2',
            'status' => 'Bebas Bongkar',
            'comment' => 'Kloset duduk lantai atas mampet airnya meluap hampir ke kamar. Sempat mikir bakal dicopot klosetnya, ternyata dikerjakan lewat pipa pakai spiral khusus tanpa dibongkar sama sekali. Masalah beres, langsung dikasih nota garansi tertulis 30 hari.',
            'customer_name' => 'Bpk. Hendra Wijaya',
            'customer_role_or_location' => 'BSD City, Tangerang Selatan',
            'initial' => 'H'
        ],
        (object)[
            'case_badge' => 'Grease Trap Resto',
            'status' => 'Bebas Bongkar',
            'comment' => 'Saluran grease trap resto kami di Kelapa Gading mampet oleh lemak jenuh pas jam sibuk. Drainusantara datang malam hari, kerak lemaknya dibersihkan tuntas sampai ke bak kontrol tanpa bau mengganggu pelanggan besok paginya.',
            'customer_name' => 'Chef Adrian',
            'customer_role_or_location' => 'Resto F&B Kelapa Gading, Jakarta Utara',
            'initial' => 'A'
        ],
    ]);
@endphp
<section id="pengalaman" class="py-16 lg:py-24 bg-white border-b border-slate-200" x-data="mobileCarousel({{ count($displayStories) }}, 4500)">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Section Header -->
        <div class="text-center max-w-3xl mx-auto mb-10 md:mb-14 reveal-soft">
            <span class="text-xs font-bold uppercase tracking-wider text-sky-700 block mb-2">
                Catatan Lapangan &amp; Pengalaman Pelanggan
            </span>
            <h2 class="text-3xl sm:text-4xl font-extrabold text-slate-900 tracking-tight">
                Pengalaman Nyata Bersama Drainusantara
            </h2>
            <p class="text-slate-600 text-sm sm:text-base mt-2.5 leading-relaxed">
                Cerita dari pemilik rumah dan pelaku usaha saat mengatasi saluran air mampet tanpa repot membongkar keramik.
            </p>
        </div>

        <!-- 3 Cards Grid on Desktop, Horizontal Snap on Mobile -->
        <div x-ref="slider"
             @scroll.passive="onScroll()"
             @touchstart="pause()"
             @touchend="resume()"
             @mouseenter="pause()"
             @mouseleave="resume()"
             class="flex md:grid md:grid-cols-3 overflow-x-auto md:overflow-visible snap-x snap-mandatory no-scrollbar gap-5 lg:gap-6 pb-4 pt-1 px-4 -mx-4 sm:mx-0 sm:px-0 items-stretch">
            @foreach($displayStories as $story)
                <div class="w-[85vw] sm:w-[350px] md:w-auto shrink-0 snap-center bg-slate-50/70 hover:bg-white rounded-xl p-6 sm:p-7 border border-slate-200/90 hover:border-slate-300 transition-all flex flex-col justify-between shadow-2xs card-lift reveal-soft delay-{{ min($loop->iteration * 100, 300) }}">
                    <div>
                        <!-- Card Top Meta: Problem Badge + Outcome Tag -->
                        <div class="flex items-center justify-between gap-2 mb-4">
                            <span class="inline-flex items-center px-2.5 py-1 bg-white border border-slate-200 text-slate-700 text-xs font-semibold rounded-md shadow-2xs">
                                {{ $story->case_badge }}
                            </span>
                            <span class="inline-flex items-center gap-1 text-[11px] font-bold text-emerald-700 bg-emerald-50 px-2 py-0.5 rounded border border-emerald-200">
                                <svg class="w-3.5 h-3.5 text-emerald-600" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                </svg>
                                <span>{{ $story->status }}</span>
                            </span>
                        </div>

                        <!-- Story Quote Body -->
                        <p class="text-slate-700 text-sm leading-relaxed font-normal">
                            &ldquo;{{ $story->comment }}&rdquo;
                        </p>
                    </div>

                    <!-- Customer Profile Signature -->
                    <div class="mt-6 pt-4 border-t border-slate-200/80 flex items-center gap-3">
                        <div class="w-9 h-9 rounded-full bg-white border border-slate-200 text-slate-700 flex items-center justify-center font-bold text-xs shrink-0 shadow-2xs">
                            {{ $story->initial }}
                        </div>
                        <div>
                            <div class="font-bold text-slate-900 text-sm leading-snug">{{ $story->customer_name }}</div>
                            <div class="text-[11px] text-slate-500 font-medium">{{ $story->customer_role_or_location }}</div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Mobile Carousel Dots Indicator (3 Dots) -->
        <div class="flex md:hidden justify-center items-center gap-1.5 mt-4">
            @for($i = 0; $i < count($displayStories); $i++)
                <button type="button" 
                        @click="goTo({{ $i }})"
                        class="h-2 rounded-full transition-all duration-300 cursor-pointer"
                        :class="active === {{ $i }} ? 'w-6 bg-sky-700' : 'w-2 bg-slate-300'"
                        aria-label="Cerita {{ $i + 1 }}">
                </button>
            @endfor
        </div>

    </div>
</section>

<!-- ====================================================================
     9. FAQ (ACCORDION INTERAKTIF BERBASIS ALPINE.JS)
==================================================================== -->
<section class="py-16 lg:py-24 bg-slate-50 border-b border-slate-200">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="text-center mb-14 reveal-soft">
            <span class="text-xs font-bold uppercase tracking-wider text-sky-700 block mb-2">
                Tanya Jawab Teknis
            </span>
            <h2 class="text-3xl sm:text-4xl font-extrabold text-slate-900 tracking-tight">
                Tanya Jawab Seputar Saluran Pipa Mampet
            </h2>
            <p class="text-slate-600 text-sm sm:text-base mt-2">
                Jawaban lengkap mengenai metode pengerjaan tanpa bongkar keramik, estimasi biaya, dan ketentuan garansi resmi 30 hari.
            </p>
        </div>

        <!-- Alpine.js Accordion Component -->
        <div x-data="{ active: null }" class="space-y-3.5 reveal-soft delay-100">
            <!-- FAQ 1 -->
            <div class="bg-white rounded-xl border border-slate-200/90 overflow-hidden shadow-2xs hover:border-sky-300 transition-colors">
                <button 
                    @click="active = (active === 1 ? null : 1)" 
                    class="w-full flex items-center justify-between p-5 text-left font-bold text-slate-900 hover:text-sky-700 transition-colors focus:outline-hidden cursor-pointer"
                    type="button"
                >
                    <span class="text-base sm:text-lg font-bold tracking-tight">Apakah pengerjaan benar-benar 100% tanpa bongkar keramik atau lantai?</span>
                    <svg class="w-5 h-5 shrink-0 transform transition-transform duration-200 text-slate-400" :class="{ 'rotate-180 text-sky-700': active === 1 }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                </button>
                <div x-show="active === 1" x-collapse x-cloak class="px-5 pb-5 text-sm text-slate-600 leading-relaxed border-t border-slate-100 pt-4">
                    Benar, 100% tanpa bongkar ubin keramik! Kami menggunakan mesin drain rooter fleksibel berteknologi spiral baja yang mampu meliuk mengikuti belokan pipa (knee/elbow) hingga ke titik sumbatan. Mesin ini mengikis kerak minyak beku atau menarik benda asing keluar tanpa melukai pipa PVC hunian Anda.
                </div>
            </div>

            <!-- FAQ 2 -->
            <div class="bg-white rounded-xl border border-slate-200/90 overflow-hidden shadow-2xs hover:border-sky-300 transition-colors">
                <button 
                    @click="active = (active === 2 ? null : 2)" 
                    class="w-full flex items-center justify-between p-5 text-left font-bold text-slate-900 hover:text-sky-700 transition-colors focus:outline-hidden cursor-pointer"
                    type="button"
                >
                    <span class="text-base sm:text-lg font-bold tracking-tight">Berapa lama estimasi waktu pengerjaan saluran mampet?</span>
                    <svg class="w-5 h-5 shrink-0 transform transition-transform duration-200 text-slate-400" :class="{ 'rotate-180 text-sky-700': active === 2 }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                </button>
                <div x-show="active === 2" x-collapse x-cloak class="px-5 pb-5 text-sm text-slate-600 leading-relaxed border-t border-slate-100 pt-4">
                    Rata-rata pengerjaan berkisar antara 30 hingga 50 menit per titik saluran. Untuk kasus dengan jalur pipa sangat panjang atau sumbatan berat (seperti endapan semen mengeras), pengerjaan dapat memakan waktu hingga 1,5 jam disertai inspeksi visual kamera CCTV pipa.
                </div>
            </div>

            <!-- FAQ 3 -->
            <div class="bg-white rounded-xl border border-slate-200/90 overflow-hidden shadow-2xs hover:border-sky-300 transition-colors">
                <button 
                    @click="active = (active === 3 ? null : 3)" 
                    class="w-full flex items-center justify-between p-5 text-left font-bold text-slate-900 hover:text-sky-700 transition-colors focus:outline-hidden cursor-pointer"
                    type="button"
                >
                    <span class="text-base sm:text-lg font-bold tracking-tight">Bagaimana syarat dan klaim Garansi 30 Hari Drainusantara?</span>
                    <svg class="w-5 h-5 shrink-0 transform transition-transform duration-200 text-slate-400" :class="{ 'rotate-180 text-sky-700': active === 3 }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                </button>
                <div x-show="active === 3" x-collapse x-cloak class="px-5 pb-5 text-sm text-slate-600 leading-relaxed border-t border-slate-100 pt-4">
                    Setiap pengerjaan kami berikan nota garansi resmi selama 30 hari kalender. Apabila dalam kurun waktu tersebut saluran pada titik yang sama mengalami mampet kembali, teknisi kami siap datang kembali untuk penanganan ulang tanpa dipungut biaya jasa tambahan apapun.
                </div>
            </div>

            <!-- FAQ 4 -->
            <div class="bg-white rounded-xl border border-slate-200/90 overflow-hidden shadow-2xs hover:border-sky-300 transition-colors">
                <button 
                    @click="active = (active === 4 ? null : 4)" 
                    class="w-full flex items-center justify-between p-5 text-left font-bold text-slate-900 hover:text-sky-700 transition-colors focus:outline-hidden cursor-pointer"
                    type="button"
                >
                    <span class="text-base sm:text-lg font-bold tracking-tight">Mengapa tidak disarankan menggunakan soda api?</span>
                    <svg class="w-5 h-5 shrink-0 transform transition-transform duration-200 text-slate-400" :class="{ 'rotate-180 text-sky-700': active === 4 }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                </button>
                <div x-show="active === 4" x-collapse x-cloak class="px-5 pb-5 text-sm text-slate-600 leading-relaxed border-t border-slate-100 pt-4">
                    Soda api bereaksi menghasilkan panas eksotermik di atas 90°C sehingga sangat rentan membengkokkan pipa PVC dan merusak lem sambungan pipa. Selain itu, soda api yang bereaksi dengan minyak makanan akan mengeras menjadi sabun padat seperti batu semen (saponifikasi), yang justru membuat pipa tersumbat total secara permanen.
                </div>
            </div>

            <!-- FAQ 5 -->
            <div class="bg-white rounded-xl border border-slate-200/90 overflow-hidden shadow-2xs hover:border-sky-300 transition-colors">
                <button 
                    @click="active = (active === 5 ? null : 5)" 
                    class="w-full flex items-center justify-between p-5 text-left font-bold text-slate-900 hover:text-sky-700 transition-colors focus:outline-hidden cursor-pointer"
                    type="button"
                >
                    <span class="text-base sm:text-lg font-bold tracking-tight">Bagaimana cara memesan jadwal kedatangan teknisi?</span>
                    <svg class="w-5 h-5 shrink-0 transform transition-transform duration-200 text-slate-400" :class="{ 'rotate-180 text-sky-700': active === 5 }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                </button>
                <div x-show="active === 5" x-collapse x-cloak class="px-5 pb-5 text-sm text-slate-600 leading-relaxed border-t border-slate-100 pt-4">
                    Cukup klik tombol hijau WhatsApp <strong>"Panggil Teknisi via WhatsApp"</strong> di website ini untuk terhubung langsung dengan admin kami. Sampaikan jenis masalah saluran Anda beserta alamat, teknisi terdekat akan segera dijadwalkan meluncur menuju lokasi Anda.
                </div>
            </div>
        </div>

    </div>
</section>

<!-- ====================================================================
     10. FINAL CALL TO ACTION (HOTLINE & KONSULTASI 24 JAM)
==================================================================== -->
<section class="py-16 lg:py-20 bg-gradient-to-br from-slate-900 via-slate-900 to-sky-950 text-white border-t border-slate-800 relative overflow-hidden reveal-soft">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 relative text-center reveal-scale delay-100">
        
        <span class="text-xs font-bold uppercase tracking-wider text-sky-400 block mb-3">
            Hotline Siaga 24 Jam &bull; Sejabodetabek &amp; Kota Lain
        </span>

        <h2 class="text-3xl sm:text-5xl font-extrabold tracking-tight leading-tight">
            Saluran Air Anda Mampet Hari Ini? <br>
            Jangan Tunggu Sampai Meluap!
        </h2>

        <p class="text-slate-300 text-base sm:text-lg mt-4 max-w-2xl mx-auto leading-relaxed">
            Hubungi WhatsApp Drainusantara sekarang. Armada teknisi terdekat siap meluncur dengan mesin spiral rotary dan jaminan garansi resmi 30 hari.
        </p>

        <div class="mt-8 flex flex-col sm:flex-row items-center justify-center gap-4">
            <a href="{{ $generalWaUrl }}" target="_blank" rel="noopener noreferrer" 
               class="w-full sm:w-auto inline-flex items-center justify-center gap-3 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-base px-8 py-4 rounded-xl shadow-md hover:shadow-lg transition-all btn-press">
                <svg class="w-5 h-5 fill-current shrink-0" viewBox="0 0 24 24">
                    <path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/>
                </svg>
                <span>Panggil Teknisi via WhatsApp</span>
            </a>
        </div>

        <p class="text-xs text-slate-400 mt-5 font-medium">
            Respon Cepat 24 Jam &bull; Garansi Nota 30 Hari &bull; 100% Tanpa Bongkar Keramik
        </p>
    </div>
</section>
@endsection
