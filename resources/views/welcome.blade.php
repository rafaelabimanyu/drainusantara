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
            'price_unit' => '/ titik',
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
            'price_unit' => '/ titik',
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
            'price_unit' => '/ titik',
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
            'price_unit' => '/ titik',
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
            'price_unit' => '/ unit',
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
            'price_unit' => '/ sesi',
            'wa_text' => 'Halo Drainusantara, saya ingin menjadwalkan Inspeksi Kamera CCTV Pipa 30M untuk diagnosa saluran yang sering mampet. Mohon info ketersediaan unit.',
        ],
    ];
@endphp

<!-- ====================================================================
     1. HERO SECTION (MODERN FRIENDLY, HYGIENIC & HIGH-TRUST DUAL CTA)
==================================================================== -->
<section class="relative bg-gradient-to-b from-white via-slate-50 to-slate-50 border-b border-slate-200 pt-8 pb-16 lg:pt-14 lg:pb-24 overflow-hidden">
    <!-- Subtle Background Glow Accents -->
    <div class="absolute top-0 right-0 -mr-20 -mt-20 w-96 h-96 bg-sky-100/60 rounded-full blur-3xl pointer-events-none"></div>
    <div class="absolute bottom-0 left-0 -ml-20 -mb-20 w-96 h-96 bg-emerald-100/50 rounded-full blur-3xl pointer-events-none"></div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 lg:gap-12 items-center">
            
            <!-- Hero Left: Warm, Solution-Focused Copy -->
            <div class="lg:col-span-7 space-y-6 text-left fade-up">
                
                <!-- Micro-Trust Badges Header -->
                <div class="flex flex-wrap items-center gap-2">
                    <div class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-white border border-slate-200 rounded-full shadow-xs text-xs font-semibold text-slate-800">
                        <span class="flex text-amber-500">
                            @for($i = 0; $i < 5; $i++)
                                <svg class="w-3.5 h-3.5 fill-current" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                </svg>
                            @endfor
                        </span>
                        <span class="font-bold">Rating 5.0 Google Maps</span>
                    </div>

                    <div class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-emerald-50 border border-emerald-200/80 rounded-full text-emerald-800 text-xs font-bold">
                        <span class="w-2 h-2 bg-emerald-500 rounded-full animate-pulse"></span>
                        <span>Garansi Resmi 30 Hari</span>
                    </div>

                    <div class="hidden sm:inline-flex items-center gap-1.5 px-3 py-1.5 bg-sky-50 border border-sky-200/80 rounded-full text-sky-800 text-xs font-semibold">
                        <span>⚡ Respon &lt; 30 Menit</span>
                    </div>
                </div>

                <!-- Headline Ramah & Lugas Sesuai Instruksi -->
                <h1 class="text-3xl sm:text-5xl lg:text-6xl font-extrabold tracking-tight text-slate-900 leading-[1.14]">
                    Jasa Saluran Mampet & Tukang Pipa Tersumbat <br>
                    <span class="text-sky-700">Beres Cepat, <br class="hidden sm:block">
                    Tanpa Bongkar Keramik.</span>
                </h1>

                <!-- Sub-Headline: Jelas & Reassuring -->
                <p class="text-base sm:text-lg text-slate-600 leading-relaxed max-w-2xl">
                    Layanan pelancaran wastafel, kloset, dan saluran pembuangan bergaransi 30 hari langsung ke lokasi Anda. Dikerjakan rapi dan bersih dengan mesin spiral rotary modern serta inspeksi kamera CCTV pipa 30 meter.
                </p>

                <!-- Value Highlights (3 Poin Ramah Keluarga) -->
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 pt-1 text-xs sm:text-sm">
                    <div class="bg-white p-3.5 rounded-xl border border-slate-200/80 shadow-xs flex items-center gap-2.5">
                        <span class="w-7 h-7 rounded-lg bg-emerald-100 text-emerald-700 font-bold flex items-center justify-center shrink-0">✓</span>
                        <span class="font-semibold text-slate-800">Ubin Keramik Utuh 100%</span>
                    </div>
                    <div class="bg-white p-3.5 rounded-xl border border-slate-200/80 shadow-xs flex items-center gap-2.5">
                        <span class="w-7 h-7 rounded-lg bg-sky-100 text-sky-700 font-bold flex items-center justify-center shrink-0">✓</span>
                        <span class="font-semibold text-slate-800">Kamera CCTV IP68 30M</span>
                    </div>
                    <div class="bg-white p-3.5 rounded-xl border border-slate-200/80 shadow-xs flex items-center gap-2.5">
                        <span class="w-7 h-7 rounded-lg bg-amber-100 text-amber-700 font-bold flex items-center justify-center shrink-0">✓</span>
                        <span class="font-semibold text-slate-800">Garansi Nota 30 Hari</span>
                    </div>
                </div>

                <!-- CTA Ganda (WhatsApp Hijau Mencolok & Konsultasi Biaya) -->
                <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3.5 pt-2">
                    <!-- Tombol Utama: Panggil Teknisi via WhatsApp -->
                    <a href="{{ $generalWaUrl }}" target="_blank" rel="noopener noreferrer" 
                       class="inline-flex items-center justify-center gap-3 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-base px-6 py-3.5 rounded-xl shadow-md hover:shadow-lg active:scale-98 transition-all">
                        <svg class="w-5 h-5 fill-current shrink-0" viewBox="0 0 24 24">
                            <path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/>
                        </svg>
                        <span>Panggil Teknisi via WhatsApp</span>
                    </a>

                    <!-- Tombol Sekunder: Konsultasi Biaya -->
                    <a href="#layanan" 
                       class="inline-flex items-center justify-center gap-2 bg-white hover:bg-slate-100 text-slate-800 font-bold text-base px-6 py-3.5 rounded-xl border border-slate-300 shadow-xs hover:border-slate-400 transition-all">
                        <span>Konsultasi Biaya</span>
                        <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </a>
                </div>

                <!-- Reassuring Note -->
                <div class="text-xs text-slate-500 flex flex-wrap items-center gap-x-4 gap-y-1 pt-1 font-medium">
                    <span class="flex items-center gap-1.5">
                        <span class="w-2 h-2 bg-emerald-500 rounded-full inline-block"></span>
                        Armada Siaga Hari Ini
                    </span>
                    <span>&bull;</span>
                    <span>Bebas Bahan Kimia Merusak</span>
                    <span>&bull;</span>
                    <span>Teknisi Bersepatu & Berseragam Rapi</span>
                </div>
            </div>

            <!-- Hero Right: Kartu Visual Bukti Kerja & Ulasan Google Maps Bersih -->
            <div class="lg:col-span-5 fade-up delay-150">
                <div class="bg-white rounded-2xl p-5 sm:p-6 border border-slate-200/90 shadow-md space-y-4">
                    
                    <!-- Header Card: Google Maps Verified -->
                    <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                        <div class="flex items-center gap-2.5">
                            <div class="w-9 h-9 rounded-xl bg-amber-50 border border-amber-200 flex items-center justify-center text-amber-600 font-bold text-base shadow-2xs">
                                G
                            </div>
                            <div>
                                <span class="font-extrabold text-slate-900 text-sm block">Ulasan Google Maps</span>
                                <span class="text-[11px] text-slate-500 font-medium">480+ Ulasan Terverifikasi Bintang 5</span>
                            </div>
                        </div>
                        <span class="inline-flex items-center gap-1 px-2.5 py-1 bg-emerald-50 text-emerald-700 text-xs font-bold rounded-full border border-emerald-200/80">
                            <span class="w-1.5 h-1.5 bg-emerald-500 rounded-full"></span>
                            Terverifikasi
                        </span>
                    </div>

                    <!-- Clean Visual Photo: Kerja Bersih & Higienis (Modern WebP LCP Optimized) -->
                    <div class="relative rounded-xl overflow-hidden aspect-[16/10] bg-slate-900 border border-slate-200">
                        <picture>
                            <source media="(max-width: 640px)" srcset="{{ asset('images/hero-technician-mobile.webp') }}" type="image/webp">
                            <source srcset="{{ asset('images/hero-technician.webp') }}" type="image/webp">
                            <img 
                                src="{{ asset('images/hero-technician.webp') }}" 
                                alt="Teknisi Drainusantara Pelancaran Saluran Tanpa Bongkar" 
                                width="800" 
                                height="500" 
                                loading="eager"
                                fetchpriority="high"
                                decoding="async"
                                class="w-full h-full object-cover"
                            >
                        </picture>
                        <!-- Translucent Friendly Overlay -->
                        <div class="absolute inset-0 bg-gradient-to-t from-slate-950/80 via-transparent to-black/30 p-4 flex flex-col justify-between pointer-events-none">
                            <div class="flex justify-between items-center">
                                <span class="bg-emerald-600 text-white text-[11px] font-bold px-2.5 py-1 rounded-md shadow-xs">
                                    100% Bebas Bongkar Keramik
                                </span>
                                <span class="bg-slate-900/80 backdrop-blur-xs text-sky-300 text-[10px] font-mono font-bold px-2 py-0.5 rounded-sm">
                                    CCTV PIPA 30M
                                </span>
                            </div>

                            <div class="bg-white/95 backdrop-blur-xs text-slate-900 p-3 rounded-lg shadow-sm border border-slate-200 text-xs">
                                <div class="flex items-center justify-between mb-0.5">
                                    <span class="font-extrabold text-sky-800">HASIL PENGERJAAN:</span>
                                    <span class="text-emerald-600 font-bold">LANCAR PLONG</span>
                                </div>
                                <p class="text-slate-600 text-[11px] leading-relaxed">
                                    Kerak minyak mengeras dikikis bersih dengan spiral baja torsi fleksibel. Lantai tetap utuh & rapi.
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Customer Review Quote Box -->
                    <div class="bg-slate-50 rounded-xl p-4 border border-slate-200/80 space-y-2">
                        <div class="flex items-center gap-1 text-amber-500">
                            @for($i = 0; $i < 5; $i++)
                                <svg class="w-4 h-4 fill-current" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                </svg>
                            @endfor
                            <span class="text-slate-500 text-xs font-semibold ml-1.5">5.0 / 5.0</span>
                        </div>
                        <p class="text-xs text-slate-700 italic leading-relaxed">
                            "Wastafel mampet berhari-hari langsung tuntas 30 menit tanpa bongkar keramik sedikitpun. Teknisi datang cepat, pakai sarung tangan & cover sepatu, area dapur ditinggal dalam kondisi bersih. Puas banget!"
                        </p>
                        <div class="flex items-center justify-between pt-1 text-[11px] text-slate-500 font-medium">
                            <span class="font-bold text-slate-800">Ibu Ratna Dewi &bull; Duren Sawit, Jaktim</span>
                            <span>Ulasan 3 hari lalu</span>
                        </div>
                    </div>

                    <!-- Bottom Guarantee Strip -->
                    <div class="pt-2 flex items-center justify-between text-xs font-semibold text-slate-600">
                        <span class="flex items-center gap-1.5">
                            <span class="text-emerald-600 font-bold">✓</span>
                            <span>Garansi Resmi 30 Hari</span>
                        </span>
                        <span class="flex items-center gap-1.5">
                            <span class="text-emerald-600 font-bold">✓</span>
                            <span>Bayar Setelah Plong</span>
                        </span>
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
        <div class="text-center max-w-3xl mx-auto mb-10 md:mb-14 fade-up">
            <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-sky-50 border border-sky-200 text-sky-800 text-xs font-bold rounded-full uppercase tracking-wider mb-2">
                ALUR MUDAH & TRANSPARAN
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
            <div class="w-[84vw] sm:w-[340px] md:w-auto shrink-0 snap-center bg-slate-50 rounded-2xl p-7 border border-slate-200/80 shadow-xs hover:shadow-md hover:border-sky-300 transition-all flex flex-col justify-between fade-up delay-100">
                <div>
                    <div class="flex items-center justify-between mb-6">
                        <div class="w-12 h-12 rounded-2xl bg-sky-700 text-white font-extrabold text-lg flex items-center justify-center shadow-xs">
                            01
                        </div>
                        <span class="px-2.5 py-1 rounded-full bg-white border border-slate-200 text-slate-600 text-xs font-semibold">
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

                <div class="mt-6 pt-4 border-t border-slate-200/80 flex items-center gap-2 text-xs font-semibold text-sky-700">
                    <span class="w-2 h-2 bg-emerald-500 rounded-full"></span>
                    <span>Respon WhatsApp &lt; 15 Menit</span>
                </div>
            </div>

            <!-- Langkah 02 -->
            <div class="w-[84vw] sm:w-[340px] md:w-auto shrink-0 snap-center bg-slate-50 rounded-2xl p-7 border border-slate-200/80 shadow-xs hover:shadow-md hover:border-sky-300 transition-all flex flex-col justify-between fade-up delay-200">
                <div>
                    <div class="flex items-center justify-between mb-6">
                        <div class="w-12 h-12 rounded-2xl bg-sky-700 text-white font-extrabold text-lg flex items-center justify-center shadow-xs">
                            02
                        </div>
                        <span class="px-2.5 py-1 rounded-full bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs font-bold">
                            Bebas Bongkar
                        </span>
                    </div>

                    <h3 class="text-xl font-bold text-slate-900 mb-3 tracking-tight">
                        Teknisi Tiba & Cek Lokasi (Tanpa Bongkar)
                    </h3>
                    <p class="text-sm text-slate-600 leading-relaxed">
                        Teknisi berseragam rapi tiba di lokasi dalam 30–45 menit dengan mesin spiral rotary dan kamera CCTV pipa. Pengecekan dilakukan aman tanpa merusak atau membongkar keramik lantai.
                    </p>
                </div>

                <div class="mt-6 pt-4 border-t border-slate-200/80 flex items-center gap-2 text-xs font-semibold text-emerald-700">
                    <span class="w-2 h-2 bg-emerald-500 rounded-full"></span>
                    <span>Mesin Spiral Rotary & APD Steril</span>
                </div>
            </div>

            <!-- Langkah 03 -->
            <div class="w-[84vw] sm:w-[340px] md:w-auto shrink-0 snap-center bg-slate-50 rounded-2xl p-7 border border-slate-200/80 shadow-xs hover:shadow-md hover:border-sky-300 transition-all flex flex-col justify-between fade-up delay-300">
                <div>
                    <div class="flex items-center justify-between mb-6">
                        <div class="w-12 h-12 rounded-2xl bg-emerald-600 text-white font-extrabold text-lg flex items-center justify-center shadow-xs">
                            03
                        </div>
                        <span class="px-2.5 py-1 rounded-full bg-amber-50 border border-amber-200 text-amber-800 text-xs font-bold">
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

                <div class="mt-6 pt-4 border-t border-slate-200/80 flex items-center gap-2 text-xs font-semibold text-amber-700">
                    <span class="w-2 h-2 bg-amber-500 rounded-full"></span>
                    <span>Jaminan Garansi Tuntas 30 Hari</span>
                </div>
            </div>

        </div>

        <!-- Mobile Carousel Dots Indicator -->
        <div class="flex md:hidden justify-center items-center gap-1.5 mt-4">
            @for($i = 0; $i < 3; $i++)
                <button type="button" 
                        @click="goTo({{ $i }})"
                        class="h-2 rounded-full transition-all duration-300 cursor-pointer"
                        :class="active === {{ $i }} ? 'w-6 bg-sky-700' : 'w-2 bg-slate-300'"
                        aria-label="Langkah {{ $i + 1 }}">
                </button>
            @endfor
        </div>

    </div>
