<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {!! SEO::generate() !!}

    <!-- Search Engine Crawler Bots -->
    <meta name="googlebot" content="index, follow, max-snippet:-1, max-image-preview:large, max-video-preview:-1">
    <meta name="bingbot" content="index, follow, max-snippet:-1, max-image-preview:large, max-video-preview:-1">
    <meta name="yandex" content="index, follow">

    <!-- Browser, Mobile OS & Progressive Display -->
    <meta name="theme-color" content="#0369a1" media="(prefers-color-scheme: light)">
    <meta name="theme-color" content="#0f172a" media="(prefers-color-scheme: dark)">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="default">
    <meta name="apple-mobile-web-app-title" content="Drainusantara">
    <meta name="application-name" content="Drainusantara">
    <meta name="msapplication-TileColor" content="#0369a1">
    <meta name="format-detection" content="telephone=no">

    <!-- Geo-Location standard Indonesia -->
    <meta name="geo.region" content="ID">
    <meta name="geo.placename" content="Indonesia">
    <meta name="geo.position" content="-6.2088;106.8456">
    <meta name="ICBM" content="-6.2088, 106.8456">

    <!-- Favicon & Web Icon -->
    <link rel="icon" type="image/webp" href="{{ asset('images/logo/WebIcon.webp') }}">
    <link rel="apple-touch-icon" href="{{ asset('images/logo/WebIcon.webp') }}">
    <link rel="manifest" href="{{ asset('site.webmanifest') }}">

    <!-- Machine-Readable AI Agent Discovery (ARD v1.0) -->
    <link rel="ai-catalog" type="application/json" href="{{ url('/.well-known/ai-catalog.json') }}" title="Drainusantara AI Agent Resource Catalog">
    <link rel="agentmap" href="{{ url('/.well-known/ai-catalog.json') }}">

    <link rel="preload" as="font" href="{{ asset('fonts/plus-jakarta-sans-latin.woff2') }}" type="font/woff2" crossorigin>

    <!-- Preconnect & DNS-Prefetch for Third-Party Analytics and WhatsApp Dispatch -->
    <link rel="preconnect" href="https://www.googletagmanager.com" crossorigin>
    <link rel="dns-prefetch" href="https://www.googletagmanager.com">
    <link rel="preconnect" href="https://wa.me" crossorigin>
    <link rel="dns-prefetch" href="https://wa.me">

    <!-- Preload Critical LCP Hero Image (WebP) -->
    @if(request()->routeIs('home'))
    <link rel="preload" as="image" href="{{ asset('images/drainusantara-jasa-saluran-pipa-mampet-teknisi-profesional-mobile.webp') }}" type="image/webp" media="(max-width: 640px)" fetchpriority="high">
    <link rel="preload" as="image" href="{{ asset('images/drainusantara-jasa-saluran-pipa-mampet-teknisi-profesional.webp') }}" type="image/webp" media="(min-width: 641px)" fetchpriority="high">
    @endif

    <!-- Global Application State Data (Lightweight, Non-blocking) -->
    <script>
        window.__DRAINUSANTARA_WA__ = "{{ config('app.whatsapp_number') ?: '6285609009009' }}";
        window.__DRAINUSANTARA_DYNAMIC_WA_URL__ = "{{ $contextualWaUrl ?? 'https://wa.me/6285609009009' }}";
        window.__DRAINUSANTARA_CONTEXTUAL_WA_MSG__ = {!! json_encode($contextualWaMsg ?? 'Halo Admin Drainusantara, saluran air di rumah saya sedang mampet. Mohon info teknisi terdekat.') !!};
        window.dataLayer = window.dataLayer || [];
        window.dataLayer.push({
            event: 'page_context_ready',
            page_title: document.title,
            current_path: '{{ request()->path() }}'
        });
    </script>

    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-VN5KHRRZ1D"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());

        gtag('config', 'G-VN5KHRRZ1D');
    </script>

    @if(config('services.gtm.id'))
    <!-- Google Tag Manager -->
    <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
    new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
    j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
    'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
    })(window,document,'script','dataLayer','{{ config('services.gtm.id') }}');</script>
    <!-- End Google Tag Manager -->
    @endif
    <script type="application/json" id="drainusantara-webmcp-data">
        {!! json_encode([
            'services' => ($navServices ?? collect())->map(fn ($s) => [
                'name' => $s->name,
                'slug' => $s->slug,
                'short_description' => $s->short_description,
                'price_starting_from' => (int) $s->price_starting_from,
            ])->values()->all(),
            'whatsappNumber' => config('app.whatsapp_number') ?: '6285609009009',
            'baseUrl' => url('/'),
        ], JSON_UNESCAPED_UNICODE | JSON_HEX_TAG) !!}
    </script>

    <!-- Vite Assets (Compiled Tailwind CSS & Alpine.js Bundle) -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <noscript>
        <style>
            .reveal-soft, .reveal-fade, .reveal-scale, .fade-up, .fade-in, .zoom-in {
                opacity: 1 !important;
                transform: none !important;
            }
        </style>
    </noscript>

    <style>
        [x-cloak] { display: none !important; }
        dialog:not([open]) { display: none !important; }

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
    @stack('head')
</head>
<body class="bg-slate-50 text-slate-800 font-sans antialiased min-h-screen flex flex-col"
      x-data="layoutData"
      @keydown.escape.window="activeMenu = null; sidebarOpen = false; mobileSearchOpen = false">

    @if(config('services.gtm.id'))
    <!-- Google Tag Manager (noscript) -->
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id={{ config('services.gtm.id') }}"
    height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->
    @endif

    <a href="#main-content" 
       class="sr-only focus:not-sr-only focus:fixed focus:top-4 focus:left-4 focus:z-[9999] focus:px-4 focus:py-2.5 focus:bg-slate-900 focus:text-white focus:text-xs focus:font-bold focus:rounded-lg focus:shadow-xl focus:ring-2 focus:ring-sky-500 focus:outline-hidden">
        Lewati ke Konten Utama
    </a>

    <x-layout.navbar />
    <x-layout.search-modal />
    <x-conversion.quick-quote-modal />
    <x-layout.mobile-drawer />

    {{-- Main content area (cleared from mobile dock gap; dock clearance handled by footer) --}}
    <main id="main-content" tabindex="-1" class="flex-1 focus:outline-hidden">
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
