<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {!! SEO::generate() !!}

    <!-- Preload Resource Fonts & DNS Preconnect -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="preload" as="style" href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap">

    <!-- Preload Critical LCP Hero Image (Mobile First & Desktop WebP) -->
    <link rel="preload" as="image" href="{{ asset('images/hero-technician-mobile.webp') }}" media="(max-width: 640px)" type="image/webp" fetchpriority="high">
    <link rel="preload" as="image" href="{{ asset('images/hero-technician.webp') }}" media="(min-width: 641px)" type="image/webp" fetchpriority="high">

    <!-- Global Application State Data (Lightweight, Non-blocking) -->
    <script>
        window.__DRAINUSANTARA_WA__ = "{{ config('app.whatsapp_number') ?: '6281234567890' }}";
    </script>

    <!-- Vite Assets (Compiled Tailwind CSS & Alpine.js Bundle) -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Google Fonts (Asynchronous & Non-render-blocking) -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" media="print" onload="this.media='all'">
    <noscript>
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap">
    </noscript>

    <style>
        [x-cloak] { display: none !important; }

        /* Smooth On-Scroll Animation */
        .fade-up {
            opacity: 0;
            transform: translateY(20px);
            transition: opacity 0.6s cubic-bezier(0.16, 1, 0.3, 1), transform 0.6s cubic-bezier(0.16, 1, 0.3, 1);
            will-change: opacity, transform;
        }
        .fade-up.is-visible {
            opacity: 1;
            transform: translateY(0);
        }

        .fade-in {
            opacity: 0;
            transition: opacity 0.6s cubic-bezier(0.16, 1, 0.3, 1);
            will-change: opacity;
        }
        .fade-in.is-visible {
            opacity: 1;
        }

        .zoom-in {
            opacity: 0;
            transform: scale(0.96);
            transition: opacity 0.6s cubic-bezier(0.16, 1, 0.3, 1), transform 0.6s cubic-bezier(0.16, 1, 0.3, 1);
            will-change: opacity, transform;
        }
        .zoom-in.is-visible {
            opacity: 1;
            transform: scale(1);
        }

        /* GPU Accelerated Subtle Pulse for WhatsApp Conversion CTA */
        @keyframes pulse-ring {
            0% { transform: scale(1); }
            50% { transform: scale(1.05); }
            100% { transform: scale(1); }
        }
        .wa-pulse-cta {
            animation: pulse-ring 2.8s infinite ease-in-out;
            will-change: transform;
        }

        /* Mobile Dock Performance Layer Containment */
        .mobile-nav-dock {
            contain: layout style;
            transform: translateZ(0);
        }

        /* Subtle Horizontal Swipe Hint Indicator */
        @keyframes bounce-x {
            0%, 100% { transform: translateX(0); }
            50% { transform: translateX(4px); }
        }
        .animate-bounce-x {
            animation: bounce-x 1.5s infinite ease-in-out;
        }

        /* Stagger Delays */
        .delay-100 { transition-delay: 100ms; }
        .delay-150 { transition-delay: 150ms; }
        .delay-200 { transition-delay: 200ms; }
        .delay-300 { transition-delay: 300ms; }

        @media (prefers-reduced-motion: reduce) {
            .fade-up, .fade-in, .zoom-in, .wa-pulse-cta {
                opacity: 1 !important;
                transform: none !important;
                transition: none !important;
                animation: none !important;
            }
        }
    </style>
    <noscript>
        <style>
            .fade-up, .fade-in, .zoom-in {
                opacity: 1 !important;
                transform: none !important;
            }
        </style>
    </noscript>

    @stack('styles')