</section>

<!-- ====================================================================
     3. KATALOG MASALAH BERORIENTASI KEBUTUHAN RUMAH (6 LAYANAN SPESIALIS)
==================================================================== -->
<section id="layanan" class="py-16 lg:py-24 bg-slate-50 border-b border-slate-200" x-data="mobileCarousel({{ count($problemCatalogs) }}, 4000)">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Section Header -->
        <div class="text-center max-w-3xl mx-auto mb-10 md:mb-14 fade-up">
            <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-white border border-slate-200 text-slate-800 text-xs font-bold rounded-full uppercase tracking-wider mb-2 shadow-2xs">
                KATALOG SPESIALIS MASALAH
            </span>
            <h2 class="text-3xl sm:text-4xl font-extrabold text-slate-900 tracking-tight">
                Pilih Solusi Tepat untuk Masalah Saluran Anda
            </h2>
            <p class="text-slate-600 text-sm sm:text-base mt-3 leading-relaxed">
                Biaya transparan tarif mulai dari Rp 400.000 dengan peralatan mekanis spesifik agar pipa bersih tuntas tanpa melukai dinding PVC.
            </p>
            <!-- Mobile Swipe Hint -->
            <div class="flex md:hidden items-center justify-center gap-1.5 text-xs text-sky-700 font-medium mt-3">
                <svg class="w-4 h-4 animate-bounce-x" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                </svg>
                <span>Geser untuk melihat opsi layanan &bull; Auto-scroll aktif</span>
            </div>
        </div>

        <!-- 6 Problem Cards Carousel on Mobile, Grid on Desktop -->
        <div x-ref="slider"
             @scroll.passive="onScroll()"
             @touchstart="pause()"
             @touchend="resume()"
             @mouseenter="pause()"
             @mouseleave="resume()"
             class="flex md:grid md:grid-cols-2 lg:grid-cols-3 overflow-x-auto md:overflow-visible snap-x snap-mandatory no-scrollbar gap-4 lg:gap-8 pb-4 pt-1 px-4 -mx-4 sm:mx-0 sm:px-0">
            @foreach($problemCatalogs as $catalog)
                @php
                    $specificWaUrl = "https://wa.me/{$whatsappNumber}?text=" . urlencode($catalog['wa_text']);
                @endphp
                <div class="w-[84vw] sm:w-[340px] md:w-auto shrink-0 snap-center bg-white rounded-2xl border border-slate-200/90 shadow-sm hover:shadow-md hover:border-sky-300 transition-all duration-200 flex flex-col justify-between group fade-up delay-{{ min($loop->iteration * 50, 300) }}">
                    <div>
                        <!-- Card Header & Badges -->
                        <div class="p-6 pb-4 border-b border-slate-100 bg-slate-50/50 rounded-t-2xl">
                            <div class="flex items-center justify-between text-xs mb-2">
                                <span class="font-bold text-sky-700 bg-sky-50 px-2.5 py-0.5 rounded-full border border-sky-200">
                                    {{ $catalog['category'] }}
                                </span>
                                <span class="text-[11px] font-bold px-2 py-0.5 rounded-full border {{ $catalog['badge_color'] }}">
                                    {{ $catalog['badge'] }}
                                </span>
                            </div>
                            <h3 class="text-xl font-bold tracking-tight text-slate-900 group-hover:text-sky-700 transition-colors">
                                {{ $catalog['title'] }}
                            </h3>
                        </div>

                        <!-- Card Body Content -->
                        <div class="p-6 space-y-4">
                            <!-- Tool & Cable Tag -->
                            <div class="bg-slate-50 p-3 rounded-xl border border-slate-200/80 text-xs space-y-1">
                                <div class="flex items-start gap-1.5">
                                    <span class="text-slate-500 font-semibold shrink-0">Alat Kerja:</span>
                                    <span class="text-slate-900 font-bold">{{ $catalog['tool_tag'] }}</span>
                                </div>
                                <div class="flex items-start gap-1.5">
                                    <span class="text-slate-500 font-semibold shrink-0">Spesifikasi:</span>
                                    <span class="text-slate-700">{{ $catalog['cable_spec'] }}</span>
                                </div>
                            </div>

                            <!-- Problem Diagnosis Copy -->
                            <p class="text-xs sm:text-sm text-slate-600 leading-relaxed">
                                {{ $catalog['problem_desc'] }}
                            </p>

                            <!-- Technical Features List -->
                            <div class="pt-3 border-t border-slate-100">
                                <span class="text-[11px] uppercase text-slate-400 font-bold tracking-wider block mb-2">Keunggulan Tindakan:</span>
                                <ul class="space-y-1.5 text-xs text-slate-700 font-medium">
                                    @foreach($catalog['specs'] as $spec)
                                        <li class="flex items-start gap-2">
                                            <span class="text-emerald-600 font-bold select-none">✓</span>
                                            <span>{{ $spec }}</span>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>

                    <!-- Card Footer: Pricing & Specific WhatsApp Link -->
                    <div class="p-6 pt-0 mt-2 border-t border-slate-100 bg-slate-50/40 rounded-b-2xl">
                        <div class="py-3 flex items-center justify-between">
                            <div>
                                <span class="text-[11px] text-slate-500 block">tarif Transparan:</span>
                                <div class="text-lg font-extrabold text-slate-900 tracking-tight">
                                    Mulai Rp {{ number_format($catalog['price'], 0, ',', '.') }}
                                    <span class="text-xs font-normal text-slate-500">{{ $catalog['price_unit'] ?? '/ titik' }}</span>
                                </div>
                            </div>
                            <span class="text-xs bg-amber-50 text-amber-900 px-2.5 py-1 rounded-full border border-amber-200 font-bold">
                                Garansi 30 Hari
                            </span>
                        </div>

                        <a href="{{ $specificWaUrl }}" target="_blank" rel="noopener noreferrer" 
                           class="w-full flex items-center justify-center gap-2 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs sm:text-sm py-3 px-4 rounded-xl shadow-xs hover:shadow transition-all">
                            <span>Konsultasikan Masalah Ini</span>
                            <span class="text-base">&rarr;</span>
                        </a>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Mobile Carousel Dots Indicator -->
        <div class="flex md:hidden justify-center items-center gap-1.5 mt-4">
            @for($i = 0; $i < count($problemCatalogs); $i++)
                <button type="button" 
                        @click="goTo({{ $i }})"
                        class="h-2 rounded-full transition-all duration-300 cursor-pointer"
                        :class="active === {{ $i }} ? 'w-6 bg-sky-700' : 'w-2 bg-slate-300'"
                        aria-label="Layanan {{ $i + 1 }}">
                </button>
            @endfor
        </div>

    </div>
