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
    <script type="application/json" id="drainusantara-webmcp-data">
        {!! json_encode([
            'services' => ($navServices ?? collect())->map(fn ($s) => [
                'name' => $s->name,
                'slug' => $s->slug,
                'short_description' => $s->short_description,
                'price_starting_from' => (int) $s->price_starting_from,
            ])->values()->all(),
            'whatsappNumber' => config('app.whatsapp_number') ?: '6281234567890',
            'baseUrl' => url('/'),
        ], JSON_UNESCAPED_UNICODE | JSON_HEX_TAG) !!}
    </script>

    <!-- Vite Assets (Compiled Tailwind CSS & Alpine.js Bundle) -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Google Fonts (Asynchronous & Non-render-blocking) -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" media="print" onload="this.media='all'">
    <noscript>
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap">
        <style>
            .reveal-soft, .reveal-fade, .reveal-scale, .fade-up, .fade-in, .zoom-in {
                opacity: 1 !important;
                transform: none !important;
            }
        </style>
    </noscript>

    <style>
        [x-cloak] { display: none !important; }

        @media (prefers-reduced-motion: reduce) {
            .reveal-soft, .reveal-fade, .reveal-scale, .fade-up, .fade-in, .zoom-in, .card-lift, .btn-press, .mobile-nav-dock {
                opacity: 1 !important;
                transform: none !important;
                transition: none !important;
                animation: none !important;
            }
        }
    </style>

    @stack('styles')
</head>
<body class="bg-slate-50 text-slate-800 font-sans antialiased min-h-screen flex flex-col"
      x-data="layoutData"
      @keydown.escape.window="activeMenu = null; sidebarOpen = false; mobileSearchOpen = false">

    <a href="#main-content" 
       class="sr-only focus:not-sr-only focus:fixed focus:top-4 focus:left-4 focus:z-[9999] focus:px-4 focus:py-2.5 focus:bg-slate-900 focus:text-white focus:text-xs focus:font-bold focus:rounded-lg focus:shadow-xl focus:ring-2 focus:ring-sky-500 focus:outline-hidden">
        Lewati ke Konten Utama
    </a>

    <x-layout.navbar />
    <x-layout.search-modal />
    <x-layout.mobile-drawer />

    {{-- Bottom padding on mobile prevents fixed nav dock from covering content --}}
    <main id="main-content" tabindex="-1" class="flex-1 pb-24 md:pb-0 focus:outline-hidden">
        {{ $slot ?? '' }}
        @yield('content')
    </main>

    <x-layout.footer />
    <x-layout.mobile-dock />

    @stack('scripts')

    <!-- Scroll Visibility Observer (Smooth & Dynamic Entrance) -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const animatedElements = document.querySelectorAll('.reveal-soft, .reveal-fade, .reveal-scale, .fade-up, .fade-in, .zoom-in');
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
                    threshold: 0.05
                });

                // Frame tick ensures browser renders initial state then smoothly transitions in-view elements
                requestAnimationFrame(() => {
                    setTimeout(() => {
                        animatedElements.forEach(el => observer.observe(el));
                    }, 40);
                });
            } else {
                animatedElements.forEach(el => el.classList.add('is-visible'));
            }
        });
    </script>
</body>
</html>