</head>
<body class="bg-slate-50 text-slate-800 font-sans antialiased min-h-screen flex flex-col"
      x-data="layoutData"
      @keydown.escape.window="activeMenu = null; sidebarOpen = false; mobileSearchOpen = false">

    <!-- ====================================================================
         1. DESKTOP NAVBAR & SMART MEGA MENU (MODERN FRIENDLY & HIGIENIS)
         border-b border-slate-200/80 bg-white/95 backdrop-blur-md sticky top-0 z-40
    ==================================================================== -->
    <header class="border-b border-slate-200/80 bg-white/95 backdrop-blur-md sticky top-0 z-40 transition-all shadow-2xs"
            @click.outside="activeMenu = null">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-20">
                <!-- Modern Friendly Brand Logo & Sub-Badge -->
                <a href="{{ url('/') }}" class="flex items-center gap-3 group">
                    <div class="w-10 h-10 rounded-xl bg-sky-50 border border-sky-100 text-sky-700 flex items-center justify-center group-hover:bg-sky-100 transition-colors shadow-2xs">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" />
                        </svg>
                    </div>
                    <div>
                        <span class="text-xl font-extrabold tracking-tight text-slate-900 block leading-tight">
                            DRAI<span class="text-sky-700">NUSANTARA</span>
                        </span>
                        <span class="text-[10px] font-semibold text-slate-500 tracking-wider uppercase block">
                            Jasa Saluran Tanpa Bongkar
                        </span>
                    </div>
                </a>

                <!-- Desktop Navigation Items -->
                <nav class="hidden md:flex items-center space-x-6 text-sm font-semibold text-slate-600">
                    <!-- Dropdown Trigger: Layanan (Smart Mega Menu) -->
                    <button @click="activeMenu = (activeMenu === 'layanan' ? null : 'layanan')"
                            type="button" 
                            class="inline-flex items-center gap-1.5 py-2 hover:text-sky-700 transition-colors focus:outline-hidden cursor-pointer"
                            :class="{ 'text-sky-700 font-bold': activeMenu === 'layanan' }">
                        <span>Layanan</span>
                        <svg class="w-4 h-4 transition-transform duration-200 text-slate-400" :class="{ 'rotate-180 text-sky-700': activeMenu === 'layanan' }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>

                    <!-- Nav Link: Cara Kerja (3 Langkah) -->
                    <a href="{{ url('/#cara-kerja') }}" class="py-2 hover:text-sky-700 transition-colors">
                        Cara Kerja
                    </a>

                    <!-- Nav Link: Bukti Kerja (Before-After) -->
                    <a href="{{ url('/galeri') }}" class="py-2 hover:text-sky-700 transition-colors {{ request()->is('galeri*') ? 'text-sky-700 font-bold' : '' }}">
                        Bukti Hasil Kerja
                    </a>

                    <!-- Dropdown Trigger: Cakupan Wilayah (Quick Area Finder) -->
                    <button @click="activeMenu = (activeMenu === 'wilayah' ? null : 'wilayah')"
                            type="button" 
                            class="inline-flex items-center gap-1.5 py-2 hover:text-sky-700 transition-colors focus:outline-hidden cursor-pointer"
                            :class="{ 'text-sky-700 font-bold': activeMenu === 'wilayah' }">
                        <span>Area Jangkauan</span>
                        <svg class="w-4 h-4 transition-transform duration-200 text-slate-400" :class="{ 'rotate-180 text-sky-700': activeMenu === 'wilayah' }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>

                    <!-- Nav Link: Edukasi Bebas Kimia -->
                    <a href="{{ url('/#edukasi') }}" class="py-2 hover:text-sky-700 transition-colors">
                        Edukasi Sanitasi
                    </a>
                </nav>

                <!-- Desktop CTA: Tombol 'Hubungi Kami' -->
                <div class="hidden md:flex items-center">
                    <a :href="'https://wa.me/' + whatsappNumber + '?text=' + encodeURIComponent('Halo Admin Drainusantara, saluran air di rumah saya sedang mampet. Mohon info teknisi terdekat.')"
                       target="_blank" 
                       rel="noopener noreferrer" 
                       class="bg-emerald-600 hover:bg-emerald-700 text-white font-bold rounded-xl px-5 py-2.5 shadow-sm hover:shadow transition-all inline-flex items-center gap-2 active:scale-98 text-sm">
                        <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24">
                            <path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/>
                        </svg>
                        <span>Hubungi Kami</span>
                    </a>
                </div>

                <!-- Mobile Top Mini CTA Indicator -->
                <div class="flex items-center gap-2 md:hidden">
                    <a :href="'https://wa.me/' + whatsappNumber + '?text=' + encodeURIComponent('Halo Admin Drainusantara, saluran air di rumah saya sedang mampet. Mohon info teknisi terdekat.')"
                       target="_blank" 
                       rel="noopener noreferrer" 
                       class="bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold px-3 py-1.5 rounded-xl border border-emerald-700 shadow-xs inline-flex items-center gap-1.5">
                        <span class="w-1.5 h-1.5 bg-emerald-200 rounded-full animate-ping"></span>
                        <span>Hotline WA</span>
                    </a>
                </div>
            </div>
        </div>

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
             class="absolute top-full inset-x-0 bg-white/98 backdrop-blur-md border-b border-slate-200/90 shadow-xl py-6 hidden md:block rounded-b-2xl">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-12 gap-8 items-stretch">
                    
                    <!-- Sisi Kiri: Grid 4 Kategori Esensial -->
                    <div class="col-span-7 pr-6 border-r border-slate-200">
                        <div class="flex items-center justify-between pb-3 mb-4 border-b border-slate-100">
                            <span class="text-xs font-mono font-bold text-sky-700 uppercase tracking-wider">
                                4 DIVISI SPESIALISASI DRAINASE
                            </span>
                            <span class="text-[11px] font-semibold text-emerald-600 bg-emerald-50 px-2 py-0.5 rounded-full">100% Bebas Bongkar Keramik</span>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <!-- 1. Saluran Domestik -->
                            <a href="{{ url('/#layanan') }}" @click="activeMenu = null" class="p-4 rounded-xl bg-slate-50 hover:bg-white border border-slate-200/80 hover:border-sky-300 hover:shadow-xs transition-all group">
                                <div class="flex items-center justify-between mb-1.5">
                                    <span class="text-xs font-bold text-slate-900 group-hover:text-sky-700">1. Saluran Domestik</span>
                                    <span class="text-[9px] font-mono font-bold px-2 py-0.5 bg-sky-100 text-sky-800 rounded-full">RESIDENSIAL</span>
                                </div>
                                <p class="text-[11px] text-slate-600 leading-relaxed">
                                    Wastafel dapur, floor drain kamar mandi, kloset, dan pipa talang air dengan spiral lentur tanpa bongkar.
                                </p>
                            </a>

                            <!-- 2. Sedot & Kuras Grease Trap -->
                            <a href="{{ url('/#layanan') }}" @click="activeMenu = null" class="p-4 rounded-xl bg-slate-50 hover:bg-white border border-slate-200/80 hover:border-sky-300 hover:shadow-xs transition-all group">
                                <div class="flex items-center justify-between mb-1.5">
                                    <span class="text-xs font-bold text-slate-900 group-hover:text-sky-700">2. Grease Trap Resto</span>
                                    <span class="text-[9px] font-mono font-bold px-2 py-0.5 bg-amber-100 text-amber-800 rounded-full">F&B KOMERSIAL</span>
                                </div>
                                <p class="text-[11px] text-slate-600 leading-relaxed">
                                    Pembersihan lemak jenuh & sisa minyak kafe/restoran dengan ekstraksi vakum & rotary degreaser bebas bau.
                                </p>
                            </a>

                            <!-- 3. Inspeksi Digital CCTV 30M -->
                            <a href="{{ url('/#layanan') }}" @click="activeMenu = null" class="p-4 rounded-xl bg-slate-50 hover:bg-white border border-slate-200/80 hover:border-sky-300 hover:shadow-xs transition-all group">
                                <div class="flex items-center justify-between mb-1.5">
                                    <span class="text-xs font-bold text-slate-900 group-hover:text-sky-700">3. Inspeksi CCTV 30M</span>
                                    <span class="text-[9px] font-mono font-bold px-2 py-0.5 bg-emerald-100 text-emerald-800 rounded-full">DIAGNOSTIK IP68</span>
                                </div>
                                <p class="text-[11px] text-slate-600 leading-relaxed">
                                    Deteksi visual titik pipa retak, pecah, amblas, atau akar pohon dengan layar monitor HD & rekaman video.
                                </p>
                            </a>

                            <!-- 4. Heavy-Duty Hydro-Jetting -->
                            <a href="{{ url('/#b2b') }}" @click="activeMenu = null" class="p-4 rounded-xl bg-slate-50 hover:bg-white border border-slate-200/80 hover:border-sky-300 hover:shadow-xs transition-all group">
                                <div class="flex items-center justify-between mb-1.5">
                                    <span class="text-xs font-bold text-slate-900 group-hover:text-sky-700">4. Hydro-Jetting Industri</span>
                                    <span class="text-[9px] font-mono font-bold px-2 py-0.5 bg-slate-200 text-slate-800 rounded-full">PABRIK & GEDUNG</span>
                                </div>
                                <p class="text-[11px] text-slate-600 leading-relaxed">
                                    Semburan air bertekanan tinggi merontokkan endapan semen dan kerak lumpur keras pada instalasi pipa diameter besar.
                                </p>
                            </a>
                        </div>
                    </div>

                    <!-- Sisi Kanan: Inovasi "Interactive Diagnostic Widget" -->
                    <div class="col-span-5 flex flex-col justify-between bg-slate-900 text-white rounded-2xl p-6 border border-slate-800 shadow-md">
                        <div>
                            <div class="flex items-center justify-between mb-3 pb-2 border-b border-slate-800">
                                <span class="text-[11px] font-mono text-emerald-400 font-bold uppercase tracking-wider flex items-center gap-1.5">
                                    <span class="w-2 h-2 bg-emerald-500 rounded-full animate-ping"></span>
                                    INTERACTIVE DIAGNOSTIC WIDGET
                                </span>
                                <span class="text-[10px] font-mono text-slate-400">1-KLIK GENERATE WA</span>
                            </div>

                            <p class="text-xs text-slate-300 mb-3">
                                Pilih jenis saluran bermasalah di bawah untuk melihat alat kerja & kirim teknisi:
                            </p>

                            <!-- Selector Pills (1-Klik) -->
                            <div class="grid grid-cols-3 gap-2 mb-4">
                                <button type="button" @click="diagProblem = 'wastafel'" 
                                        :class="diagProblem === 'wastafel' ? 'bg-sky-600 text-white border-sky-400 font-bold' : 'bg-slate-800 text-slate-300 border-slate-700 hover:bg-slate-700'"
                                        class="px-2.5 py-2 rounded-xl border text-[11px] font-semibold transition-all">
                                    Wastafel
                                </button>
                                <button type="button" @click="diagProblem = 'toilet'" 
                                        :class="diagProblem === 'toilet' ? 'bg-sky-600 text-white border-sky-400 font-bold' : 'bg-slate-800 text-slate-300 border-slate-700 hover:bg-slate-700'"
                                        class="px-2.5 py-2 rounded-xl border text-[11px] font-semibold transition-all">
                                    Kloset / WC
                                </button>
                                <button type="button" @click="diagProblem = 'floordrain'" 
                                        :class="diagProblem === 'floordrain' ? 'bg-sky-600 text-white border-sky-400 font-bold' : 'bg-slate-800 text-slate-300 border-slate-700 hover:bg-slate-700'"
                                        class="px-2.5 py-2 rounded-xl border text-[11px] font-semibold transition-all">
                                    Floor Drain
                                </button>
                                <button type="button" @click="diagProblem = 'greasetrap'" 
                                        :class="diagProblem === 'greasetrap' ? 'bg-sky-600 text-white border-sky-400 font-bold' : 'bg-slate-800 text-slate-300 border-slate-700 hover:bg-slate-700'"
                                        class="px-2.5 py-2 rounded-xl border text-[11px] font-semibold transition-all">
                                    Grease Trap
                                </button>
                                <button type="button" @click="diagProblem = 'talang'" 
                                        :class="diagProblem === 'talang' ? 'bg-sky-600 text-white border-sky-400 font-bold' : 'bg-slate-800 text-slate-300 border-slate-700 hover:bg-slate-700'"
                                        class="px-2.5 py-2 rounded-xl border text-[11px] font-semibold transition-all">
                                    Talang Atap
                                </button>
                                <button type="button" @click="diagProblem = 'cctv'" 
                                        :class="diagProblem === 'cctv' ? 'bg-sky-600 text-white border-sky-400 font-bold' : 'bg-slate-800 text-slate-300 border-slate-700 hover:bg-slate-700'"
                                        class="px-2.5 py-2 rounded-xl border text-[11px] font-semibold transition-all">
                                    CCTV 30M
                                </button>
                            </div>

                            <!-- Preview Box -->
                            <div class="bg-slate-950/70 p-4 rounded-xl border border-slate-800 text-xs space-y-2">
                                <div class="flex items-center justify-between text-[11px] font-mono">
                                    <span class="text-sky-400 font-bold" x-text="diagnostics[diagProblem].title"></span>
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
                               class="w-full flex items-center justify-center gap-2 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs sm:text-sm py-3 px-4 rounded-xl border border-emerald-500 shadow-sm transition-colors">
                                <svg class="w-4 h-4 fill-current shrink-0" viewBox="0 0 24 24">
                                    <path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/>
                                </svg>
                                <span>Kirim Teknisi untuk Masalah Ini</span>
                            </a>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <!-- ====================================================================
             B. SMART MEGA MENU: CAKUPAN WILAYAH (QUICK AREA FINDER INTERAKTIF)
        ==================================================================== -->
        <div x-cloak 
             x-show="activeMenu === 'wilayah'"
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0 -translate-y-2"
             x-transition:enter-end="opacity-100 translate-y-0"
             x-transition:leave="transition ease-in duration-150"
             x-transition:leave-start="opacity-100 translate-y-0"
             x-transition:leave-end="opacity-0 -translate-y-2"
             class="absolute top-full inset-x-0 bg-white/98 backdrop-blur-md border-b border-slate-200/90 shadow-xl py-6 hidden md:block rounded-b-2xl">
            <template x-if="activeMenu === 'wilayah'">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex items-center justify-between pb-3 mb-4 border-b border-slate-200">
                        <div>
                            <span class="text-xs font-mono font-bold text-sky-700 uppercase tracking-wider block">QUICK AREA FINDER</span>
                            <span class="text-xs text-slate-500">Filter kota atau kecamatan secara instan untuk konfirmasi armada siaga:</span>
                        </div>
                        <!-- Mini Search Bar Input -->
                        <div class="w-80 relative">
                            <input type="text" 
                                   x-model="areaSearch" 
                                   placeholder="Ketik kota/kecamatan (contoh: Tebet, Serpong)..." 
                                   class="w-full bg-slate-50 border border-slate-300 rounded-xl pl-9 pr-3 py-2 text-xs font-mono text-slate-800 focus:outline-hidden focus:border-sky-700 transition-colors">
                            <svg class="w-4 h-4 text-slate-400 absolute left-3 top-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </div>
                    </div>

                    <!-- Filtered Result Cards Grid -->
                    <div class="grid grid-cols-4 gap-3 max-h-72 overflow-y-auto pr-1">
                        <template x-for="area in areas" :key="area.url">
                            <a :href="area.url" 
                               @click="activeMenu = null"
                               x-show="filterArea(area)"
                               class="p-3.5 rounded-xl bg-slate-50 hover:bg-white border border-slate-200/80 hover:border-sky-400 hover:shadow-xs transition-all block group">
                                <div class="flex items-center justify-between mb-1.5 gap-2">
                                    <div class="flex items-center gap-1.5 min-w-0">
                                        <span class="text-[9px] font-mono font-bold px-1.5 py-0.5 rounded-full shrink-0"
                                              :class="{
                                                  'bg-sky-100 text-sky-800 border border-sky-200': area.type === 'Provinsi',
                                                  'bg-indigo-100 text-indigo-800 border border-indigo-200': area.type === 'Kota',
                                                  'bg-emerald-100 text-emerald-800 border border-emerald-200': area.type === 'Kecamatan'
                                              }"
                                              x-text="area.badge"></span>
                                        <span class="text-xs font-bold text-slate-900 group-hover:text-sky-700 truncate" x-text="area.name"></span>
                                    </div>
                                    <span class="text-[9px] font-mono text-emerald-700 font-bold bg-emerald-50 px-2 py-0.5 rounded-full shrink-0" x-text="area.eta"></span>
                                </div>
                                <p class="text-[11px] text-slate-500 line-clamp-1" x-html="area.subtitle"></p>
                            </a>
                        </template>
                    </div>

                    <!-- Empty State if search matches nothing -->
                    <div x-show="areas.filter(a => filterArea(a)).length === 0" 
                         class="py-6 text-center text-xs text-slate-500 font-mono">
                        Wilayah tidak ditemukan dalam daftar cepat. Hubungi hotline kami untuk konfirmasi teknisi di area Anda.
                    </div>
                </div>
            </template>
        </div>
    </header>

    <!-- ====================================================================
         2. MOBILE QUICK AREA FINDER (SLIDE-UP SHEET MODAL)
    ==================================================================== -->
    <div x-cloak x-show="mobileSearchOpen" class="fixed inset-0 z-50 md:hidden" role="dialog" aria-modal="true">
        <div x-show="mobileSearchOpen"
             x-transition:enter="transition-opacity ease-linear duration-200"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition-opacity ease-linear duration-150"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             @click="mobileSearchOpen = false"
             class="fixed inset-0 bg-slate-900/60 backdrop-blur-xs"></div>

        <div x-show="mobileSearchOpen"
             x-transition:enter="transition ease-out duration-300 transform"
             x-transition:enter-start="translate-y-full"
             x-transition:enter-end="translate-y-0"
             x-transition:leave="transition ease-in duration-200 transform"
             x-transition:leave-start="translate-y-0"
             x-transition:leave-end="translate-y-full"
             class="fixed inset-x-0 bottom-0 max-h-[82vh] bg-white rounded-t-2xl border-t border-slate-200 p-5 shadow-2xl flex flex-col overflow-hidden">
            <template x-if="mobileSearchOpen">
                <div class="flex flex-col flex-1 overflow-hidden">
                    <div class="flex items-center justify-between pb-3 border-b border-slate-200">
                        <div class="flex items-center gap-2">
                            <svg class="w-4 h-4 text-sky-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                            <span class="font-extrabold text-slate-900 text-sm">Quick Area Finder</span>
                        </div>
                        <button @click="mobileSearchOpen = false" class="p-1.5 text-slate-400 hover:text-slate-700" aria-label="Tutup pencarian">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>
                    </div>

                    <div class="mt-3">
                        <input type="text"
                               x-model="areaSearch"
                               placeholder="Ketik nama kota atau kecamatan..."
                               class="w-full bg-slate-50 border border-slate-300 rounded-lg px-3.5 py-2 text-xs font-mono text-slate-800 focus:outline-hidden focus:border-sky-700">
                    </div>

                    <div class="mt-3 overflow-y-auto space-y-2 flex-1 max-h-[50vh] pr-1">
                        <template x-for="area in areas" :key="area.url">
                            <a :href="area.url" 
                               @click="mobileSearchOpen = false"
                               x-show="filterArea(area)"
                               class="block p-3 rounded-lg bg-slate-50 border border-slate-200 hover:border-sky-400 transition-colors">
                                <div class="flex items-center justify-between gap-2">
                                    <div class="flex items-center gap-1.5 min-w-0">
                                        <span class="text-[9px] font-mono font-bold px-1.5 py-0.5 rounded-xs shrink-0"
                                              :class="{
                                                  'bg-sky-100 text-sky-800 border border-sky-200': area.type === 'Provinsi',
                                                  'bg-indigo-100 text-indigo-800 border border-indigo-200': area.type === 'Kota',
                                                  'bg-emerald-100 text-emerald-800 border border-emerald-200': area.type === 'Kecamatan'
                                              }"
                                              x-text="area.badge"></span>
                                        <span class="text-xs font-bold text-slate-900 truncate" x-text="area.name"></span>
                                    </div>
                                    <span class="text-[10px] font-mono font-bold text-emerald-600 bg-emerald-50 px-1.5 py-0.5 rounded-xs shrink-0" x-text="area.eta"></span>
                                </div>
                                <p class="text-[11px] text-slate-500 mt-1 line-clamp-1" x-html="area.subtitle"></p>
                            </a>
                        </template>
                        <div x-show="areas.filter(a => filterArea(a)).length === 0" 
                             class="py-6 text-center text-xs text-slate-500 font-mono">
                            Wilayah tidak ditemukan. Hubungi hotline kami untuk konfirmasi teknisi di area Anda.
                        </div>
                    </div>
                </div>
            </template>
        </div>
    </div>

    <!-- ====================================================================
         3. SLIDE-OVER DRAWER MENU (K3, LEGALITAS, EDUKASI & B2B)
    ==================================================================== -->
    <div x-cloak x-show="sidebarOpen" class="fixed inset-0 z-50 md:hidden" role="dialog" aria-modal="true">
        <div x-show="sidebarOpen"
             x-transition:enter="transition-opacity ease-linear duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition-opacity ease-linear duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             @click="sidebarOpen = false"
             class="fixed inset-0 bg-slate-900/60 backdrop-blur-xs"></div>

        <div x-show="sidebarOpen"
             x-transition:enter="transition ease-in-out duration-300 transform"
             x-transition:enter-start="translate-x-full"
             x-transition:enter-end="translate-x-0"
             x-transition:leave="transition ease-in-out duration-200 transform"
             x-transition:leave-start="translate-x-0"
             x-transition:leave-end="translate-x-full"
             class="fixed inset-y-0 right-0 max-w-xs w-full bg-white border-l border-slate-200 shadow-2xl p-6 flex flex-col justify-between overflow-y-auto">
            
            <div>
                <!-- Header inside drawer -->
                <div class="flex items-center justify-between pb-4 border-b border-slate-200">
                    <div class="flex items-center gap-2.5">
                        <div class="w-9 h-9 rounded-xl bg-sky-700 text-white flex items-center justify-center font-extrabold text-sm shadow-xs">
                            DN
                        </div>
                        <div>
                            <span class="font-extrabold text-slate-900 tracking-tight block text-sm">DRAINUSANTARA</span>
                            <span class="text-[10px] text-sky-700 font-semibold block">Jasa Saluran Tanpa Bongkar</span>
                        </div>
                    </div>
                    <button @click="sidebarOpen = false" class="p-2 text-slate-400 hover:text-slate-700 rounded-xl hover:bg-slate-100 focus:outline-hidden transition-colors" aria-label="Tutup menu">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <!-- Navigation Links -->
                <nav class="mt-4 flex flex-col space-y-1">
                    <a href="{{ url('/') }}" @click="sidebarOpen = false" class="flex items-center px-3.5 py-2.5 text-xs font-bold rounded-xl text-slate-800 hover:bg-slate-100 hover:text-sky-700 transition-colors">
                        Beranda Utama
                    </a>
                    <a href="{{ url('/#layanan') }}" @click="sidebarOpen = false" class="flex items-center px-3.5 py-2.5 text-xs font-bold rounded-xl text-slate-800 hover:bg-slate-100 hover:text-sky-700 transition-colors">
                        Katalog Masalah Layanan
                    </a>
                    <a href="{{ url('/#cara-kerja') }}" @click="sidebarOpen = false" class="flex items-center px-3.5 py-2.5 text-xs font-bold rounded-xl text-slate-800 hover:bg-slate-100 hover:text-sky-700 transition-colors">
                        Alur 3 Langkah Mudah
                    </a>
                    <a href="{{ url('/galeri') }}" @click="sidebarOpen = false" class="flex items-center px-3.5 py-2.5 text-xs font-bold rounded-xl text-slate-800 hover:bg-slate-100 hover:text-sky-700 transition-colors">
                        Bukti Kerja (Before-After)
                    </a>
                    <a href="{{ url('/#edukasi') }}" @click="sidebarOpen = false" class="flex items-center px-3.5 py-2.5 text-xs font-bold rounded-xl text-slate-800 hover:bg-slate-100 hover:text-sky-700 transition-colors">
                        Edukasi Bebas Kimia (Anti Soda Api)
                    </a>
                    <a href="{{ url('/#b2b') }}" @click="sidebarOpen = false" class="flex items-center px-3.5 py-2.5 text-xs font-bold rounded-xl text-slate-800 hover:bg-slate-100 hover:text-sky-700 transition-colors">
                        Solusi Komersial & B2B Gedung
                    </a>
                    <a href="{{ url('/#area') }}" @click="sidebarOpen = false" class="flex items-center px-3.5 py-2.5 text-xs font-bold rounded-xl text-slate-800 hover:bg-slate-100 hover:text-sky-700 transition-colors">
                        Daftar Area Posko Siaga
                    </a>
                    <a href="{{ url('/#footer-workshop') }}" @click="sidebarOpen = false" class="flex items-center px-3.5 py-2.5 text-xs font-bold rounded-xl text-slate-800 hover:bg-slate-100 hover:text-sky-700 transition-colors">
                        Kontak Workshop & Alamat
                    </a>
                </nav>

                <!-- K3 & Legalitas Info Box -->
                <div class="mt-5 p-4 bg-slate-50 border border-slate-200/80 rounded-2xl">
                    <span class="text-[11px] font-bold text-sky-700 uppercase tracking-wider block mb-2">STANDAR K3 & LEGALITAS:</span>
                    <ul class="space-y-2 text-xs text-slate-600">
                        <li class="flex items-center gap-2">
                            <span class="text-emerald-600 font-bold select-none">✓</span>
                            <span>Badan Usaha Resmi Terdaftar</span>
                        </li>
                        <li class="flex items-center gap-2">
                            <span class="text-emerald-600 font-bold select-none">✓</span>
                            <span>Garansi Tertulis 30 Hari Kerja</span>
                        </li>
                        <li class="flex items-center gap-2">
                            <span class="text-emerald-600 font-bold select-none">✓</span>
                            <span>Teknisi Bersepatu & APD Steril</span>
                        </li>
                        <li class="flex items-center gap-2">
                            <span class="text-emerald-600 font-bold select-none">✓</span>
                            <span>Faktur Pajak B2B & Penagihan Resmi</span>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Bottom Action CTA -->
            <div class="pt-4 border-t border-slate-200 mt-6">
                <a :href="'https://wa.me/' + whatsappNumber + '?text=' + encodeURIComponent('Halo Admin Drainusantara, saya butuh penanganan darurat pipa mampet.')" 
                   target="_blank" 
                   rel="noopener noreferrer" 
                   class="w-full flex items-center justify-center gap-2 bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-3 px-4 rounded-xl shadow-sm transition-colors text-xs">
                    <span>Hubungi Teknisi 24 Jam</span>
                </a>
                <p class="text-[11px] text-center text-slate-500 mt-2 font-medium">Standby 24 Jam &bull; Respon &lt; 15 Menit</p>
            </div>
        </div>
    </div>

    <!-- Main Content Area with Bottom Padding on Mobile so Dock Doesn't Overlap -->
    <main class="flex-1 pb-24 md:pb-0">
        {{ $slot ?? '' }}
        @yield('content')
    </main>

    <!-- Mega Footer 6 Kolom Terstruktur (Industrial High-Trust) -->
    <footer class="bg-slate-900 text-slate-300 pt-16 pb-28 md:pb-12 border-t border-slate-800" id="footer-workshop">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-6 gap-8 mb-12">
                <!-- Kolom 1: Workshop & Alamat Utama -->
                <div class="space-y-4 lg:col-span-1">
                    <div class="flex items-center gap-2">
                        <div class="w-9 h-9 rounded-xl bg-sky-600 text-white flex items-center justify-center font-extrabold text-sm shadow-xs">
                            DN
                        </div>
                        <span class="text-lg font-extrabold tracking-tight text-white">DRAINUSANTARA</span>
                    </div>
                    <p class="text-xs text-slate-400 leading-relaxed">
                        Pusat layanan rooter mekanis pipa mampet profesional tanpa bongkar keramik. Dilengkapi kamera inspeksi CCTV pipa 30M dan garansi resmi 30 hari.
                    </p>
                    <div class="text-xs text-slate-400 space-y-1 pt-1 font-mono">
                        <div class="text-slate-200 font-bold">WORKSHOP PUSAT:</div>
                        <p class="leading-relaxed">Jl. Duren Sawit Raya No. 45, Jakarta Timur / Posko Siaga Jabodetabek</p>
                    </div>
                </div>

                <!-- Kolom 2: Layanan Residensial -->
                <div>
                    <h3 class="text-xs font-mono font-bold uppercase tracking-wider text-sky-400 mb-4 border-b border-slate-800 pb-2">Residensial</h3>
                    <ul class="space-y-2 text-xs text-slate-400">
                        <li><a href="{{ url('/#layanan') }}" class="hover:text-white transition-colors">Wastafel & Sink Dapur</a></li>
                        <li><a href="{{ url('/#layanan') }}" class="hover:text-white transition-colors">Kloset & Toilet Duduk/Jongkok</a></li>
                        <li><a href="{{ url('/#layanan') }}" class="hover:text-white transition-colors">Floor Drain Kamar Mandi</a></li>
                        <li><a href="{{ url('/#layanan') }}" class="hover:text-white transition-colors">Bak Kontrol & Pipa Pembuangan</a></li>
                        <li><a href="{{ url('/#layanan') }}" class="hover:text-white transition-colors">Pipa Pembuangan Mesin Cuci</a></li>
                    </ul>
                </div>

                <!-- Kolom 3: Solusi B2B & Gedung -->
                <div>
                    <h3 class="text-xs font-mono font-bold uppercase tracking-wider text-sky-400 mb-4 border-b border-slate-800 pb-2">Solusi B2B & Gedung</h3>
                    <ul class="space-y-2 text-xs text-slate-400">
                        <li><a href="{{ url('/#b2b') }}" class="hover:text-white transition-colors">Sedot Lemak Grease Trap Resto</a></li>
                        <li><a href="{{ url('/#b2b') }}" class="hover:text-white transition-colors">Talang Hujan & Pipa Rooftop</a></li>
                        <li><a href="{{ url('/#layanan') }}" class="hover:text-white transition-colors">Inspeksi Kamera CCTV 30M</a></li>
                        <li><a href="{{ url('/#b2b') }}" class="hover:text-white transition-colors">Kontrak Maintenance Rutin</a></li>
                        <li><a href="{{ url('/#b2b') }}" class="hover:text-white transition-colors">Faktur Pajak & Penagihan Resmi</a></li>
                    </ul>
                </div>

                <!-- Kolom 4: Area Jangkauan Jabodetabek -->
                <div>
                    <h3 class="text-xs font-mono font-bold uppercase tracking-wider text-sky-400 mb-4 border-b border-slate-800 pb-2">Wilayah Jabodetabek</h3>
                    <ul class="space-y-1.5 text-xs text-slate-400">
                        <li><a href="{{ route('area.province', ['province' => 'dki-jakarta']) }}" class="hover:text-white font-semibold text-sky-300">Provinsi DKI Jakarta &rarr;</a></li>
                        <li><a href="{{ route('area.city', ['city' => 'jakarta-timur']) }}" class="hover:text-white">Jakarta Timur</a></li>
                        <li><a href="{{ route('area.city', ['city' => 'jakarta-selatan']) }}" class="hover:text-white">Jakarta Selatan</a></li>
                        <li><a href="{{ route('area.city', ['city' => 'jakarta-barat']) }}" class="hover:text-white">Jakarta Barat</a></li>
                        <li><a href="{{ route('area.city', ['city' => 'jakarta-utara']) }}" class="hover:text-white">Jakarta Utara</a></li>
                        <li><a href="{{ route('area.city', ['city' => 'jakarta-pusat']) }}" class="hover:text-white">Jakarta Pusat</a></li>
                        <li><a href="{{ route('area.city', ['city' => 'bogor']) }}" class="hover:text-white">Bogor & Sentul</a></li>
                        <li><a href="{{ route('area.city', ['city' => 'depok-cinere']) }}" class="hover:text-white">Depok & Cinere</a></li>
                        <li><a href="{{ route('area.city', ['city' => 'tangerang-selatan']) }}" class="hover:text-white">Tangerang & Tangsel</a></li>
                        <li><a href="{{ route('area.city', ['city' => 'bekasi-cikarang']) }}" class="hover:text-white">Bekasi & Cikarang</a></li>
                    </ul>
                </div>

                <!-- Kolom 5: Hub Kota Lain -->
                <div>
                    <h3 class="text-xs font-mono font-bold uppercase tracking-wider text-sky-400 mb-4 border-b border-slate-800 pb-2">Provinsi & Hub Lain</h3>
                    <ul class="space-y-2 text-xs text-slate-400">
                        <li><a href="{{ route('area.province', ['province' => 'jawa-barat']) }}" class="hover:text-white font-semibold text-sky-300">Provinsi Jawa Barat</a></li>
                        <li><a href="{{ route('area.province', ['province' => 'banten']) }}" class="hover:text-white font-semibold text-sky-300">Provinsi Banten</a></li>
                        <li><a href="{{ route('area.city', ['city' => 'bandung']) }}" class="hover:text-white">Kota Bandung</a></li>
                        <li><a href="{{ route('area.province', ['province' => 'jawa-tengah']) }}" class="hover:text-white font-semibold text-sky-300">Provinsi Jawa Tengah</a></li>
                        <li><a href="{{ route('area.city', ['city' => 'semarang']) }}" class="hover:text-white">Kota Semarang</a></li>
                        <li><a href="{{ route('area.province', ['province' => 'lampung']) }}" class="hover:text-white font-semibold text-sky-300">Provinsi Lampung</a></li>
                        <li><a href="{{ route('area.city', ['city' => 'bandar-lampung']) }}" class="hover:text-white">Bandar Lampung</a></li>
                        <li class="pt-2">
                            <a href="{{ route('area.index') }}" class="inline-flex items-center gap-1 text-[11px] font-mono text-sky-400 hover:text-sky-300 underline">
                                Lihat Semua Area &rarr;
                            </a>
                        </li>
                    </ul>
                </div>

                <!-- Kolom 6: Legalitas & K3 -->
                <div>
                    <h3 class="text-xs font-mono font-bold uppercase tracking-wider text-sky-400 mb-4 border-b border-slate-800 pb-2">Legalitas & K3</h3>
                    <div class="space-y-2.5 text-xs text-slate-400">
                        <div class="flex items-start gap-1.5">
                            <span class="text-emerald-500 font-bold select-none">[✓]</span>
                            <span>Badan Usaha Resmi Terdaftar</span>
                        </div>
                        <div class="flex items-start gap-1.5">
                            <span class="text-emerald-500 font-bold select-none">[✓]</span>
                            <span>Garansi Tertulis 30 Hari Kerja</span>
                        </div>
                        <div class="flex items-start gap-1.5">
                            <span class="text-emerald-500 font-bold select-none">[✓]</span>
                            <span>Teknisi Bersepatu & APD Steril</span>
                        </div>
                        <div class="flex items-start gap-1.5">
                            <span class="text-emerald-500 font-bold select-none">[✓]</span>
                            <span>Tanpa Kimia / Bebas Soda Api</span>
                        </div>
                        <div class="pt-2">
                            <a :href="'https://wa.me/' + whatsappNumber + '?text=' + encodeURIComponent('Halo Admin Drainusantara, saya ingin konsultasi teknis.')" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-1.5 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs px-3.5 py-2.5 rounded-xl border border-emerald-700 shadow-sm transition-colors">
                                <span>Hubungi CS Siaga</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Peta Workshop & Disclaimer Anti-Soda Api Bar -->
            <div class="mb-10 p-5 rounded-2xl bg-slate-800/80 border border-slate-700/80 grid grid-cols-1 lg:grid-cols-12 gap-6 items-center">
                <!-- Map Embed Preview -->
                <div class="lg:col-span-4 rounded-xl overflow-hidden border border-slate-700 aspect-[16/9] bg-slate-950 relative">
                    <iframe 
                        title="Peta Posko Siaga Drainusantara"
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d126920.28318721204!2d106.82056!3d-6.2297464!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e69f3e46c757c23%3A0xa6436e2f694dc50!2sJakarta%20Timur%2C%20Kota%20Jakarta%20Timur%2C%20Daerah%20Khusus%20Ibukota%20Jakarta!5e0!3m2!1sid!2sid!4v1700000000000!5m2!1sid!2sid" 
                        class="w-full h-full border-0 grayscale contrast-125 opacity-80 hover:opacity-100 transition-opacity" 
                        loading="lazy" 
                        referrerpolicy="no-referrer-when-downgrade">
                    </iframe>
                    <div class="absolute bottom-2 left-2 bg-slate-900/90 text-white text-[10px] font-mono px-2 py-0.5 rounded-sm border border-slate-700">
                        📍 Posko Siaga 24 Jam
                    </div>
                </div>

                <!-- 24 Jam Operasional & Anti-Soda Api Disclaimer -->
                <div class="lg:col-span-8 space-y-3">
                    <div class="flex flex-wrap items-center gap-2">
                        <span class="px-2.5 py-0.5 rounded-full bg-emerald-500/20 text-emerald-400 border border-emerald-500/30 text-xs font-bold inline-flex items-center gap-1.5">
                            <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                            OPERASIONAL 24 JAM &bull; TANGGAL MERAH TETAP BUKA
                        </span>
                        <span class="text-xs text-slate-400 font-mono">Respon Darurat &lt; 15 Menit</span>
                    </div>

                    <div class="p-3.5 rounded-xl bg-amber-500/10 border border-amber-500/30 text-xs text-amber-200/90 leading-relaxed">
                        <strong class="text-amber-300 font-bold block mb-1">⚠️ PERINGATAN KESELAMATAN PIPA (ANTI-SODA API):</strong>
                        Hindari menuangkan soda api atau cairan asam sulfat ke dalam saluran pipa paralon/PVC. Panas reaksi kimia dapat melunakkan, meretakkan pipa, dan merusak sambungan lem secara permanen. Drainusantara hanya menggunakan metode mekanis spiral baja lentur dan pembersihan CCTV ramah instalasi.
                    </div>
                </div>
            </div>

            <!-- Footer Bottom Note -->
            <div class="pt-8 border-t border-slate-800 flex flex-col sm:flex-row items-center justify-between gap-4 text-center sm:text-left text-xs text-slate-500 font-mono">
                <p>&copy; {{ date('Y') }} Drainusantara. Rooter & Plumbing Engineering. 100% Tanpa Bongkar Keramik & Tanpa Soda Api.</p>
                <div class="flex items-center gap-4 text-slate-400">
                    <span>Spiral Baja Elektrik</span>
                    <span>&bull;</span>
                    <span>CCTV IP68 30M</span>
                    <span>&bull;</span>
                    <span>Garansi 30 Hari</span>
                </div>
            </div>
        </div>
    </footer>

    <!-- ====================================================================
         4. MOBILE BOTTOM FLOATING DOCK (PILL BAR RAMPING DI TENGAH BAWAH)
         fixed bottom-3 inset-x-4 max-w-md mx-auto z-50 bg-slate-900/95 text-white backdrop-blur rounded-2xl shadow-xl border border-slate-800 p-2 flex items-center justify-around md:hidden
    ==================================================================== -->
    <nav class="fixed bottom-3 inset-x-4 max-w-md mx-auto z-50 bg-slate-900/95 text-white backdrop-blur-md rounded-2xl shadow-xl border border-slate-800 p-2 flex items-center justify-around md:hidden mobile-nav-dock" aria-label="Navigasi Mobile Floating Dock">
        <!-- 1. Beranda (Icon Home) -->
        <a href="{{ url('/') }}" class="flex flex-col items-center justify-center py-1 px-2.5 text-xs {{ Request::is('/') ? 'text-sky-400 font-bold' : 'text-slate-300' }} hover:text-white transition-colors">
            <svg class="w-5 h-5 mb-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
            </svg>
            <span class="text-[10px] tracking-tight font-semibold">Beranda</span>
        </a>

        <!-- 2. Layanan (Icon Tools) -->
        <a href="{{ url('/#layanan') }}" class="flex flex-col items-center justify-center py-1 px-2.5 text-xs text-slate-300 hover:text-white transition-colors">
            <svg class="w-5 h-5 mb-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
            </svg>
            <span class="text-[10px] tracking-tight font-semibold">Layanan</span>
        </a>

        <!-- 3. WhatsApp Hero Center (Tombol bulat hijau empuk menonjol di tengah dengan subtle pulse) -->
        <div class="relative px-1">
            <a :href="'https://wa.me/' + whatsappNumber + '?text=' + encodeURIComponent('Halo Admin Drainusantara, saluran air di rumah saya sedang mampet. Mohon info teknisi terdekat.')" 
               target="_blank" 
               rel="noopener noreferrer" 
               class="-mt-6 bg-emerald-600 hover:bg-emerald-700 text-white p-3.5 rounded-full shadow-lg border-4 border-slate-900 flex items-center justify-center wa-pulse-cta active:scale-95 transition-transform" 
               aria-label="Panggil Teknisi via WhatsApp">
                <svg class="w-6 h-6 fill-current" viewBox="0 0 24 24">
                    <path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/>
                </svg>
            </a>
        </div>

        <!-- 4. Cari Wilayah (Icon Search / Pin) -->
        <button @click="mobileSearchOpen = true; activeMenu = null" type="button" class="flex flex-col items-center justify-center py-1 px-2.5 text-xs text-slate-300 hover:text-white transition-colors cursor-pointer" aria-label="Cari Wilayah">
            <svg class="w-5 h-5 mb-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
            </svg>
            <span class="text-[10px] tracking-tight font-semibold">Area</span>
        </button>

        <!-- 5. Drawer Menu (Icon Hamburger) -->
        <button @click="sidebarOpen = true" type="button" class="flex flex-col items-center justify-center py-1 px-2.5 text-xs text-slate-300 hover:text-white transition-colors cursor-pointer" aria-label="Menu Lengkap">
            <svg class="w-5 h-5 mb-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
            </svg>
            <span class="text-[10px] tracking-tight font-semibold">Menu</span>
        </button>
    </nav>

    <!-- Searchable Areas JSON (Evaluated on-demand by Alpine, non-render-blocking) -->
    <script type="application/json" id="drainusantara-areas-data">
        {!! json_encode(\App\Services\RegionService::getSearchableItems(), JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}
    </script>

    @stack('scripts')

    <!-- Scroll Visibility Observer -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const animatedElements = document.querySelectorAll('.fade-up, .fade-in, .zoom-in');
            if ('IntersectionObserver' in window) {
                const observer = new IntersectionObserver((entries, obs) => {
                    entries.forEach(entry => {
                        if (entry.isIntersecting) {
                            entry.target.classList.add('is-visible');
                            obs.unobserve(entry.target);
                        }
                    });
                }, {
                    root: null,
                    rootMargin: '0px 0px -25px 0px',
                    threshold: 0.1
                });
                animatedElements.forEach(el => observer.observe(el));
            } else {
                animatedElements.forEach(el => el.classList.add('is-visible'));
            }
        });
    </script>
</body>
</html>