</section>

<!-- ====================================================================
     4. 4 PILAR KEUNGGULAN REKAYASA TEKNIS (DARK CONTAINER KONTEN HIGIENIS)
==================================================================== -->
<section id="keunggulan" class="py-14 lg:py-20 bg-white border-b border-slate-200" x-data="mobileCarousel(4, 4000)">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Dark Container: Rapi, Terisolasi & Elegan -->
        <div class="bg-slate-900 text-white rounded-3xl p-6 sm:p-12 border border-slate-800 shadow-xl fade-up">
            
            <!-- Section Header -->
            <div class="text-center max-w-3xl mx-auto mb-10 md:mb-14">
                <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-slate-800 border border-slate-700 text-sky-400 text-xs font-bold rounded-full uppercase tracking-wider mb-2">
                    STANDAR KEUNGGULAN TEKNOLOGI
                </span>
                <h2 class="text-3xl sm:text-4xl font-extrabold text-white tracking-tight">
                    Mengapa Memilih Layanan Drainusantara?
                </h2>
                <p class="text-slate-400 text-sm sm:text-base mt-3 leading-relaxed">
                    Kami memadukan mesin drain cleaner torsi fleksibel dengan standar higienis K3 untuk menjaga kebersihan dan melindungi aset properti hunian Anda.
                </p>
                <!-- Mobile Swipe Hint -->
                <div class="flex md:hidden items-center justify-center gap-1.5 text-xs text-sky-400 font-medium mt-3">
                    <svg class="w-4 h-4 animate-bounce-x" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                    </svg>
                    <span>Geser untuk melihat keunggulan &bull; Auto-scroll aktif</span>
                </div>
            </div>

            <!-- 4 Pillars Carousel on Mobile, Grid on Desktop -->
            <div x-ref="slider"
                 @scroll.passive="onScroll()"
                 @touchstart="pause()"
                 @touchend="resume()"
                 @mouseenter="pause()"
                 @mouseleave="resume()"
                 class="flex md:grid md:grid-cols-2 lg:grid-cols-4 overflow-x-auto md:overflow-visible snap-x snap-mandatory no-scrollbar gap-4 lg:gap-6 pb-4 pt-1 px-1 -mx-1 sm:mx-0 sm:px-0">
                <!-- Pilar 01 -->
                <div class="w-[82vw] sm:w-[320px] md:w-auto shrink-0 snap-center p-6 rounded-2xl bg-slate-800/80 border border-slate-700/80 shadow-sm hover:border-sky-500 transition-all flex flex-col justify-between">
                    <div>
                        <div class="flex items-center justify-between mb-5">
                            <span class="text-3xl font-extrabold text-sky-400 font-mono">01</span>
                            <div class="w-10 h-10 rounded-xl bg-slate-900 border border-slate-700 text-sky-400 flex items-center justify-center shadow-xs">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                                </svg>
                            </div>
                        </div>
                        <h3 class="text-lg font-bold text-white mb-2 tracking-tight">Tanpa Bongkar Keramik</h3>
                        <p class="text-sm text-slate-300 leading-relaxed">
                            Kabel spiral baja fleksibel berputar meliuk mengikuti belokan pipa knee tanpa membongkar lantai ubin, dinding keramik, atau dak beton hunian Anda.
                        </p>
                    </div>
                    <div class="mt-5 pt-4 border-t border-slate-700 text-xs font-semibold text-slate-400">
                        Hemat Biaya Renovasi Lantai
                    </div>
                </div>

                <!-- Pilar 02 -->
                <div class="w-[82vw] sm:w-[320px] md:w-auto shrink-0 snap-center p-6 rounded-2xl bg-slate-800/80 border border-slate-700/80 shadow-sm hover:border-sky-500 transition-all flex flex-col justify-between">
                    <div>
                        <div class="flex items-center justify-between mb-5">
                            <span class="text-3xl font-extrabold text-sky-400 font-mono">02</span>
                            <div class="w-10 h-10 rounded-xl bg-slate-900 border border-slate-700 text-sky-400 flex items-center justify-center shadow-xs">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                                </svg>
                            </div>
                        </div>
                        <h3 class="text-lg font-bold text-white mb-2 tracking-tight">Inspeksi Kamera CCTV 30M</h3>
                        <p class="text-sm text-slate-300 leading-relaxed">
                            Kamera endoskopi kedap air IP68 menjangkau hingga 30 meter. Mendiagnosis posisi sumbatan, titik keretakan, atau akar pohon secara visual dan akurat.
                        </p>
                    </div>
                    <div class="mt-5 pt-4 border-t border-slate-700 text-xs font-semibold text-slate-400">
                        Diagnosa Visual Bergaransi Rekaman
                    </div>
                </div>

                <!-- Pilar 03 -->
                <div class="w-[82vw] sm:w-[320px] md:w-auto shrink-0 snap-center p-6 rounded-2xl bg-slate-800/80 border border-slate-700/80 shadow-sm hover:border-emerald-500 transition-all flex flex-col justify-between">
                    <div>
                        <div class="flex items-center justify-between mb-5">
                            <span class="text-3xl font-extrabold text-emerald-400 font-mono">03</span>
                            <div class="w-10 h-10 rounded-xl bg-slate-900 border border-slate-700 text-emerald-400 flex items-center justify-center shadow-xs">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/>
                                </svg>
                            </div>
                        </div>
                        <h3 class="text-lg font-bold text-white mb-2 tracking-tight">Garansi Resmi 30 Hari</h3>
                        <p class="text-sm text-slate-300 leading-relaxed">
                            Jaminan nota fisik pengerjaan tuntas 100%. Apabila saluran pada titik yang sama mengalami kendala dalam 30 hari, teknisi tangani ulang tanpa biaya jasa.
                        </p>
                    </div>
                    <div class="mt-5 pt-4 border-t border-slate-700 text-xs font-semibold text-slate-400">
                        Jaminan Kepuasan & Nota Resmi
                    </div>
                </div>

                <!-- Pilar 04 -->
                <div class="w-[82vw] sm:w-[320px] md:w-auto shrink-0 snap-center p-6 rounded-2xl bg-slate-800/80 border border-slate-700/80 shadow-sm hover:border-sky-500 transition-all flex flex-col justify-between">
                    <div>
                        <div class="flex items-center justify-between mb-5">
                            <span class="text-3xl font-extrabold text-sky-400 font-mono">04</span>
                            <div class="w-10 h-10 rounded-xl bg-slate-900 border border-slate-700 text-sky-400 flex items-center justify-center shadow-xs">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                </svg>
                            </div>
                        </div>
                        <h3 class="text-lg font-bold text-white mb-2 tracking-tight">Kerja Higienis & APD Steril</h3>
                        <p class="text-sm text-slate-300 leading-relaxed">
                            Teknisi berseragam rapi, memakai sarung tangan khusus, cover pelindung sepatu, dan membersihkan kembali area pengerjaan hingga steril bebas bau.
                        </p>
                    </div>
                    <div class="mt-5 pt-4 border-t border-slate-700 text-xs font-semibold text-slate-400">
                        Area Dapur & Toilet Tetap Bersih
                    </div>
                </div>
            </div>

            <!-- Mobile Carousel Dots Indicator -->
            <div class="flex md:hidden justify-center items-center gap-1.5 mt-4">
                @for($i = 0; $i < 4; $i++)
                    <button type="button" 
                            @click="goTo({{ $i }})"
                            class="h-2 rounded-full transition-all duration-300 cursor-pointer"
                            :class="active === {{ $i }} ? 'w-6 bg-sky-400' : 'w-2 bg-slate-700'"
                            aria-label="Keunggulan {{ $i + 1 }}">
                    </button>
                @endfor
            </div>

        </div>

    </div>
