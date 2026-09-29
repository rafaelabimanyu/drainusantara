@php
    $whatsappNumber = config('app.whatsapp_number') ?: '6281234567890';
    $generalWaText = urlencode("Halo Admin Drainusantara, saya ingin berkonsultasi mengenai layanan penanganan saluran pipa.");
    $generalWaUrl = "https://wa.me/{$whatsappNumber}?text={$generalWaText}";

    $tabs = [
        [
            'title' => 'Profil Perusahaan',
            'url' => route('about.profile'),
            'active' => request()->routeIs('about.profile') || (request()->routeIs('about') && !request()->routeIs('about.*')),
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
            'title' => 'Klien & Portofolio',
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

    // Pemilihan Foto Background Sesuai Halaman (Bisa disetel manual via 'bgImage' atau otomatis)
    $resolvedBgImage = $bgImage ?? null;
    if (!$resolvedBgImage) {
        if (request()->routeIs('about.holding')) {
            // Foto 1: Halaman Struktur Holding J&J Group
            $resolvedBgImage = asset('assets/banner/Drainusantara-jasa-saluran-mampet-profesional-desktop.webp');
        } elseif (request()->routeIs('about.profile') || (request()->routeIs('about') && !request()->routeIs('about.*'))) {
            // Foto 2: Halaman Profil Perusahaan
            $resolvedBgImage = asset('images/dokumentasi/proses-pelancaran-gutter-restoran-jakarta.webp');
        } elseif (request()->routeIs('about.k3')) {
            $resolvedBgImage = asset('assets/TOOLKIT/inspeksi-cctv-set-lengkap-rootera.webp');
        } elseif (request()->routeIs('about.equipment')) {
            $resolvedBgImage = asset('assets/TOOLKIT/mesin-rooter-ridgid-k50-spiral-baja.webp');
        } elseif (request()->routeIs('about.portfolio')) {
            $resolvedBgImage = asset('images/dokumentasi/proses-pelancaran-gutter-restoran-jakarta.webp');
        } else {
            $resolvedBgImage = asset('assets/banner/Drainusantara-jasa-saluran-mampet-profesional-desktop.webp');
        }
    }
@endphp

<!-- ====================================================================
     BREADCRUMB & HEADER SECTION DENGAN BACKGROUND FOTO
==================================================================== -->
<section class="relative bg-slate-900 border-b border-slate-800 pt-8 pb-6 lg:pt-12 lg:pb-8 overflow-hidden text-white">
    @if(!empty($resolvedBgImage))
        <div class="absolute inset-0 z-0">
            <img src="{{ $resolvedBgImage }}" 
                 alt="{{ $heading ?? 'Tentang Drainusantara' }}" 
                 class="w-full h-full object-cover object-center filter brightness-90"
                 loading="eager"
                 decoding="async">
            <!-- Overlay gelap tergradasi untuk menjamin kontras WCAG AA teks tetap tajam -->
            <div class="absolute inset-0 bg-gradient-to-r from-slate-950/95 via-slate-950/85 to-slate-900/80"></div>
        </div>
    @endif

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        
        <!-- Breadcrumb Nav -->
        <nav class="flex items-center gap-2 text-xs text-slate-300 mb-4 font-medium" aria-label="Breadcrumb">
            <a href="{{ route('home') }}" class="hover:text-white transition-colors">Beranda</a>
            <svg class="w-3.5 h-3.5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
            </svg>
            <a href="{{ route('about') }}" class="hover:text-white transition-colors">Tentang Kami</a>
            <svg class="w-3.5 h-3.5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
            </svg>
            <span class="text-white font-semibold">{{ $activeTitle ?? 'Profil' }}</span>
        </nav>

        <div class="flex flex-col lg:flex-row lg:items-end justify-between gap-6">
            <div class="max-w-3xl">
                <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-sky-950/80 border border-sky-500/40 text-sky-300 text-xs font-bold rounded-md uppercase tracking-wider mb-2.5">
                    {{ $eyebrow ?? 'Tentang Drainusantara' }}
                </span>
                <h1 class="text-2xl sm:text-3xl lg:text-4xl font-extrabold text-white tracking-tight leading-tight">
                    {{ $heading ?? 'Profil Korporat & Standar Pelayanan Pipa' }}
                </h1>
                <p class="text-slate-300 text-sm sm:text-base mt-2.5 leading-relaxed">
                    {{ $subheading ?? 'Standar pengerjaan mekanis pipa mampet tanpa bongkar keramik bergaransi 30 hari kalender.' }}
                </p>
            </div>
            <div class="shrink-0">
                <a href="{{ $generalWaUrl }}" 
                   target="_blank" 
                   rel="noopener noreferrer" 
                   class="btn-press inline-flex items-center gap-2 px-5 py-3 rounded-lg bg-emerald-600 hover:bg-emerald-700 active:bg-emerald-800 text-white font-bold text-xs shadow-xs transition-colors min-h-[44px]">
                    <svg class="w-4 h-4 fill-current shrink-0" viewBox="0 0 24 24">
                        <path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/>
                    </svg>
                    <span>Konsultasi Bebas Biaya</span>
                </a>
            </div>
        </div>

        <!-- Secondary Sub-Navigation Tabs (Dark Style with High Contrast) -->
        <div class="mt-6 pt-4 border-t border-slate-800/80">
            <div class="flex items-center gap-1.5 overflow-x-auto no-scrollbar pb-1 text-xs">
                @foreach($tabs as $tab)
                    <a href="{{ $tab['url'] }}" 
                       class="px-4 py-2.5 rounded-lg transition-colors shrink-0 min-h-[44px] inline-flex items-center font-semibold {{ $tab['active'] ? 'bg-sky-600 text-white font-bold shadow-xs' : 'bg-slate-900/80 hover:bg-slate-800 text-slate-300 hover:text-white border border-slate-800' }}">
                        {{ $tab['title'] }}
                    </a>
                @endforeach
            </div>
        </div>

    </div>
</section>
