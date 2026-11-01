@props([
    'activeTitle' => 'Profil',
    'eyebrow' => 'Tentang Drainusantara',
    'heading' => 'Profil Korporat & Standar Pelayanan Pipa',
    'subheading' => 'Standar pengerjaan mekanis pipa mampet tanpa bongkar keramik bergaransi 30 hari kalender.',
    'bgImage' => null
])

@php
    $tabs = [
        [
            'title' => 'Profil Perusahaan',
            'url' => route('about.profile'),
            'active' => request()->routeIs('about.profile') || (request()->routeIs('about') && !request()->routeIs('about.*')),
        ],
        [
            'title' => 'Cara Kerja',
            'url' => route('how-it-works'),
            'active' => request()->routeIs('how-it-works') || request()->is('cara-kerja*') || request()->is('proses-kerja*'),
        ],
        [
            'title' => 'Struktur Holding',
            'url' => route('about.holding'),
            'active' => request()->routeIs('about.holding'),
        ],
        [
            'title' => 'SOP K3',
            'url' => route('about.k3'),
            'active' => request()->routeIs('about.k3'),
        ],
        [
            'title' => 'Peralatan & Teknologi',
            'url' => route('about.equipment'),
            'active' => request()->routeIs('about.equipment'),
        ],
        [
            'title' => 'Kemitraan',
            'url' => route('about.portfolio'),
            'active' => request()->routeIs('about.portfolio'),
        ],
        [
            'title' => 'Ketentuan Garansi',
            'url' => route('about.warranty'),
            'active' => request()->routeIs('about.warranty'),
        ],
        [
            'title' => 'FAQ',
            'url' => route('about.faq'),
            'active' => request()->routeIs('about.faq'),
        ],
    ];

    $resolvedBgImage = $bgImage;
    if (!$resolvedBgImage) {
        if (request()->routeIs('about.holding')) {
            $resolvedBgImage = asset('assets/banner/hero-JnJ-drainusantara.webp');
        } elseif (request()->routeIs('about.profile') || (request()->routeIs('about') && !request()->routeIs('about.*'))) {
            $resolvedBgImage = asset('assets/banner/hero-profil-perusahaan-drainusantara.webp');
        } elseif (request()->routeIs('how-it-works') || request()->is('cara-kerja*') || request()->is('proses-kerja*')) {
            $resolvedBgImage = asset('assets/banner/hero-peralatan-drainusantara.webp');
        } elseif (request()->routeIs('about.k3')) {
            $resolvedBgImage = asset('assets/banner/hero-k3-drainusantara.webp');
        } elseif (request()->routeIs('about.equipment')) {
            $resolvedBgImage = asset('assets/banner/hero-peralatan-drainusantara.webp');
        } elseif (request()->routeIs('about.portfolio')) {
            $resolvedBgImage = asset('assets/banner/hero-portofolio.webp');
        } else {
            $resolvedBgImage = asset('assets/banner/hero-profil-perusahaan-drainusantara.webp');
        }
    }
@endphp