</section>

<!-- ====================================================================
     5. KOMPARASI FOTO BEFORE & AFTER (BUKTI HASIL KERJA NYATA)
==================================================================== -->
<section id="galeri-before-after" class="py-16 lg:py-24 bg-slate-50 border-b border-slate-200" x-data="mobileCarousel(3, 4500)">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Section Header -->
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-6 mb-10 md:mb-12 fade-up">
            <div>
                <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-white border border-slate-200 text-slate-800 text-xs font-bold rounded-full uppercase tracking-wider mb-2 shadow-2xs">
                    DOKUMENTASI HASIL KERJA NYATA
                </span>
                <h2 class="text-3xl sm:text-4xl font-extrabold text-slate-900 tracking-tight">
                    Komparasi Sebelum & Sesudah Pengerjaan
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
                <a href="{{ url('/galeri') }}" class="inline-flex items-center gap-2 text-sm font-bold text-sky-700 hover:text-sky-800 bg-white hover:bg-sky-50 border border-slate-200 px-5 py-3 rounded-xl shadow-xs transition-colors">
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
            <div class="w-[85vw] sm:w-[350px] lg:w-auto shrink-0 snap-center bg-white rounded-2xl border border-slate-200/90 overflow-hidden shadow-sm hover:shadow-md transition-all fade-up delay-100 flex flex-col justify-between">
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
            <div class="w-[85vw] sm:w-[350px] lg:w-auto shrink-0 snap-center bg-white rounded-2xl border border-slate-200/90 overflow-hidden shadow-sm hover:shadow-md transition-all fade-up delay-150 flex flex-col justify-between">
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
            <div class="w-[85vw] sm:w-[350px] lg:w-auto shrink-0 snap-center bg-white rounded-2xl border border-slate-200/90 overflow-hidden shadow-sm hover:shadow-md transition-all fade-up delay-200 flex flex-col justify-between">
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
     6. EDUKASI SANITASI: BAHAYA SODA API VS PEMBERSIHAN MEKANIS
