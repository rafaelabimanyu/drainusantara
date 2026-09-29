@extends('layouts.app')

@section('content')
@php
    $whatsappNumber = config('app.whatsapp_number') ?: '6281234567890';
    $portfolioList = (isset($portfolios) && $portfolios->isNotEmpty())
        ? $portfolios 
        : \App\Models\Portfolio::where('is_active', true)->orderBy('order')->get();

    // Fallback data default identik dengan landing page jika database CMS masih kosong
    
@endphp

@include('about.partials.nav', [
    'activeTitle' => 'Klien & Portofolio',
    'eyebrow' => 'Perusahaan Yang Menggunakan Jasa Kami',
    'heading' => 'Dipercaya Restoran F&B, Perhotelan & Gedung Komersial',
    'subheading' => 'Bukti nyata penanganan profesional pembersihan pipa pembuangan dan grease trap bagi mitra bisnis tanpa mengganggu jam operasional.',
    'bgImage' => asset('images/dokumentasi/proses-pelancaran-gutter-restoran-jakarta.webp')
])

<!-- Main Portfolio Content -->
<section id="portofolio-page" class="py-16 lg:py-20 bg-slate-50 border-b border-slate-200" x-data="{ activeCategory: 'all' }">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Showcase Anchor Banner to Homepage Section -->
        <div class="mb-10 p-5 bg-white border border-sky-200 rounded-xl shadow-2xs flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div class="flex items-center gap-3.5">
                <div class="w-10 h-10 rounded-lg bg-sky-50 text-sky-700 border border-sky-100 flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                    </svg>
                </div>
                <div>
                    <h3 class="text-sm sm:text-base font-bold text-slate-900">Showcase Interaktif di Beranda</h3>
                    <p class="text-xs text-slate-600 mt-0.5">Lihat slider carousel rekam jejak B2B dan penanganan pipa komersial yang terhubung langsung dengan sistem beranda.</p>
                </div>
            </div>
            <a href="{{ url('/#portofolio-b2b') }}" class="btn-press shrink-0 inline-flex items-center justify-center gap-2 px-5 py-2.5 bg-sky-700 hover:bg-sky-800 text-white text-xs font-bold rounded-lg transition-colors shadow-2xs min-h-[44px]">
                <span>Buka Bagian B2B di Beranda</span>
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                </svg>
            </a>
        </div>

        <div class="max-w-3xl mb-10">
            <span class="text-xs font-bold uppercase tracking-wider text-sky-700 block mb-2">
                CMS Portofolio Resmi
            </span>
            <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">
                Portofolio Penanganan Saluran Komersial &amp; Residensial
            </h2>
            <p class="text-slate-600 text-sm sm:text-base mt-3 leading-relaxed">
                Dari dapur komersial restoran mall hingga gedung perhotelan berbintang, teknisi Drainusantara terbiasa bekerja di bawah standar kepatuhan operasional tinggi, higienis, dan bergaransi resmi.
            </p>
        </div>

        <!-- Portfolio Cards Grid & Mobile Carousel -->
        <div x-data="{
                 active: 0,
                 total: {{ count($portfolioList) }},
                 timer: null,
                 init() {
                     if (typeof window === 'undefined') return;
                     if (window.innerWidth < 768) {
                         this.startAuto();
                     }
                 },
                 startAuto() {
                     if (this.total <= 1 || window.innerWidth >= 768) return;
                     this.pause();
                     this.timer = setInterval(() => { this.next(); }, 4000);
                 },
                 pause() {
                     if (this.timer) {
                         clearInterval(this.timer);
                         this.timer = null;
                     }
                 },
                 resume() {
                     if (window.innerWidth >= 768) return;
                     this.startAuto();
                 },
                 next() {
                     this.goTo((this.active + 1) % this.total);
                 },
                 goTo(idx) {
                     this.active = idx;
                     const slider = this.$refs.portfolioSlider;
                     if (slider && slider.children[idx]) {
                         slider.scrollTo({
                             left: slider.children[idx].offsetLeft - slider.offsetLeft,
                             behavior: 'smooth'
                         });
                     }
                 },
                 onScroll() {
                     const slider = this.$refs.portfolioSlider;
                     if (!slider || !slider.firstElementChild) return;
                     const cardWidth = slider.firstElementChild.offsetWidth + 20;
                     this.active = Math.min(this.total - 1, Math.max(0, Math.round(slider.scrollLeft / cardWidth)));
                 }
             }" 
             class="mb-14">
            
            <div x-ref="portfolioSlider"
                 @scroll.passive="onScroll()"
                 @touchstart="pause()"
                 @touchend="resume()"
                 @mouseenter="pause()"
                 @mouseleave="resume()"
                 class="flex overflow-x-auto snap-x snap-mandatory no-scrollbar gap-5 pb-4 pt-1 px-1 -mx-4 sm:mx-0 sm:px-0 md:grid md:grid-cols-2 lg:grid-cols-3 md:gap-6 lg:gap-8 md:overflow-visible md:pb-0">
                @foreach($portfolioList as $project)
                    @php
                        $waText = urlencode("Halo Tim Drainusantara, saya tertarik dengan portofolio '{$project->project_title}' untuk tempat usaha saya ({$project->client_name}). Mohon informasi konsultasi B2B.");
                        $waUrl = "https://wa.me/{$whatsappNumber}?text={$waText}";
                    @endphp
                    <div class="w-[85vw] sm:w-[360px] md:w-auto shrink-0 snap-center relative rounded-xl border border-slate-700/50 overflow-hidden min-h-[360px] sm:min-h-[380px] flex flex-col justify-between p-6 group transition-all duration-300 hover:border-sky-400/80 shadow-md card-lift">
                        <!-- Background Photo with Subtle Blur & Clear Visibility -->
                        <div class="absolute inset-0 z-0 overflow-hidden pointer-events-none">
                            <img src="{{ $project->image ?: 'https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?auto=format&fit=crop&w=800&q=80' }}" 
                                 alt="{{ $project->client_name }}" 
                                 loading="lazy"
                                 decoding="async"
                                 class="w-full h-full object-cover blur-[1px] scale-105 brightness-[0.92] group-hover:scale-110 transition-transform duration-700"
                                 onerror="this.onerror=null; this.src='https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?auto=format&fit=crop&w=800&q=80';">
                            <!-- Gradient Overlay: Transparent at top so the photo is recognizable, dark at bottom for crisp text contrast -->
                            <div class="absolute inset-0 bg-gradient-to-t from-slate-950 via-slate-950/75 via-55% to-slate-950/25"></div>
                        </div>

                        <!-- Content Relative z-10 -->
                        <div class="relative z-10">
                            <!-- Top Meta: Sector Badge & Location -->
                            <div class="flex items-center justify-between gap-2 mb-4">
                                <span class="inline-flex items-center px-2.5 py-1 bg-slate-900/85 backdrop-blur-xs text-sky-300 text-[11px] font-bold rounded-md border border-slate-700/70">
                                    {{ $project->client_type ?? 'Komersial B2B' }}
                                </span>
                                @if(!empty($project->location))
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 bg-slate-900/85 backdrop-blur-xs text-slate-200 text-[11px] font-medium rounded-md border border-slate-700/70 truncate max-w-[170px]">
                                    <svg class="w-3 h-3 text-sky-400 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    </svg>
                                    <span class="truncate">{{ $project->location }}</span>
                                </span>
                                @endif
                            </div>

                            <!-- Client Name -->
                            <h3 class="text-lg sm:text-xl font-bold text-white tracking-tight line-clamp-1 mb-1 group-hover:text-sky-300 transition-colors drop-shadow-xs">
                                {{ $project->client_name }}
                            </h3>

                            <!-- Project Title -->
                            <div class="text-xs font-semibold text-sky-400/90 mb-3 drop-shadow-2xs">
                                {{ $project->project_title }}
                            </div>

                            <!-- Description -->
                            <p class="text-xs sm:text-sm text-slate-200/90 leading-relaxed line-clamp-3">
                                {{ $project->description }}
                            </p>
                        </div>

                        <!-- Bottom Bar: Guarantee & WhatsApp Action -->
                        <div class="relative z-10 mt-5 pt-3.5 border-t border-white/15 flex items-center justify-between gap-3 text-xs">
                            <span class="inline-flex items-center gap-1.5 font-bold text-emerald-400">
                                <svg class="w-3.5 h-3.5 text-emerald-400" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                </svg>
                                <span>{{ $project->guarantee ?? 'Garansi Resmi 30 Hari' }}</span>
                            </span>
                            <a href="{{ $waUrl }}" 
                               target="_blank" 
                               rel="noopener noreferrer" 
                               class="btn-press text-[11px] font-semibold text-white bg-sky-600/90 hover:bg-sky-500 px-2.5 py-1.5 rounded border border-sky-400/40 inline-flex items-center gap-1 transition-colors min-h-[36px]">
                                <span>Tanya Kasus</span>
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                                </svg>
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Mobile Carousel Dots Indicator -->
            <div class="flex md:hidden justify-center items-center gap-1.5 mt-5">
                @foreach($portfolioList as $idx => $item)
                    <button type="button" 
                            @click="goTo({{ $idx }})"
                            class="h-2 rounded-full transition-all duration-300 ease-out cursor-pointer active:scale-75"
                            :class="active === {{ $idx }} ? 'w-6 bg-sky-700' : 'w-2 bg-slate-300 hover:bg-slate-400'"
                            aria-label="Portofolio {{ $idx + 1 }}">
                    </button>
                @endforeach
            </div>
        </div>

        <!-- B2B Service Level Agreement (SLA) Banner -->
        <div class="bg-slate-900 text-white p-8 rounded-xl border border-slate-800 flex flex-col md:flex-row md:items-center justify-between gap-6">
            <div>
                <span class="text-xs font-bold uppercase tracking-wider text-sky-400 block mb-1">Kemitraan Resto &amp; Hotel</span>
                <h3 class="text-xl font-bold text-white">Butuh Jadwal Perawatan Rutin Grease Trap &amp; Pipa Dapur?</h3>
                <p class="text-slate-400 text-xs sm:text-sm mt-1 max-w-2xl leading-relaxed">
                    Drainusantara menyediakan kontrak SLA berkala bulanan dengan faktur pajak resmi, pengerjaan after-hours (malam/dini hari), dan garansi anti-mampet 30 hari.
                </p>
            </div>
            <div class="shrink-0">
                <a href="https://wa.me/{{ $whatsappNumber }}?text={{ urlencode('Halo Admin Drainusantara, saya tertarik dengan kontrak perawatan rutin B2B untuk restoran/hotel.') }}" 
                   target="_blank" 
                   rel="noopener noreferrer" 
                   class="btn-press inline-flex items-center gap-2 px-6 py-3.5 rounded-lg bg-emerald-600 hover:bg-emerald-700 active:bg-emerald-800 text-white font-bold text-xs shadow-md transition-colors min-h-[44px]">
                    <span>Ajukan Penawaran B2B</span>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                    </svg>
                </a>
            </div>
        </div>

    </div>
</section>
@endsection
