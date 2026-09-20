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

    <!-- Vite Assets (Compiled Tailwind CSS & Alpine.js Bundle) -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Google Fonts (Asynchronous & Non-render-blocking) -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" media="print" onload="this.media='all'">
    <noscript>
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap">
    </noscript>

    <style>
        [x-cloak] { display: none !important; }

        /* On-scroll Simple Smooth Animation */
        .fade-up {
            opacity: 0;
            transform: translateY(24px);
            transition: opacity 0.65s cubic-bezier(0.16, 1, 0.3, 1), transform 0.65s cubic-bezier(0.16, 1, 0.3, 1);
            will-change: opacity, transform;
        }
        .fade-up.is-visible {
            opacity: 1;
            transform: translateY(0);
        }

        .fade-in {
            opacity: 0;
            transition: opacity 0.65s cubic-bezier(0.16, 1, 0.3, 1);
            will-change: opacity;
        }
        .fade-in.is-visible {
            opacity: 1;
        }

        .zoom-in {
            opacity: 0;
            transform: scale(0.95);
            transition: opacity 0.65s cubic-bezier(0.16, 1, 0.3, 1), transform 0.65s cubic-bezier(0.16, 1, 0.3, 1);
            will-change: opacity, transform;
        }
        .zoom-in.is-visible {
            opacity: 1;
            transform: scale(1);
        }

        /* Stagger Delays */
        .delay-100 { transition-delay: 100ms; }
        .delay-150 { transition-delay: 150ms; }
        .delay-200 { transition-delay: 200ms; }
        .delay-300 { transition-delay: 300ms; }

        @media (prefers-reduced-motion: reduce) {
            .fade-up, .fade-in, .zoom-in {
                opacity: 1 !important;
                transform: none !important;
                transition: none !important;
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
<body class="bg-slate-50 text-slate-800 font-sans antialiased min-h-screen flex flex-col" x-data="{ mobileMenuOpen: false }">
    @php
        $whatsappNumber = config('app.whatsapp_number', '6281234567890');
        $whatsappMessage = urlencode('Halo Drainusantara, saya butuh penanganan saluran/pipa mampet. Mohon info biaya dan jadwal teknisi.');
        $whatsappUrl = "https://wa.me/{$whatsappNumber}?text={$whatsappMessage}";
    @endphp

    <!-- Top Desktop & Mobile Header -->
    <header class="sticky top-0 z-40 bg-white/95 backdrop-blur-md border-b border-slate-200 transition-all duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-20">
                <!-- Brand Logo -->
                <a href="{{ url('/') }}" class="flex items-center gap-3 group">
                    <div class="w-11 h-11 rounded-xl bg-sky-600 text-white flex items-center justify-center shadow-md shadow-sky-600/20 group-hover:bg-sky-700 transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" />
                        </svg>
                    </div>
                    <div>
                        <span class="text-xl font-extrabold tracking-tight text-slate-900 block leading-tight">
                            DRAI<span class="text-sky-600">NUSANTARA</span>
                        </span>
                        <span class="text-[11px] font-medium text-slate-500 tracking-wider uppercase block">
                            Rooter & Plumbing Service
                        </span>
                    </div>
                </a>

                <!-- Desktop Navigation Bar -->
                <nav class="hidden md:flex items-center space-x-7 text-sm font-semibold text-slate-600">
                    <a href="{{ url('/') }}" class="hover:text-sky-600 transition-colors {{ request()->is('/') ? 'text-sky-600' : '' }}">Beranda</a>
                    <a href="{{ url('/layanan') }}" class="hover:text-sky-600 transition-colors {{ request()->is('layanan*') ? 'text-sky-600' : '' }}">Layanan</a>
                    <a href="{{ url('/tentang-kami') }}" class="hover:text-sky-600 transition-colors {{ request()->is('tentang-kami') ? 'text-sky-600' : '' }}">Tentang Kami</a>
                    <a href="{{ url('/galeri') }}" class="hover:text-sky-600 transition-colors {{ request()->is('galeri*') ? 'text-sky-600' : '' }}">Galeri</a>
                    <a href="{{ url('/pengetahuan') }}" class="hover:text-sky-600 transition-colors {{ request()->is('pengetahuan*') || request()->is('artikel*') ? 'text-sky-600' : '' }}">Pengetahuan</a>
                    <a href="{{ url('/area-layanan') }}" class="hover:text-sky-600 transition-colors {{ request()->is('area-layanan*') ? 'text-sky-600' : '' }}">Area Layanan</a>
                </nav>

                <!-- Desktop CTA Button -->
                <div class="hidden md:flex items-center">
                    <a href="{{ $whatsappUrl }}" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-2.5 bg-orange-600 hover:bg-orange-700 text-white text-sm font-bold px-5 py-2.5 rounded-full shadow-lg shadow-orange-600/25 transition-all duration-300 transform hover:-translate-y-0.5 active:translate-y-0">
                        <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24">
                            <path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/>
                        </svg>
                        <span>Hubungi Teknisi</span>
                    </a>
                </div>

                <!-- Mobile Top CTA Call Button -->
                <div class="flex items-center gap-2 md:hidden">
                    <a href="{{ $whatsappUrl }}" target="_blank" rel="noopener noreferrer" class="bg-orange-600 hover:bg-orange-700 text-white text-xs font-bold px-3 py-2 rounded-full shadow-md inline-flex items-center gap-1.5">
                        <svg class="w-3.5 h-3.5 fill-current" viewBox="0 0 24 24">
                            <path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/>
                        </svg>
                        <span>WA Kami</span>
                    </a>
                </div>
            </div>
        </div>
    </header>

    <!-- Mobile Slide-Over Sidebar Drawer (Alpine.js) -->
    <div x-cloak x-show="mobileMenuOpen" class="fixed inset-0 z-50 md:hidden" role="dialog" aria-modal="true">
        <!-- Backdrop -->
        <div x-show="mobileMenuOpen"
             x-transition:enter="transition-opacity ease-linear duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition-opacity ease-linear duration-300"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             @click="mobileMenuOpen = false"
             class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm"></div>

        <!-- Off-canvas panel -->
        <div x-show="mobileMenuOpen"
             x-transition:enter="transition ease-in-out duration-300 transform"
             x-transition:enter-start="translate-x-full"
             x-transition:enter-end="translate-x-0"
             x-transition:leave="transition ease-in-out duration-300 transform"
             x-transition:leave-start="translate-x-0"
             x-transition:leave-end="translate-x-full"
             class="fixed inset-y-0 right-0 max-w-xs w-full bg-white shadow-2xl p-6 flex flex-col justify-between overflow-y-auto">
            
            <div>
                <!-- Header inside drawer -->
                <div class="flex items-center justify-between pb-6 border-b border-slate-100">
                    <div class="flex items-center gap-2.5">
                        <div class="w-9 h-9 rounded-lg bg-sky-600 text-white flex items-center justify-center font-bold text-sm">
                            DN
                        </div>
                        <span class="font-extrabold text-slate-900 tracking-tight">DRAINUSANTARA</span>
                    </div>
                    <button @click="mobileMenuOpen = false" class="p-2 text-slate-400 hover:text-slate-600 rounded-lg focus:outline-none" aria-label="Tutup menu">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <!-- Navigation Links inside drawer -->
                <nav class="mt-6 flex flex-col space-y-1">
                    <a href="{{ url('/') }}" @click="mobileMenuOpen = false" class="flex items-center px-4 py-3 text-base font-semibold rounded-xl text-slate-700 hover:bg-slate-100 hover:text-sky-600 transition-colors">
                        Beranda
                    </a>
                    <a href="{{ url('/layanan') }}" @click="mobileMenuOpen = false" class="flex items-center px-4 py-3 text-base font-semibold rounded-xl text-slate-700 hover:bg-slate-100 hover:text-sky-600 transition-colors">
                        Layanan
                    </a>
                    <a href="{{ url('/tentang-kami') }}" @click="mobileMenuOpen = false" class="flex items-center px-4 py-3 text-base font-semibold rounded-xl text-slate-700 hover:bg-slate-100 hover:text-sky-600 transition-colors">
                        Tentang Kami
                    </a>
                    <a href="{{ url('/galeri') }}" @click="mobileMenuOpen = false" class="flex items-center px-4 py-3 text-base font-semibold rounded-xl text-slate-700 hover:bg-slate-100 hover:text-sky-600 transition-colors">
                        Galeri Dokumentasi
                    </a>
                    <a href="{{ url('/pengetahuan') }}" @click="mobileMenuOpen = false" class="flex items-center px-4 py-3 text-base font-semibold rounded-xl text-slate-700 hover:bg-slate-100 hover:text-sky-600 transition-colors">
                        Pengetahuan & Solusi
                    </a>
                    <a href="{{ url('/area-layanan') }}" @click="mobileMenuOpen = false" class="flex items-center px-4 py-3 text-base font-semibold rounded-xl text-slate-700 hover:bg-slate-100 hover:text-sky-600 transition-colors">
                        Area Layanan
                    </a>
                    <a href="{{ url('/artikel') }}" @click="mobileMenuOpen = false" class="flex items-center px-4 py-3 text-base font-semibold rounded-xl text-slate-700 hover:bg-slate-100 hover:text-sky-600 transition-colors">
                        Artikel & Edukasi
                    </a>
                </nav>
            </div>

            <!-- Bottom CTA inside drawer -->
            <div class="pt-6 border-t border-slate-100 mt-6">
                <a href="{{ $whatsappUrl }}" target="_blank" rel="noopener noreferrer" class="w-full flex items-center justify-center gap-2 bg-orange-600 hover:bg-orange-700 text-white font-bold py-3 px-4 rounded-xl shadow-lg shadow-orange-600/30 transition-colors">
                    <svg class="w-5 h-5 fill-current" viewBox="0 0 24 24">
                        <path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/>
                    </svg>
                    <span>Hubungi Teknisi 24/7</span>
                </a>
                <p class="text-xs text-center text-slate-400 mt-3">Respons cepat estimasi < 15 menit</p>
            </div>
        </div>
    </div>

    <!-- Main Content Area -->
    <main class="flex-1 pb-20 md:pb-0">
        {{ $slot ?? '' }}
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-slate-900 text-slate-300 pt-12 pb-24 md:pb-12 border-t border-slate-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8 mb-10">
                <!-- Brand Info -->
                <div class="space-y-4 md:col-span-1">
                    <div class="flex items-center gap-2">
                        <div class="w-9 h-9 rounded-lg bg-sky-600 text-white flex items-center justify-center font-bold">
                            DN
                        </div>
                        <span class="text-xl font-bold tracking-tight text-white">DRAINUSANTARA</span>
                    </div>
                    <p class="text-sm text-slate-400 leading-relaxed">
                        Jasa rooter & penanganan saluran pipa mampet profesional tanpa bongkar keramik. Dilengkapi inspeksi CCTV pipa resolusi tinggi dan garansi 30 hari.
                    </p>
                </div>

                <!-- Layanan Cepat -->
                <div>
                    <h3 class="text-sm font-semibold uppercase tracking-wider text-white mb-4">Layanan Utama</h3>
                    <ul class="space-y-2 text-sm text-slate-400">
                        <li><a href="{{ url('/layanan#wastafel') }}" class="hover:text-white transition-colors">Saluran Wastafel Mampet</a></li>
                        <li><a href="{{ url('/layanan#toilet') }}" class="hover:text-white transition-colors">Kloset & WC Tersumbat</a></li>
                        <li><a href="{{ url('/layanan#floordrain') }}" class="hover:text-white transition-colors">Floor Drain & Kamar Mandi</a></li>
                        <li><a href="{{ url('/layanan#cctv') }}" class="hover:text-white transition-colors">Inspeksi Kamera CCTV Pipa</a></li>
                    </ul>
                </div>

                <!-- Area Cakupan -->
                <div>
                    <h3 class="text-sm font-semibold uppercase tracking-wider text-white mb-4">Area Layanan</h3>
                    <div class="space-y-3 text-xs text-slate-400">
                        <div>
                            <span class="text-sky-400 font-bold block mb-1">JABODETABEK:</span>
                            <p class="leading-relaxed text-slate-300">
                                <a href="{{ url('/area/jakarta-selatan/tebet') }}" class="hover:text-white">Jakarta Selatan</a> &bull;
                                <a href="{{ url('/area/jakarta-timur/duren-sawit') }}" class="hover:text-white">Jakarta Timur</a> &bull;
                                <a href="{{ url('/area/jakarta-utara/kelapa-gading') }}" class="hover:text-white">Jakarta Utara</a> &bull;
                                <a href="{{ url('/area/jakarta-pusat/kemayoran') }}" class="hover:text-white">Jakarta Pusat</a> &bull;
                                <a href="{{ url('/area/jakarta-barat/kebon-jeruk') }}" class="hover:text-white">Jakarta Barat</a> &bull;
                                <a href="{{ url('/area/bogor/cibinong') }}" class="hover:text-white">Bogor</a> &bull;
                                <a href="{{ url('/area/depok-cinere/cinere') }}" class="hover:text-white">Depok & Cinere</a> &bull;
                                <a href="{{ url('/area/tangerang-kota/cipondoh') }}" class="hover:text-white">Tangerang Kota</a> &bull;
                                <a href="{{ url('/area/tangerang-selatan/serpong') }}" class="hover:text-white">Tangerang Selatan</a> &bull;
                                <a href="{{ url('/area/bekasi-cikarang/cikarang-selatan') }}" class="hover:text-white">Bekasi & Cikarang</a>
                            </p>
                        </div>
                        <div class="pt-1 border-t border-slate-800">
                            <span class="text-sky-400 font-bold block mb-1">SEMARANG & LAMPUNG:</span>
                            <p class="leading-relaxed text-slate-300">
                                <a href="{{ url('/area/semarang/candisari') }}" class="hover:text-white">Kota Semarang</a> &bull;
                                <a href="{{ url('/area/bandar-lampung/kedaton') }}" class="hover:text-white">Bandar Lampung</a>
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Kontak & Garansi -->
                <div>
                    <h3 class="text-sm font-semibold uppercase tracking-wider text-white mb-4">Hotline Siaga</h3>
                    <p class="text-xs text-slate-400 mb-3">Siap melayani rumah tinggal, ruko, restoran, cafe, hotel, dan kantor.</p>
                    <a href="{{ $whatsappUrl }}" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-2 bg-orange-600 hover:bg-orange-700 text-white font-bold text-sm px-4 py-2.5 rounded-lg shadow-md transition-colors">
                        <span>Konsultasi WhatsApp</span>
                    </a>
                </div>
            </div>

            <div class="pt-8 border-t border-slate-800 text-center text-xs text-slate-500">
                <p>&copy; {{ date('Y') }} Drainusantara. Seluruh hak cipta dilindungi. Solusi Saluran Tanpa Bongkar & Tanpa Soda Api.</p>
            </div>
        </div>
    </footer>

    <!-- Fixed Bottom Navigation Bar for Mobile (Mobile-First) -->
    <nav class="fixed bottom-0 left-0 right-0 z-40 bg-white/98 backdrop-blur-lg border-t border-slate-200 shadow-[0_-4px_20px_rgba(0,0,0,0.06)] md:hidden">
        <div class="grid grid-cols-5 h-16 items-center px-1 max-w-lg mx-auto relative">
            <!-- 1. Beranda -->
            <a href="{{ url('/') }}" class="flex flex-col items-center justify-center py-1 text-xs font-medium {{ request()->is('/') ? 'text-sky-600 font-bold' : 'text-slate-600 hover:text-sky-600' }} transition-colors">
                <svg class="w-5 h-5 mb-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                </svg>
                <span>Beranda</span>
            </a>

            <!-- 2. Layanan -->
            <a href="{{ url('/layanan') }}" class="flex flex-col items-center justify-center py-1 text-xs font-medium {{ request()->is('layanan*') ? 'text-sky-600 font-bold' : 'text-slate-600 hover:text-sky-600' }} transition-colors">
                <svg class="w-5 h-5 mb-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
                <span>Layanan</span>
            </a>

            <!-- 3. Prominent Central WhatsApp Button -->
            <div class="relative flex justify-center items-center">
                <a href="{{ $whatsappUrl }}" target="_blank" rel="noopener noreferrer" class="absolute -top-5 w-14 h-14 bg-orange-600 hover:bg-orange-700 rounded-full flex flex-col items-center justify-center text-white shadow-lg shadow-orange-600/40 ring-4 ring-white active:scale-95 transition-all duration-200" aria-label="Hubungi WhatsApp Teknisi">
                    <svg class="w-7 h-7 fill-current" viewBox="0 0 24 24">
                        <path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/>
                    </svg>
                </a>
            </div>

            <!-- 4. Artikel -->
            <a href="{{ url('/artikel') }}" class="flex flex-col items-center justify-center py-1 text-xs font-medium {{ request()->is('artikel*') || request()->is('pengetahuan*') ? 'text-sky-600 font-bold' : 'text-slate-600 hover:text-sky-600' }} transition-colors">
                <svg class="w-5 h-5 mb-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />
                </svg>
                <span>Artikel</span>
            </a>

            <!-- 5. Hamburger Menu -->
            <button @click="mobileMenuOpen = !mobileMenuOpen" type="button" class="flex flex-col items-center justify-center py-1 text-xs font-medium text-slate-600 hover:text-sky-600 focus:outline-none transition-colors" aria-label="Buka menu navigasi">
                <svg class="w-5 h-5 mb-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
                <span>Menu</span>
            </button>
        </div>
    </nav>

    @stack('scripts')

    <!-- Simple On-Scroll Animation Observer -->
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
                    rootMargin: '0px 0px -30px 0px',
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