==================================================================== -->
<section id="edukasi" class="py-16 lg:py-24 bg-white border-b border-slate-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Section Header -->
        <div class="text-center max-w-3xl mx-auto mb-14 fade-up">
            <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-amber-50 border border-amber-200 text-amber-800 text-xs font-bold rounded-full uppercase tracking-wider mb-2">
                EDUKASI PERLINDUNGAN PIPA
            </span>
            <h2 class="text-3xl sm:text-4xl font-extrabold text-slate-900 tracking-tight">
                Mengapa Jangan Menuang Soda Api ke Saluran Mampet?
            </h2>
            <p class="text-slate-600 text-sm sm:text-base mt-3 leading-relaxed">
                Soda api (NaOH) dan bahan kimia keras seringkali mengakibatkan kerusakan permanen pada instalasi pipa PVC di bawah cor hunian Anda.
            </p>
        </div>

        <!-- 2 Side-by-Side Cards: Danger vs Modern Solution -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 items-stretch">
            
            <!-- Kartu Bahaya Bahan Kimia / Soda Api -->
            <div class="rounded-2xl bg-red-50/60 border border-red-200 p-7 sm:p-8 flex flex-col justify-between fade-up delay-100 shadow-xs">
                <div>
                    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-red-700 text-white text-xs font-bold mb-5 shadow-2xs">
                        <span>BAHAYA SODA API & CHEMICAL KERAS</span>
                    </div>

                    <h3 class="text-xl font-bold text-slate-900 mb-5 tracking-tight">
                        Risiko Nyata Pemakaian Bahan Kimia Korosif
                    </h3>

                    <ul class="space-y-4 text-sm text-slate-700">
                        <li class="flex items-start gap-3">
                            <span class="text-red-700 font-extrabold text-base select-none shrink-0">✕</span>
                            <div>
                                <strong class="text-slate-900 block font-bold">Pipa PVC Melengkung & Sambungan Lepas</strong>
                                Reaksi kimia menghasilkan panas ekstrem di atas 90°C yang melunakkan paralon PVC dan melelehkan lem sambungan hingga bocor ke plafon lantai bawah.
                            </div>
                        </li>
                        <li class="flex items-start gap-3">
                            <span class="text-red-700 font-extrabold text-base select-none shrink-0">✕</span>
                            <div>
                                <strong class="text-slate-900 block font-bold">Minyak Mengeras Menjadi Sabun (Membatu)</strong>
                                Reaksi saponifikasi antara soda api dan lemak masakan menghasilkan gumpalan padat seperti batu semen yang menyumbat pipa secara permanen.
                            </div>
                        </li>
                        <li class="flex items-start gap-3">
                            <span class="text-red-700 font-extrabold text-base select-none shrink-0">✕</span>
                            <div>
                                <strong class="text-slate-900 block font-bold">Uap Beracun & Risiko Semburan Panas</strong>
                                Menghasilkan gas beracun menusuk yang membahayakan pernapasan serta risiko semburan asam/basa panas yang dapat melukai kulit dan mata.
                            </div>
                        </li>
                    </ul>
                </div>

                <div class="mt-8 p-4 rounded-xl bg-white border border-red-200 text-xs text-red-900 leading-relaxed font-medium">
                    <strong>Peringatan Biaya:</strong> Mengganti pipa PVC yang pecah di bawah cor beton lantai memerlukan pembongkaran ubin dengan biaya mencapai jutaan rupiah.
                </div>
            </div>

            <!-- Kartu Solusi Mekanis Modern Drainusantara -->
            <div class="rounded-2xl bg-white border-2 border-emerald-500/90 shadow-md p-7 sm:p-8 flex flex-col justify-between fade-up delay-200">
                <div>
                    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-emerald-700 text-white text-xs font-bold mb-5 shadow-2xs">
                        <span>SOLUSI MODERN DRAINUSANTARA</span>
                    </div>

                    <h3 class="text-xl font-bold text-slate-900 mb-5 tracking-tight">
                        Pembersihan Mekanis Spiral & Kamera CCTV Pipa
                    </h3>

                    <ul class="space-y-4 text-sm text-slate-700">
                        <li class="flex items-start gap-3">
                            <span class="text-emerald-600 font-extrabold text-base select-none shrink-0">✓</span>
                            <div>
                                <strong class="text-slate-900 block font-bold">Spiral Baja Lentur Mengikis Lemak</strong>
                                Mesin drain cleaner memutar kabel spiral pegas dengan torsi terukur untuk merontokkan kerak lemak dan menarik sumbatan tanpa merusak dinding pipa PVC.
                            </div>
                        </li>
                        <li class="flex items-start gap-3">
                            <span class="text-emerald-600 font-extrabold text-base select-none shrink-0">✓</span>
                            <div>
                                <strong class="text-slate-900 block font-bold">Inspeksi Visual Kamera CCTV 30M</strong>
                                Mendiagnosa kondisi jalur pipa di monitor HD: melihat koordinat letak sumbatan, retakan, atau akar sebelum dan sesudah pengerjaan.
                            </div>
                        </li>
                        <li class="flex items-start gap-3">
                            <span class="text-emerald-600 font-extrabold text-base select-none shrink-0">✓</span>
                            <div>
                                <strong class="text-slate-900 block font-bold">100% Ramah Lingkungan & Garansi Resmi</strong>
                                Tanpa bahan kimia beracun, aman bagi pipa hunian Anda, serta dilindungi garansi resmi nota tertulis selama 30 hari kalender.
                            </div>
                        </li>
                    </ul>
                </div>

                <div class="mt-8 pt-6 border-t border-slate-100 flex flex-col sm:flex-row items-center justify-between gap-4">
                    <div>
                        <span class="text-xs text-slate-500 block">Konsultasi Bebas Kimia:</span>
                        <span class="text-sm font-bold text-slate-900">Konsultasi teknis & estimasi gratis</span>
                    </div>
                    <a href="{{ $generalWaUrl }}" target="_blank" rel="noopener noreferrer" 
                       class="inline-flex items-center gap-2 bg-emerald-600 hover:bg-emerald-700 text-white text-xs sm:text-sm font-bold px-5 py-3 rounded-xl shadow-xs transition-colors">
                        <span>Panggil Teknisi Tanpa Soda Api</span>
                    </a>
                </div>
            </div>

        </div>

    </div>
