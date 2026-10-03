@extends('layouts.app')

@section('content')
@php
    $whatsappNumber = config('app.whatsapp_number') ?: '6281234567890';
    $portfolioList = (isset($portfolios) && $portfolios->isNotEmpty())
        ? $portfolios 
        : \App\Models\Portfolio::where('is_active', true)->orderBy('order')->get();

    // Fallback data default identik dengan landing page jika database CMS masih kosong
    
@endphp

<x-about.subnav 
    active-title="Klien & Portofolio"
    eyebrow="Perusahaan Yang Menggunakan Jasa Kami"
    heading="Dipercaya Restoran F&B, Perhotelan & Gedung Komersial"
    subheading="Bukti nyata penanganan profesional pembersihan pipa pembuangan dan grease trap bagi mitra bisnis tanpa mengganggu jam operasional."
    :bg-image="asset('assets/banner/hero-portofolio.webp')"
/>

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
                    <h3 class="text-sm sm:text-base font-bold text-slate-900">Ringkasan Portofolio B2B di Beranda</h3>
                    <p class="text-xs text-slate-600 mt-0.5">Tinjau rekam jejak pembersihan pipa restoran F&amp;B, hotel, dan fasilitas komersial mitra Drainusantara.</p>
                </div>
            </div>
            <a href="{{ url('/#portofolio-b2b') }}" class="btn-press shrink-0 inline-flex items-center justify-center gap-2 px-5 py-2.5 bg-sky-700 hover:bg-sky-800 text-white text-xs font-bold rounded-lg transition-colors shadow-2xs min-h-[44px]">
                <span>Lihat Ringkasan di Beranda</span>
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                </svg>
            </a>
        </div>

        <div class="max-w-3xl mb-10 reveal-soft">
            <span class="text-xs font-bold uppercase tracking-wider text-sky-700 block mb-2">
                Rekam Jejak Proyek &amp; Klien
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
                        $waText = urlencode("Halo Tim Drainusantara, saya tertarik dengan portofolio penanganan di '{$project->client_name}'. Mohon info konsultasi dan survei lokasi.");
                        $waUrl = "https://wa.me/{$whatsappNumber}?text={$waText}";
                    @endphp
                    <a href="{{ $waUrl }}" 
                       target="_blank" 
                       rel="noopener noreferrer" 
                       class="w-[85vw] sm:w-[350px] md:w-auto shrink-0 snap-center bg-white rounded-xl border border-slate-200 overflow-hidden shadow-2xs hover:shadow-md hover:border-sky-300 transition-all duration-300 flex flex-col group card-lift focus-visible:outline-hidden focus-visible:ring-2 focus-visible:ring-sky-600 reveal-soft stagger-{{ ($loop->iteration % 3) + 1 }}"
                       title="Konsultasi penanganan {{ $project->client_name }}">
                        <!-- Foto Restoran / Klien Jernih (Tanpa Blur) -->
                        <div class="w-full h-52 sm:h-56 overflow-hidden bg-slate-100 relative">
                            @php
                                $aboutProjImg = $project->image ? (str_starts_with($project->image, 'http') || str_starts_with($project->image, '/') ? $project->image : asset($project->image)) : asset('images/portfolio/gacoan-mitra-kepercayaan-drainusantara-jasa-saluran-pipa-mampet.webp');
                                $aboutDefaultFallback = asset('images/portfolio/gacoan-mitra-kepercayaan-drainusantara-jasa-saluran-pipa-mampet.webp');
                            @endphp
                            <img src="{{ $aboutProjImg }}" 
                                 alt="{{ $project->client_name }}" 
                                 width="800"
                                 height="500"
                                 loading="lazy"
                                 decoding="async"
                                 class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                                 onerror="this.onerror=null; this.src='{{ $aboutDefaultFallback }}';">
                        </div>

                        <!-- Informasi Restoran / Klien Bersih -->
                        <div class="p-5 flex flex-col justify-between flex-1">
                            <div>
                                <h3 class="text-base sm:text-lg font-bold text-slate-900 tracking-tight line-clamp-1 group-hover:text-sky-700 transition-colors">
                                    {{ $project->client_name }}
                                </h3>
                                @if(!empty($project->client_type))
                                <p class="text-xs text-slate-500 mt-1.5 flex items-center gap-1.5 truncate">
                                    <svg class="w-3.5 h-3.5 text-sky-600 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                    </svg>
                                    <span class="truncate">{{ $project->client_type }}</span>
                                </p>
                                @endif
                            </div>
                        </div>
                    </a>
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
                   class="btn-press inline-flex items-center gap-2 px-6 py-3.5 rounded-lg bg-emerald-700 hover:bg-emerald-800 active:bg-emerald-900 text-white font-bold text-xs shadow-md transition-colors min-h-[44px]">
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