<section class="relative bg-slate-900 border-b border-slate-800 pt-8 pb-6 lg:pt-12 lg:pb-8 overflow-hidden text-white">
    @if(!empty($resolvedBgImage))
        <div class="absolute inset-0 z-0">
            <img src="{{ $resolvedBgImage }}" 
                 alt="{{ $heading }}" 
                 class="w-full h-full object-cover object-center filter brightness-90"
                 loading="eager"
                 decoding="async">
            <!-- Overlay gelap tergradasi untuk menjamin kontras WCAG AA teks tetap tajam -->
            <div class="absolute inset-0 bg-gradient-to-r from-slate-950/95 via-slate-950/85 to-slate-900/80"></div>
        </div>
    @endif

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        
        <!-- Breadcrumb Nav -->
        <nav class="flex items-center gap-2 text-xs text-slate-300 mb-4 font-medium reveal-fade" aria-label="Breadcrumb">
            <a href="{{ route('home') }}" class="hover:text-white transition-colors">Beranda</a>
            <svg class="w-3.5 h-3.5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
            </svg>
            <a href="{{ route('about') }}" class="hover:text-white transition-colors">Tentang Kami</a>
            <svg class="w-3.5 h-3.5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
            </svg>
            <span class="text-white font-semibold">{{ $activeTitle }}</span>
        </nav>

        <div class="max-w-4xl">
            <div class="inline-flex items-center gap-2 px-2.5 py-1 rounded-md bg-sky-950/70 border border-sky-500/30 text-sky-300 text-xs font-semibold mb-3 reveal-fade">
                <span>{{ $eyebrow }}</span>
            </div>
            <h1 class="text-2xl sm:text-3xl lg:text-4xl font-extrabold text-white tracking-tight leading-tight reveal-soft">
                {{ $heading }}
            </h1>
            <p class="text-slate-300 text-sm sm:text-base mt-3 leading-relaxed reveal-soft delay-100 max-w-3xl">
                {{ $subheading }}
            </p>

            <!-- Corporate Credibility Badges -->
            <div class="flex flex-wrap items-center gap-2.5 pt-4 text-xs reveal-soft delay-150">
                <div class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-md bg-slate-900/90 border border-slate-700/80 text-slate-200">
                    <svg class="w-3.5 h-3.5 text-sky-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <span class="font-medium">Legalitas NIB OSS &amp; e-Faktur PPN</span>
                </div>
                <div class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-md bg-slate-900/90 border border-slate-700/80 text-slate-200">
                    <svg class="w-3.5 h-3.5 text-sky-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                    <span class="font-medium">Ekosistem Holding J&amp;J Group</span>
                </div>
                <div class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-md bg-slate-900/90 border border-slate-700/80 text-slate-200">
                    <svg class="w-3.5 h-3.5 text-sky-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                    <span class="font-medium">100% Standar Non-Destruktif</span>
                </div>
            </div>
        </div>

        <!-- Secondary Sub-Navigation Tabs (Dark Style with High Contrast) -->
        <div class="mt-6 pt-4 border-t border-slate-800/80 reveal-soft delay-150">
            <div class="flex items-center gap-1.5 overflow-x-auto no-scrollbar pb-1 text-xs">
                @foreach($tabs as $tab)
                    <a href="{{ $tab['url'] }}" 
                       class="px-4 py-2.5 rounded-lg transition-colors shrink-0 min-h-[44px] inline-flex items-center font-semibold {{ $tab['active'] ? 'bg-sky-700 text-white font-bold shadow-xs' : 'bg-slate-900/80 hover:bg-slate-800 text-slate-300 hover:text-white border border-slate-800' }}">
                        {{ $tab['title'] }}
                    </a>
                @endforeach
            </div>

            @if(request()->routeIs('how-it-works') || request()->is('cara-kerja*') || request()->is('proses-kerja*'))
            <!-- Section Pintas Langkah Proses Pengerjaan (Clean, No Slop) -->
            <div class="mt-3 pt-3 border-t border-slate-800/60 flex items-center gap-1.5 overflow-x-auto no-scrollbar text-xs">
                <span class="text-sky-400 font-bold shrink-0 uppercase tracking-wider text-[11px] mr-1">Tahapan:</span>
                <a href="#langkah-1" class="shrink-0 px-3 py-1.5 rounded-md bg-slate-800/90 hover:bg-slate-700 text-slate-200 hover:text-white border border-slate-700/60 transition-colors">1. Diagnosa CCTV</a>
                <a href="#langkah-2" class="shrink-0 px-3 py-1.5 rounded-md bg-slate-800/90 hover:bg-slate-700 text-slate-200 hover:text-white border border-slate-700/60 transition-colors">2. Rotary Spiral</a>
                <a href="#langkah-3" class="shrink-0 px-3 py-1.5 rounded-md bg-slate-800/90 hover:bg-slate-700 text-slate-200 hover:text-white border border-slate-700/60 transition-colors">3. Ekstraksi Lemak</a>
                <a href="#langkah-4" class="shrink-0 px-3 py-1.5 rounded-md bg-slate-800/90 hover:bg-slate-700 text-slate-200 hover:text-white border border-slate-700/60 transition-colors">4. Flushing Air</a>
                <a href="#langkah-5" class="shrink-0 px-3 py-1.5 rounded-md bg-slate-800/90 hover:bg-slate-700 text-slate-200 hover:text-white border border-slate-700/60 transition-colors">5. Uji &amp; Garansi 30 Hari</a>
            </div>
            @endif
        </div>

    </div>
</section>