</section>

<!-- ====================================================================
     7. WILAYAH JANGKAUAN TEKNIS (TECHNICAL AREA BOARD)
==================================================================== -->
<section id="area" class="bg-slate-50 border-b border-slate-200 py-16 fade-up">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Section Header -->
        <div class="flex flex-col lg:flex-row items-start lg:items-center justify-between gap-6 mb-10">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-2xl bg-sky-700 text-white flex items-center justify-center shrink-0 shadow-xs">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                </div>
                <div>
                    <h2 class="text-2xl sm:text-3xl font-extrabold tracking-tight text-slate-900">Wilayah Jangkauan Armada Drainusantara</h2>
                    <p class="text-xs sm:text-sm text-slate-600 mt-1">Posko teknisi siaga di seluruh Jabodetabek, Semarang, dan Lampung dengan estimasi tiba 30–45 menit.</p>
                </div>
            </div>

            <div class="inline-flex items-center gap-2 px-3.5 py-1.5 bg-white border border-slate-200 rounded-full text-xs font-bold text-slate-800 shadow-2xs">
                <span class="w-2 h-2 bg-emerald-500 rounded-full inline-block"></span>
                <span>Armada Siaga 24 Jam</span>
            </div>
        </div>

        <div class="space-y-5">
            <!-- Group 1: PROVINSI DKI JAKARTA -->
            <div class="bg-white rounded-2xl p-6 border border-slate-200/90 shadow-sm">
                <div class="flex flex-wrap items-center justify-between gap-2 mb-4">
                    <div class="flex items-center gap-2.5">
                        <span class="text-xs uppercase font-bold text-sky-800 bg-sky-50 px-3 py-1 rounded-full border border-sky-200">DKI JAKARTA</span>
                        <span class="text-xs text-slate-600 font-medium">5 Kota Administrasi Siaga 24 Jam:</span>
                    </div>
                    <a href="{{ route('area.province', ['province' => 'dki-jakarta']) }}" class="text-xs font-bold text-sky-700 hover:text-sky-800 hover:underline">
                        Buka Halaman Provinsi DKI Jakarta &rarr;
                    </a>
                </div>
                <div class="flex flex-wrap gap-2.5 text-xs sm:text-sm">
                    <a href="{{ route('area.city', ['city' => 'jakarta-timur']) }}" class="px-3.5 py-2 rounded-xl bg-slate-50 hover:bg-white text-slate-800 hover:text-sky-700 font-semibold border border-slate-200 hover:border-sky-300 hover:shadow-2xs transition-all flex items-center gap-2">
                        <span class="w-1.5 h-1.5 bg-emerald-500 rounded-full"></span>
                        <span>Jakarta Timur <span class="text-slate-400 font-normal text-xs">(Ciracas, Duren Sawit, Cakung)</span></span>
                    </a>
                    <a href="{{ route('area.city', ['city' => 'jakarta-selatan']) }}" class="px-3.5 py-2 rounded-xl bg-slate-50 hover:bg-white text-slate-800 hover:text-sky-700 font-semibold border border-slate-200 hover:border-sky-300 hover:shadow-2xs transition-all flex items-center gap-2">
                        <span class="w-1.5 h-1.5 bg-emerald-500 rounded-full"></span>
                        <span>Jakarta Selatan <span class="text-slate-400 font-normal text-xs">(Tebet, Cilandak, Kemang)</span></span>
                    </a>
                    <a href="{{ route('area.city', ['city' => 'jakarta-barat']) }}" class="px-3.5 py-2 rounded-xl bg-slate-50 hover:bg-white text-slate-800 hover:text-sky-700 font-semibold border border-slate-200 hover:border-sky-300 hover:shadow-2xs transition-all flex items-center gap-2">
                        <span class="w-1.5 h-1.5 bg-emerald-500 rounded-full"></span>
                        <span>Jakarta Barat <span class="text-slate-400 font-normal text-xs">(Kebon Jeruk, Puri, Grogol)</span></span>
                    </a>
                    <a href="{{ route('area.city', ['city' => 'jakarta-utara']) }}" class="px-3.5 py-2 rounded-xl bg-slate-50 hover:bg-white text-slate-800 hover:text-sky-700 font-semibold border border-slate-200 hover:border-sky-300 hover:shadow-2xs transition-all flex items-center gap-2">
                        <span class="w-1.5 h-1.5 bg-emerald-500 rounded-full"></span>
                        <span>Jakarta Utara <span class="text-slate-400 font-normal text-xs">(Kelapa Gading, PIK, Sunter)</span></span>
                    </a>
                    <a href="{{ route('area.city', ['city' => 'jakarta-pusat']) }}" class="px-3.5 py-2 rounded-xl bg-slate-50 hover:bg-white text-slate-800 hover:text-sky-700 font-semibold border border-slate-200 hover:border-sky-300 hover:shadow-2xs transition-all flex items-center gap-2">
                        <span class="w-1.5 h-1.5 bg-emerald-500 rounded-full"></span>
                        <span>Jakarta Pusat <span class="text-slate-400 font-normal text-xs">(Kemayoran, Cempaka Putih, Menteng)</span></span>
                    </a>
                </div>
            </div>

            <!-- Group 2: PROVINSI JAWA BARAT & BANTEN -->
            <div class="bg-white rounded-2xl p-6 border border-slate-200/90 shadow-sm">
                <div class="flex flex-wrap items-center justify-between gap-2 mb-4">
                    <div class="flex items-center gap-2.5">
                        <span class="text-xs uppercase font-bold text-sky-800 bg-sky-50 px-3 py-1 rounded-full border border-sky-200">JAWA BARAT & BANTEN</span>
                        <span class="text-xs text-slate-600 font-medium">Bodetabek & Kota Bandung:</span>
                    </div>
                    <div class="flex items-center gap-3 text-xs font-bold">
                        <a href="{{ route('area.province', ['province' => 'jawa-barat']) }}" class="text-sky-700 hover:text-sky-800 hover:underline">
                            Provinsi Jawa Barat &rarr;
                        </a>
                        <span class="text-slate-300">|</span>
                        <a href="{{ route('area.province', ['province' => 'banten']) }}" class="text-sky-700 hover:text-sky-800 hover:underline">
                            Provinsi Banten &rarr;
                        </a>
                    </div>
                </div>
                <div class="flex flex-wrap gap-2.5 text-xs sm:text-sm">
                    <a href="{{ route('area.city', ['city' => 'bogor']) }}" class="px-3.5 py-2 rounded-xl bg-slate-50 hover:bg-white text-slate-800 hover:text-sky-700 font-semibold border border-slate-200 hover:border-sky-300 hover:shadow-2xs transition-all flex items-center gap-2">
                        <span class="w-1.5 h-1.5 bg-emerald-500 rounded-full"></span>
                        <span>Bogor & Sentul <span class="text-slate-400 font-normal text-xs">(Cibinong, Sentul, Kota Bogor)</span></span>
                    </a>
                    <a href="{{ route('area.city', ['city' => 'depok-cinere']) }}" class="px-3.5 py-2 rounded-xl bg-slate-50 hover:bg-white text-slate-800 hover:text-sky-700 font-semibold border border-slate-200 hover:border-sky-300 hover:shadow-2xs transition-all flex items-center gap-2">
                        <span class="w-1.5 h-1.5 bg-emerald-500 rounded-full"></span>
                        <span>Depok & Cinere <span class="text-slate-400 font-normal text-xs">(Margonda, Sawangan, Cinere)</span></span>
                    </a>
                    <a href="{{ route('area.city', ['city' => 'bekasi-cikarang']) }}" class="px-3.5 py-2 rounded-xl bg-slate-50 hover:bg-white text-slate-800 hover:text-sky-700 font-semibold border border-slate-200 hover:border-sky-300 hover:shadow-2xs transition-all flex items-center gap-2">
                        <span class="w-1.5 h-1.5 bg-emerald-500 rounded-full"></span>
                        <span>Bekasi & Cikarang <span class="text-slate-400 font-normal text-xs">(Bekasi Barat, Cikarang Selatan)</span></span>
                    </a>
                    <a href="{{ route('area.city', ['city' => 'bandung']) }}" class="px-3.5 py-2 rounded-xl bg-slate-50 hover:bg-white text-slate-800 hover:text-sky-700 font-semibold border border-slate-200 hover:border-sky-300 hover:shadow-2xs transition-all flex items-center gap-2">
                        <span class="w-1.5 h-1.5 bg-emerald-500 rounded-full"></span>
                        <span>Kota Bandung <span class="text-slate-400 font-normal text-xs">(Buahbatu, Antapani, Coblong)</span></span>
                    </a>
                    <a href="{{ route('area.city', ['city' => 'tangerang-kota']) }}" class="px-3.5 py-2 rounded-xl bg-slate-50 hover:bg-white text-slate-800 hover:text-sky-700 font-semibold border border-slate-200 hover:border-sky-300 hover:shadow-2xs transition-all flex items-center gap-2">
                        <span class="w-1.5 h-1.5 bg-emerald-500 rounded-full"></span>
                        <span>Tangerang Kota <span class="text-slate-400 font-normal text-xs">(Cipondoh, Karawaci, Ciledug)</span></span>
                    </a>
                    <a href="{{ route('area.city', ['city' => 'tangerang-selatan']) }}" class="px-3.5 py-2 rounded-xl bg-slate-50 hover:bg-white text-slate-800 hover:text-sky-700 font-semibold border border-slate-200 hover:border-sky-300 hover:shadow-2xs transition-all flex items-center gap-2">
                        <span class="w-1.5 h-1.5 bg-emerald-500 rounded-full"></span>
                        <span>Tangerang Selatan <span class="text-slate-400 font-normal text-xs">(BSD City, Bintaro, Serpong)</span></span>
                    </a>
                </div>
            </div>

            <!-- Group 3: JAWA TENGAH & LAMPUNG -->
            <div class="bg-white rounded-2xl p-6 border border-slate-200/90 shadow-sm">
                <div class="flex flex-wrap items-center justify-between gap-2 mb-4">
                    <div class="flex items-center gap-2.5">
                        <span class="text-xs uppercase font-bold text-sky-800 bg-sky-50 px-3 py-1 rounded-full border border-sky-200">HUB KOTA LAIN</span>
                        <span class="text-xs text-slate-600 font-medium">Jawa Tengah & Sumatera:</span>
                    </div>
                    <div class="flex items-center gap-3 text-xs font-bold">
                        <a href="{{ route('area.province', ['province' => 'jawa-tengah']) }}" class="text-sky-700 hover:text-sky-800 hover:underline">
                            Provinsi Jawa Tengah &rarr;
                        </a>
                        <span class="text-slate-300">|</span>
                        <a href="{{ route('area.province', ['province' => 'lampung']) }}" class="text-sky-700 hover:text-sky-800 hover:underline">
                            Provinsi Lampung &rarr;
                        </a>
                    </div>
                </div>
                <div class="flex flex-wrap gap-2.5 text-xs sm:text-sm">
                    <a href="{{ route('area.city', ['city' => 'semarang']) }}" class="px-3.5 py-2 rounded-xl bg-slate-50 hover:bg-white text-slate-800 hover:text-sky-700 font-semibold border border-slate-200 hover:border-sky-300 hover:shadow-2xs transition-all flex items-center gap-2">
                        <span class="w-1.5 h-1.5 bg-emerald-500 rounded-full"></span>
                        <span>Kota Semarang <span class="text-slate-400 font-normal text-xs">(Candisari, Banyumanik, Simpang Lima)</span></span>
                    </a>
                    <a href="{{ route('area.city', ['city' => 'bandar-lampung']) }}" class="px-3.5 py-2 rounded-xl bg-slate-50 hover:bg-white text-slate-800 hover:text-sky-700 font-semibold border border-slate-200 hover:border-sky-300 hover:shadow-2xs transition-all flex items-center gap-2">
                        <span class="w-1.5 h-1.5 bg-emerald-500 rounded-full"></span>
                        <span>Bandar Lampung <span class="text-slate-400 font-normal text-xs">(Kedaton, Tanjung Karang, Way Halim)</span></span>
                    </a>
                </div>
            </div>

            <!-- Full Directory Banner Link -->
            <div class="bg-sky-50/80 border border-sky-200/80 rounded-2xl p-5 flex flex-col sm:flex-row items-center justify-between gap-4">
                <div class="flex items-center gap-3 text-xs sm:text-sm text-slate-700">
                    <svg class="w-5 h-5 text-sky-700 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                    </svg>
                    <span>Cari kecamatan atau kota spesifik lainnya? Buka peta direktori lengkap seluruh provinsi kami.</span>
                </div>
                <a href="{{ route('area.index') }}" class="shrink-0 inline-flex items-center gap-2 px-5 py-2.5 bg-sky-700 hover:bg-sky-800 text-white text-xs font-bold rounded-xl transition-colors shadow-xs">
                    <span>Lihat Direktori Seluruh Area</span>
                    <span>&rarr;</span>
                </a>
            </div>

        </div>

    </div>
