@extends('layouts.app')

@section('content')
@php
    $whatsappNumber = config('app.whatsapp_number') ?: '6285609009009';
    $portfolioList = $portfolios ?? collect();
@endphp

<x-about.subnav 
    active-title="Kemitraan"
    eyebrow="Jaringan Kemitraan & Perusahaan Rekanan"
    heading="Dipercaya Restoran F&B, Perhotelan & Gedung Komersial"
    subheading="Kemitraan profesional pembersihan pipa pembuangan dan Grease Trap bagi mitra bisnis tanpa mengganggu jam operasional."
    :bg-image="asset('assets/banner/hero-portofolio.webp')"
/>

@if($portfolioList->isNotEmpty())
<!-- Main Partnership Content -->
<section id="portofolio-page" class="py-16 lg:py-20 bg-slate-50 border-b border-slate-200" x-data="{ activeCategory: 'all' }">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- B2B Service Commitment Banner -->
        <div class="mb-10 p-5 bg-white border border-slate-200 rounded-lg shadow-2xs flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div class="flex items-center gap-3.5">
                <div class="w-10 h-10 rounded-md bg-sky-50 text-sky-700 border border-sky-200 flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                    </svg>
                </div>
                <div>
                    <h3 class="text-sm sm:text-base font-bold text-slate-900">Standar Kemitraan Saluran Komersial &amp; B2B</h3>
                    <p class="text-xs text-slate-600 mt-0.5">Pengerjaan di luar jam operasional, penanganan mekanis higienis tanpa kimia korosif, dan Berita Acara Pengerjaan (BAP) resmi kemitraan.</p>
                </div>
            </div>
            @php
                $waB2bText = urlencode("Halo Tim Drainusantara, saya tertarik dengan program kemitraan pemeliharaan saluran pipa komersial B2B untuk bisnis kami. Mohon info penawaran kerja sama.");
                $waB2bUrl = "https://wa.me/{$whatsappNumber}?text={$waB2bText}";
            @endphp
            <a href="{{ $waB2bUrl }}" target="_blank" rel="noopener noreferrer" class="btn-press shrink-0 inline-flex items-center justify-center gap-2 px-5 py-2.5 bg-emerald-700 hover:bg-emerald-800 text-white text-xs font-bold rounded-lg transition-colors shadow-2xs min-h-[44px]">
                <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24">
                    <path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/>
                </svg>
                <span>Konsultasi Kemitraan B2B</span>
            </a>
        </div>

        <div class="max-w-3xl mb-10 reveal-soft">
            <span class="text-xs font-bold uppercase tracking-wider text-sky-700 block mb-2">
                Jaringan Kemitraan &amp; Rekanan Komersial
            </span>
            <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">
                Kemitraan Pemeliharaan Saluran Pipa Komersial &amp; Residensial
            </h2>
            <p class="text-slate-600 text-sm sm:text-base mt-3 leading-relaxed">
                Drainusantara bermitra dengan restoran kuliner, pengelola gedung, hotel, hingga residensial untuk perawatan berkala saluran pipa tanpa bongkar. Kerja sama terstruktur dengan standar higienis tinggi dan jaminan garansi resmi.
            </p>
        </div>

        <!-- Portfolio Cards Grid (Mobile 2 Kolom + Pagination 6 Card / Desktop Grid) -->
        <div x-data="{
                 currentPage: 1,
                 perPageMobile: 6,
                 totalItems: {{ count($portfolioList) }},
                 isMobile: window.innerWidth < 768,
                 init() {
                     window.addEventListener('resize', () => {
                         this.isMobile = window.innerWidth < 768;
                     });
                 },
                 get totalPages() {
                     return Math.ceil(this.totalItems / this.perPageMobile);
                 },
                 isInCurrentMobilePage(index) {
                     if (!this.isMobile) return true;
                     const start = (this.currentPage - 1) * this.perPageMobile;
                     const end = start + this.perPageMobile;
                     return index >= start && index < end;
                 },
                 goToPage(page) {
                     if (page >= 1 && page <= this.totalPages) {
                         this.currentPage = page;
                         this.$el.scrollIntoView({ behavior: 'smooth', block: 'start' });
                     }
                 }
             }"
             class="mb-14">
            
            <div class="grid grid-cols-2 md:grid-cols-2 lg:grid-cols-3 gap-3 sm:gap-6 lg:gap-8">
                @foreach($portfolioList as $project)
                    @php
                        $waText = urlencode("Halo Tim Drainusantara, saya tertarik dengan kemitraan pemeliharaan saluran seperti di '{$project->client_name}'. Mohon info konsultasi dan survei lokasi.");
                        $waUrl = "https://wa.me/{$whatsappNumber}?text={$waText}";
                        $portfolioDetailUrl = !empty($project->slug) ? route('partnership.show', $project->slug) : null;
                    @endphp
                    <div x-show="isInCurrentMobilePage({{ $loop->index }})"
                         class="bg-white rounded-xl border border-slate-200 overflow-hidden shadow-2xs hover:shadow-md hover:border-sky-300 transition-all duration-300 flex flex-col group card-lift reveal-soft stagger-{{ ($loop->iteration % 3) + 1 }}">
                        <!-- Foto Restoran / Klien Jernih (Tanpa Blur) -->
                        <div class="w-full h-32 sm:h-52 md:h-56 overflow-hidden bg-slate-100 relative">
                            @if($portfolioDetailUrl)
                                <a href="{{ $portfolioDetailUrl }}" class="block w-full h-full focus-visible:outline-hidden focus-visible:ring-2 focus-visible:ring-sky-600" title="Lihat profil kemitraan {{ $project->client_name }}">
                            @endif
                            @php
                                $aboutProjImg = $project->image ? (str_starts_with($project->image, 'http') || str_starts_with($project->image, '/') ? $project->image : asset($project->image)) : asset('images/drainusantara-jasa-saluran-pipa-mampet-teknisi-profesional.webp');
                                $aboutDefaultFallback = asset('images/drainusantara-jasa-saluran-pipa-mampet-teknisi-profesional.webp');
                            @endphp
                            <img src="{{ $aboutProjImg }}" 
                                 alt="{{ $project->client_name }}" 
                                 width="800"
                                 height="500"
                                 loading="lazy"
                                 decoding="async"
                                 class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                                 onerror="this.onerror=null; this.src='{{ $aboutDefaultFallback }}';">
                            @if($portfolioDetailUrl)
                                </a>
                            @endif
                        </div>

                        <!-- Informasi Restoran / Klien Bersih -->
                        <div class="p-3 sm:p-5 flex flex-col justify-between flex-1">
                            <div>
                                <h3 class="text-xs sm:text-base md:text-lg font-bold text-slate-900 tracking-tight line-clamp-1 group-hover:text-sky-700 transition-colors">
                                    @if($portfolioDetailUrl)
                                        <a href="{{ $portfolioDetailUrl }}" class="hover:underline">
                                            {{ $project->client_name }}
                                        </a>
                                    @else
                                        {{ $project->client_name }}
                                    @endif
                                </h3>
                                @if(!empty($project->client_type))
                                <p class="text-[10px] sm:text-xs text-slate-500 mt-1 sm:mt-1.5 flex items-center gap-1 sm:gap-1.5 truncate">
                                    <svg class="w-3 h-3 sm:w-3.5 sm:h-3.5 text-sky-600 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                    </svg>
                                    <span class="truncate">{{ $project->client_type }}</span>
                                </p>
                                @endif
                                @if(!empty($project->location))
                                <p class="text-[10px] sm:text-[11px] text-slate-400 mt-0.5 sm:mt-1 flex items-center gap-1 sm:gap-1.5 truncate">
                                    <svg class="w-2.5 h-2.5 sm:w-3 sm:h-3 text-slate-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    </svg>
                                    <span class="truncate">{{ $project->location }}</span>
                                </p>
                                @endif
                            </div>

                            <div class="mt-3 sm:mt-4 pt-2 sm:pt-3 border-t border-slate-100 flex items-center justify-between gap-1.5 sm:gap-2 flex-wrap sm:flex-nowrap">
                                @if($portfolioDetailUrl)
                                    <a href="{{ $portfolioDetailUrl }}" 
                                       class="inline-flex items-center gap-0.5 sm:gap-1 text-[11px] sm:text-xs font-semibold text-sky-700 hover:text-sky-800 transition-colors py-1 shrink-0">
                                        <span>Detail</span>
                                        <svg class="w-3 h-3 sm:w-3.5 sm:h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                                        </svg>
                                    </a>
                                @endif
                                <a href="{{ $waUrl }}" 
                                   target="_blank" 
                                   rel="noopener noreferrer" 
                                   class="btn-press {{ $portfolioDetailUrl ? '' : 'w-full' }} inline-flex items-center justify-center gap-1 px-2.5 sm:px-3 py-1 sm:py-1.5 rounded-md sm:rounded-lg bg-emerald-50 hover:bg-emerald-100 text-emerald-800 border border-emerald-200 text-[11px] sm:text-xs font-bold transition-colors">
                                    <span>Konsultasi</span>
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Mobile Pagination Bar (6 Card per Halaman) -->
            <div x-show="totalPages > 1"
                 class="flex md:hidden justify-center items-center gap-2 mt-6 text-xs text-slate-600 font-medium">
                <button type="button" 
                        @click="goToPage(currentPage - 1)"
                        :disabled="currentPage === 1"
                        :class="currentPage === 1 ? 'opacity-40 cursor-not-allowed' : 'hover:bg-slate-100 hover:text-slate-900 cursor-pointer active:scale-95'"
                        class="px-2.5 py-1.5 rounded-lg border border-slate-200 bg-white shadow-2xs transition-all flex items-center gap-1 min-h-[38px]"
                        aria-label="Halaman sebelumnya">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                    </svg>
                    <span>Sebelumnya</span>
                </button>

                <div class="px-3 py-1.5 rounded-lg bg-white border border-slate-200 text-xs font-mono shadow-2xs min-h-[38px] flex items-center">
                    <span>Hal <strong class="text-slate-900" x-text="currentPage">1</strong> / <span x-text="totalPages">1</span></span>
                </div>

                <button type="button" 
                        @click="goToPage(currentPage + 1)"
                        :disabled="currentPage === totalPages"
                        :class="currentPage === totalPages ? 'opacity-40 cursor-not-allowed' : 'hover:bg-slate-100 hover:text-slate-900 cursor-pointer active:scale-95'"
                        class="px-2.5 py-1.5 rounded-lg border border-slate-200 bg-white shadow-2xs transition-all flex items-center gap-1 min-h-[38px]"
                        aria-label="Halaman berikutnya">
                    <span>Berikutnya</span>
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </button>
            </div>
        </div>

        <!-- B2B Service Level Agreement (SLA) Banner -->
        <div class="bg-slate-900 text-white p-8 rounded-xl border border-slate-800 flex flex-col md:flex-row md:items-center justify-between gap-6">
            <div>
                <span class="text-xs font-bold uppercase tracking-wider text-sky-400 block mb-1">Kemitraan Resto, Hotel &amp; Komersial</span>
                <h3 class="text-xl font-bold text-white">Butuh Jadwal Perawatan Rutin Grease Trap &amp; Pipa Dapur?</h3>
                <p class="text-slate-400 text-xs sm:text-sm mt-1 max-w-2xl leading-relaxed">
                    Drainusantara menyediakan program kemitraan kontrak SLA berkala dengan faktur pajak resmi, pengerjaan after-hours (malam/dini hari), dan garansi anti-mampet 30 hari.
                </p>
            </div>
            <div class="shrink-0">
                <a href="https://wa.me/{{ $whatsappNumber }}?text={{ urlencode('Halo Admin Drainusantara, saya tertarik dengan program kemitraan perawatan rutin B2B untuk restoran/hotel.') }}" 
                   target="_blank" 
                   rel="noopener noreferrer" 
                   class="btn-press inline-flex items-center gap-2 px-6 py-3.5 rounded-lg bg-emerald-700 hover:bg-emerald-800 active:bg-emerald-900 text-white font-bold text-xs shadow-md transition-colors min-h-[44px]">
                    <span>Ajukan Kemitraan B2B</span>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                    </svg>
                </a>
            </div>
        </div>

    </div>
</section>
@endif
@endsection
