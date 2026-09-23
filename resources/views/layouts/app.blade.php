<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {!! SEO::generate() !!}

    <!-- Local SEO & Geo-Targeting Identifiers (W3C & Google Local) -->
    <meta name="geo.region" content="ID-JK" />
    <meta name="geo.placename" content="Jakarta Timur" />
    <meta name="geo.position" content="-6.225014;106.900447" />
    <meta name="ICBM" content="-6.225014, 106.900447" />
    <meta name="city" content="Jakarta Timur" />
    <meta name="country" content="Indonesia" />

    <!-- Schema.org Plumber & Local Business Rich Snippets -->
    @include('partials.seo.schema-plumber')

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

        /* Subtle Pulse for Conversion WhatsApp Dock CTA */
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
<body class="bg-slate-50 text-slate-800 font-sans antialiased min-h-screen flex flex-col selection:bg-blue-600 selection:text-white"
      x-data="layoutData"
      @keydown.escape.window="activeMenu = null; sidebarOpen = false; mobileSearchOpen = false">

    <!-- Modular Layout Partials: Header, Mega Menus, Modals, Drawer -->
    @include('layouts.partials.header')
    @include('layouts.partials.mobile-search-modal')
    @include('layouts.partials.mobile-drawer')

    <!-- Main Content Slot -->
    <main class="flex-1 pb-24 md:pb-0">
        {{ $slot ?? '' }}
        @yield('content')
    </main>

    <!-- Modular Layout Partials: Footer & Mobile Dock -->
    @include('layouts.partials.footer')
    @include('layouts.partials.mobile-dock')

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