</section>

<!-- ====================================================================
     8. ULASAN PELANGGAN (TESTIMONI DATABASE DENGAN FALLBACK BINTANG 5)
==================================================================== -->
@php
    $displayReviews = (isset($reviews) && $reviews->isNotEmpty()) ? $reviews : collect([
        (object)[
            'rating' => 5,
            'comment' => 'Wastafel mampet berhari-hari langsung tuntas 30 menit tanpa bongkar keramik sedikitpun. Teknisi datang cepat, pakai sarung tangan & cover sepatu, area dapur ditinggal dalam kondisi bersih. Puas banget!',
            'customer_name' => 'Ibu Ratna Dewi',
            'customer_role_or_location' => 'Duren Sawit, Jakarta Timur'
        ],
        (object)[
            'rating' => 5,
            'comment' => 'Kloset duduk lantai 2 meluap tersumbat tisu basah. Teknisi Drainusantara menggunakan spiral lentur khusus, 35 menit beres tanpa lepas kloset atau merusak porselen. Sangat profesional.',
            'customer_name' => 'Bpk. Hendra Wijaya',
            'customer_role_or_location' => 'BSD City, Tangerang Selatan'
        ],
        (object)[
            'rating' => 5,
            'comment' => 'Grease trap dan saluran pembuangan resto kami tersumbat lemak beku. Dikerjakan malam hari dengan kamera CCTV pipa 30M, terlihat jelas lemak bersih tuntas. Diberikan nota garansi 30 hari.',
            'customer_name' => 'Chef Adrian',
            'customer_role_or_location' => 'Resto F&B Kelapa Gading, Jakarta Utara'
        ],
        (object)[
            'rating' => 5,
            'comment' => 'Pipa talang rooftop tersumbat pasir dak dan lumut saat hujan deras sampai rembes ke plafon. Mesin spiral jangkauan panjang langsung melancarkan dalam waktu 45 menit. Rekomended!',
            'customer_name' => 'Bpk. Suryadi Pratama',
            'customer_role_or_location' => 'Tebet, Jakarta Selatan'
        ],
    ]);
@endphp
<section class="py-16 lg:py-24 bg-white border-b border-slate-200" x-data="mobileCarousel({{ count($displayReviews) }}, 4500)">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Section Header -->
        <div class="text-center max-w-3xl mx-auto mb-10 md:mb-14 fade-up">
            <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-amber-50 border border-amber-200 text-amber-800 text-xs font-bold rounded-full uppercase tracking-wider mb-2">
                TESTIMONI PELANGGAN TERVERIFIKASI
            </span>
            <h2 class="text-3xl sm:text-4xl font-extrabold text-slate-900 tracking-tight">
                Pengalaman Nyata Bersama Drainusantara
            </h2>
            <p class="text-slate-600 text-sm sm:text-base mt-3">
                Kepercayaan dari ratusan pemilik rumah, kafe, restoran, dan pengelola gedung komersial.
            </p>
            <!-- Mobile Swipe Hint -->
            <div class="flex md:hidden items-center justify-center gap-1.5 text-xs text-sky-700 font-medium mt-3">
                <svg class="w-4 h-4 animate-bounce-x" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                </svg>
                <span>Geser untuk membaca ulasan &bull; Auto-scroll aktif</span>
            </div>
        </div>

        <!-- Reviews Carousel on Mobile, Grid on Desktop -->
        <div x-ref="slider"
             @scroll.passive="onScroll()"
             @touchstart="pause()"
             @touchend="resume()"
             @mouseenter="pause()"
             @mouseleave="resume()"
             class="flex md:grid md:grid-cols-2 lg:grid-cols-4 overflow-x-auto md:overflow-visible snap-x snap-mandatory no-scrollbar gap-4 lg:gap-6 pb-4 pt-1 px-4 -mx-4 sm:mx-0 sm:px-0">
            @foreach($displayReviews as $review)
                <div class="w-[82vw] sm:w-[320px] md:w-auto shrink-0 snap-center bg-slate-50 rounded-2xl p-6 border border-slate-200/80 flex flex-col justify-between hover:shadow-md hover:border-slate-300 transition-all fade-up delay-{{ min($loop->iteration * 100, 300) }}">
                    <div>
                        <!-- Rating Stars -->
                        <div class="flex items-center gap-1 text-amber-500 mb-3">
                            @for($i = 1; $i <= 5; $i++)
                                <svg class="w-4 h-4 {{ $i <= $review->rating ? 'fill-current' : 'text-slate-300' }}" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                </svg>
                            @endfor
                        </div>
                        <p class="text-slate-700 text-sm leading-relaxed">
                            "{{ $review->comment }}"
                        </p>
                    </div>

                    <div class="mt-6 pt-4 border-t border-slate-200/80 flex items-center gap-3">
                        <div class="w-9 h-9 rounded-xl bg-sky-700 text-white flex items-center justify-center font-bold text-xs shrink-0 shadow-2xs">
                            {{ substr($review->customer_name, 0, 1) }}
                        </div>
                        <div>
                            <div class="font-bold text-slate-900 text-sm">{{ $review->customer_name }}</div>
                            <div class="text-[11px] text-slate-500 font-medium">{{ $review->customer_role_or_location }}</div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Mobile Carousel Dots Indicator -->
        <div class="flex md:hidden justify-center items-center gap-1.5 mt-4">
            @for($i = 0; $i < count($displayReviews); $i++)
                <button type="button" 
                        @click="goTo({{ $i }})"
                        class="h-2 rounded-full transition-all duration-300 cursor-pointer"
                        :class="active === {{ $i }} ? 'w-6 bg-sky-700' : 'w-2 bg-slate-300'"
                        aria-label="Ulasan {{ $i + 1 }}">
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
        
        <div class="text-center mb-14 fade-up">
            <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-white border border-slate-200 text-slate-800 text-xs font-bold rounded-full uppercase tracking-wider mb-2 shadow-2xs">
                PERTANYAAN UMUM
            </span>
            <h2 class="text-3xl sm:text-4xl font-extrabold text-slate-900 tracking-tight">
                Frequently Asked Questions (FAQ)
            </h2>
            <p class="text-slate-600 text-sm sm:text-base mt-2">
                Informasi seputar cara kerja, waktu kedatangan teknisi, dan ketentuan garansi Drainusantara.
            </p>
        </div>

        <!-- Alpine.js Accordion Component -->
        <div x-data="{ active: null }" class="space-y-3.5 fade-up delay-100">
            <!-- FAQ 1 -->
            <div class="bg-white rounded-2xl border border-slate-200/90 overflow-hidden shadow-2xs transition-all">
                <button 
                    @click="active = (active === 1 ? null : 1)" 
                    class="w-full flex items-center justify-between p-5 text-left font-bold text-slate-900 hover:text-sky-700 transition-colors focus:outline-hidden"
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
            <div class="bg-white rounded-2xl border border-slate-200/90 overflow-hidden shadow-2xs transition-all">
                <button 
                    @click="active = (active === 2 ? null : 2)" 
                    class="w-full flex items-center justify-between p-5 text-left font-bold text-slate-900 hover:text-sky-700 transition-colors focus:outline-hidden"
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
            <div class="bg-white rounded-2xl border border-slate-200/90 overflow-hidden shadow-2xs transition-all">
                <button 
                    @click="active = (active === 3 ? null : 3)" 
                    class="w-full flex items-center justify-between p-5 text-left font-bold text-slate-900 hover:text-sky-700 transition-colors focus:outline-hidden"
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
            <div class="bg-white rounded-2xl border border-slate-200/90 overflow-hidden shadow-2xs transition-all">
                <button 
                    @click="active = (active === 4 ? null : 4)" 
                    class="w-full flex items-center justify-between p-5 text-left font-bold text-slate-900 hover:text-sky-700 transition-colors focus:outline-hidden"
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
            <div class="bg-white rounded-2xl border border-slate-200/90 overflow-hidden shadow-2xs transition-all">
                <button 
                    @click="active = (active === 5 ? null : 5)" 
                    class="w-full flex items-center justify-between p-5 text-left font-bold text-slate-900 hover:text-sky-700 transition-colors focus:outline-hidden"
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
<section class="py-16 lg:py-20 bg-gradient-to-br from-slate-900 via-slate-900 to-sky-950 text-white border-t border-slate-800 relative overflow-hidden fade-up">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 relative text-center zoom-in delay-100">
        
        <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-slate-800 border border-slate-700 text-emerald-400 text-xs font-bold rounded-full uppercase tracking-wider mb-4">
            HOTLINE SIAGA 24 JAM &bull; SEJABODETABEK & KOTA LAIN
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
               class="w-full sm:w-auto inline-flex items-center justify-center gap-3 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-base px-8 py-4 rounded-xl shadow-lg hover:shadow-xl active:scale-98 transition-all">
                <svg class="w-5 h-5 fill-current shrink-0" viewBox="0 0 24 24">
                    <path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/>
                </svg>
                <span>Panggil Teknisi via WhatsApp</span>
            </a>

            <a href="tel:{{ $whatsappNumber }}" 
               class="w-full sm:w-auto inline-flex items-center justify-center gap-2 bg-slate-800 hover:bg-slate-700 text-white font-bold text-base px-6 py-4 rounded-xl border border-slate-700 transition-colors">
                <svg class="w-5 h-5 text-sky-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                </svg>
                <span>Hotline Telepon Langsung</span>
            </a>
        </div>

        <p class="text-xs text-slate-400 mt-5 font-medium">
            Respon Cepat 24 Jam &bull; Garansi Nota 30 Hari &bull; 100% Tanpa Bongkar Keramik
        </p>
    </div>
</section>
@endsection
