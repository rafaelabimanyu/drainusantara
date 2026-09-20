@extends('layouts.app')

@section('content')
@php
    $whatsappNumber = config('app.whatsapp_number', '6281234567890');
    $generalWaUrl = "https://wa.me/{$whatsappNumber}?text=" . urlencode("Halo Drainusantara, saya membutuhkan layanan penanganan saluran mampet. Mohon info ketersediaan teknisi.");
@endphp

<!-- ====================================================================
     1. HERO SECTION
==================================================================== -->
<section class="relative overflow-hidden bg-gradient-to-b from-sky-50/70 via-white to-slate-50 pt-8 pb-16 lg:pt-16 lg:pb-24">
    <!-- Decorative background blobs -->
    <div class="absolute top-0 right-0 -mr-20 -mt-20 w-96 h-96 rounded-full bg-sky-200/30 blur-3xl pointer-events-none"></div>
    <div class="absolute bottom-0 left-0 -ml-20 -mb-20 w-96 h-96 rounded-full bg-orange-100/40 blur-3xl pointer-events-none"></div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
            <!-- Hero Text Content -->
            <div class="lg:col-span-7 space-y-6 text-center lg:text-left fade-up">
                <!-- Trust Badge -->
                <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-sky-100/80 border border-sky-200 text-sky-800 text-xs sm:text-sm font-semibold shadow-xs">
                    <span class="flex h-2 w-2 rounded-full bg-sky-600 animate-pulse"></span>
                    <span>Spesialis Pipa Mampet: Jabodetabek &bull; Kota Semarang &bull; Bandar Lampung</span>
                </div>

                <!-- Main SEO Headline -->
                <h1 class="text-3xl sm:text-4xl md:text-5xl lg:text-6xl font-extrabold text-slate-900 tracking-tight leading-[1.15]">
                    Solusi Saluran Mampet Tuntas <span class="text-sky-600">Tanpa Bongkar</span> & Bergaransi 30 Hari
                </h1>

                <!-- Subheadline / Description -->
                <p class="text-base sm:text-lg text-slate-600 leading-relaxed max-w-2xl mx-auto lg:mx-0">
                    Atasi wastafel cucian, kloset toilet, dan floor drain tersumbat secara cepat dan higienis. Menggunakan mesin spiral mekanis modern dan inspeksi kamera CCTV 30M berstandar K3 tanpa merusak lantai rumah Anda.
                </p>

                <!-- Value Highlights Pills -->
                <div class="flex flex-wrap justify-center lg:justify-start gap-3 pt-1 text-xs sm:text-sm text-slate-700 font-medium">
                    <div class="flex items-center gap-1.5 bg-white px-3 py-1.5 rounded-lg border border-slate-200 shadow-2xs">
                        <svg class="w-4 h-4 text-sky-600" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                        <span>100% Tanpa Rusak Keramik</span>
                    </div>
                    <div class="flex items-center gap-1.5 bg-white px-3 py-1.5 rounded-lg border border-slate-200 shadow-2xs">
                        <svg class="w-4 h-4 text-sky-600" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                        <span>Garansi Resmi 30 Hari</span>
                    </div>
                    <div class="flex items-center gap-1.5 bg-white px-3 py-1.5 rounded-lg border border-slate-200 shadow-2xs">
                        <svg class="w-4 h-4 text-sky-600" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                        <span>Bebas Soda Api</span>
                    </div>
                </div>

                <!-- 2 CTA Buttons -->
                <div class="flex flex-col sm:flex-row items-center justify-center lg:justify-start gap-4 pt-4">
                    <!-- WhatsApp Hubungi Teknisi (bg-orange-600) -->
                    <a href="{{ $generalWaUrl }}" target="_blank" rel="noopener noreferrer" class="w-full sm:w-auto inline-flex items-center justify-center gap-3 bg-orange-600 hover:bg-orange-700 text-white font-bold text-base px-8 py-4 rounded-xl shadow-xl shadow-orange-600/25 transition-all duration-300 transform hover:-translate-y-0.5 active:translate-y-0">
                        <svg class="w-5 h-5 fill-current" viewBox="0 0 24 24">
                            <path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/>
                        </svg>
                        <span>Hubungi Teknisi Sekarang</span>
                    </a>

                    <!-- Lihat Layanan (bg-sky-700) -->
                    <a href="#layanan" class="w-full sm:w-auto inline-flex items-center justify-center gap-2 bg-sky-700 hover:bg-sky-800 text-white font-bold text-base px-7 py-4 rounded-xl shadow-lg shadow-sky-700/20 transition-all duration-300">
                        <span>Lihat Layanan Kami</span>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </a>
                </div>

                <!-- Emergency Response Note -->
                <p class="text-xs text-slate-500 text-center lg:text-left">
                    <span class="inline-block w-2 h-2 rounded-full bg-emerald-500 mr-1.5"></span>
                    Teknisi siaga beroperasi 24/7 &bull; Estimasi tiba di lokasi 30-60 menit
                </p>
            </div>

            <!-- Hero Image / Visual Representation -->
            <div class="lg:col-span-5 relative fade-up delay-150">
                <div class="relative mx-auto max-w-md lg:max-w-none">
                    <!-- Main Card Container -->
                    <div class="relative rounded-3xl overflow-hidden shadow-2xl bg-white border border-slate-200/80 p-2 sm:p-3">
                        <img 
                            src="https://placehold.co/600x450/0284c7/ffffff?text=Teknisi+Rooter+Drainusantara" 
                            alt="Teknisi Drainusantara menangani pipa mampet tanpa bongkar" 
                            width="600" 
                            height="450" 
                            loading="eager"
                            class="w-full h-auto rounded-2xl object-cover"
                        >

                        <!-- Live Status Overlay Pill -->
                        <div class="absolute top-6 left-6 bg-slate-900/85 backdrop-blur-md text-white text-xs font-semibold px-3 py-1.5 rounded-full flex items-center gap-2 shadow-lg">
                            <span class="w-2.5 h-2.5 rounded-full bg-emerald-400 animate-ping"></span>
                            <span>Teknisi On-Call Siaga</span>
                        </div>
                    </div>

                    <!-- Floating Badge 1: Garansi 30 Hari -->
                    <div class="absolute -bottom-6 -left-4 sm:-left-6 bg-white p-4 rounded-2xl shadow-xl border border-slate-100 flex items-center gap-3 max-w-xs animate-bounce" style="animation-duration: 4s;">
                        <div class="w-12 h-12 rounded-xl bg-orange-100 text-orange-500 flex items-center justify-center shrink-0">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                            </svg>
                        </div>
                        <div>
                            <div class="text-xs font-medium text-slate-500 uppercase tracking-wider">Garansi Kepuasan</div>
                            <div class="text-sm font-bold text-slate-900">Garansi Tuntas 30 Hari</div>
                        </div>
                    </div>

                    <!-- Floating Badge 2: Kamera CCTV 30M -->
                    <div class="absolute -top-6 -right-4 sm:-right-6 bg-white p-3.5 rounded-2xl shadow-xl border border-slate-100 flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-sky-100 text-sky-600 flex items-center justify-center shrink-0">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        <div>
                            <div class="text-[11px] font-medium text-slate-500">Alat Deteksi Akurat</div>
                            <div class="text-xs font-bold text-slate-900">Inspeksi CCTV 30 Meter</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ====================================================================
     2. AREA JANGKAUAN RINGKAS (BANNER INFO JANGKAUAN)
==================================================================== -->
<section class="bg-sky-600 py-10 text-white shadow-inner fade-up">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col lg:flex-row items-start lg:items-center justify-between gap-6 mb-6">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-2xl bg-white/10 backdrop-blur-xs flex items-center justify-center shrink-0">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                </div>
                <div>
                    <h2 class="text-xl sm:text-2xl font-bold">Wilayah Jangkauan Layanan Drainusantara</h2>
                    <p class="text-xs sm:text-sm text-sky-100 mt-0.5">Armada teknisi siaga di posko strategis dengan estimasi tiba 30-45 menit.</p>
                </div>
            </div>

            <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-white/15 backdrop-blur-md text-xs font-semibold border border-white/20">
                <span class="w-2 h-2 rounded-full bg-emerald-400 animate-ping"></span>
                <span>Armada Standby Siap Meluncur</span>
            </div>
        </div>

        <div class="space-y-4">
            <!-- Group 1: JABODETABEK -->
            <div class="bg-white/10 backdrop-blur-sm rounded-2xl p-4 sm:p-5 border border-white/15">
                <div class="flex items-center gap-2 mb-3">
                    <span class="text-xs uppercase tracking-wider font-extrabold text-orange-300 bg-orange-500/30 px-2.5 py-0.5 rounded-md border border-orange-400/30">JABODETABEK</span>
                    <span class="text-xs text-sky-100">10 Wilayah Layanan:</span>
                </div>
                <div class="flex flex-wrap gap-2 text-xs sm:text-sm">
                    <a href="{{ url('/area/jakarta-selatan/tebet') }}" class="px-3 py-1.5 rounded-xl bg-white/15 hover:bg-white text-white hover:text-sky-700 font-semibold border border-white/20 transition-all">Jakarta Selatan (Tebet & sekitarnya)</a>
                    <a href="{{ url('/area/jakarta-timur/duren-sawit') }}" class="px-3 py-1.5 rounded-xl bg-white/15 hover:bg-white text-white hover:text-sky-700 font-semibold border border-white/20 transition-all">Jakarta Timur (Duren Sawit)</a>
                    <a href="{{ url('/area/jakarta-utara/kelapa-gading') }}" class="px-3 py-1.5 rounded-xl bg-white/15 hover:bg-white text-white hover:text-sky-700 font-semibold border border-white/20 transition-all">Jakarta Utara (Kelapa Gading)</a>
                    <a href="{{ url('/area/jakarta-pusat/kemayoran') }}" class="px-3 py-1.5 rounded-xl bg-white/15 hover:bg-white text-white hover:text-sky-700 font-semibold border border-white/20 transition-all">Jakarta Pusat (Kemayoran)</a>
                    <a href="{{ url('/area/jakarta-barat/kebon-jeruk') }}" class="px-3 py-1.5 rounded-xl bg-white/15 hover:bg-white text-white hover:text-sky-700 font-semibold border border-white/20 transition-all">Jakarta Barat (Kebon Jeruk)</a>
                    <a href="{{ url('/area/bogor/cibinong') }}" class="px-3 py-1.5 rounded-xl bg-white/15 hover:bg-white text-white hover:text-sky-700 font-semibold border border-white/20 transition-all">Bogor (Cibinong & Sentul)</a>
                    <a href="{{ url('/area/depok-cinere/cinere') }}" class="px-3 py-1.5 rounded-xl bg-white/15 hover:bg-white text-white hover:text-sky-700 font-semibold border border-white/20 transition-all">Depok & Cinere</a>
                    <a href="{{ url('/area/tangerang-kota/cipondoh') }}" class="px-3 py-1.5 rounded-xl bg-white/15 hover:bg-white text-white hover:text-sky-700 font-semibold border border-white/20 transition-all">Tangerang Kota</a>
                    <a href="{{ url('/area/tangerang-selatan/serpong') }}" class="px-3 py-1.5 rounded-xl bg-white/15 hover:bg-white text-white hover:text-sky-700 font-semibold border border-white/20 transition-all">Tangerang Selatan (Serpong & BSD)</a>
                    <a href="{{ url('/area/bekasi-cikarang/cikarang-selatan') }}" class="px-3 py-1.5 rounded-xl bg-white/15 hover:bg-white text-white hover:text-sky-700 font-semibold border border-white/20 transition-all">Bekasi & Cikarang</a>
                </div>
            </div>

            <!-- Group 2: Semarang & Bandar Lampung -->
            <div class="bg-white/10 backdrop-blur-sm rounded-2xl p-4 sm:p-5 border border-white/15">
                <div class="flex items-center gap-2 mb-3">
                    <span class="text-xs uppercase tracking-wider font-extrabold text-orange-300 bg-orange-500/30 px-2.5 py-0.5 rounded-md border border-orange-400/30">SEMARANG & LAMPUNG</span>
                    <span class="text-xs text-sky-100">Wilayah Siaga:</span>
                </div>
                <div class="flex flex-wrap gap-2 text-xs sm:text-sm">
                    <a href="{{ url('/area/semarang/candisari') }}" class="px-3 py-1.5 rounded-xl bg-white/15 hover:bg-white text-white hover:text-sky-700 font-semibold border border-white/20 transition-all">Kota Semarang (Candisari, Banyumanik & sekitarnya)</a>
                    <a href="{{ url('/area/bandar-lampung/kedaton') }}" class="px-3 py-1.5 rounded-xl bg-white/15 hover:bg-white text-white hover:text-sky-700 font-semibold border border-white/20 transition-all">Bandar Lampung (Kedaton, Tanjung Karang & sekitarnya)</a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ====================================================================
     3. LAYANAN KAMI (GRID 4 CARD)
==================================================================== -->
<section id="layanan" class="py-16 lg:py-24 bg-slate-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Section Header -->
        <div class="text-center max-w-3xl mx-auto mb-16 fade-up">
            <span class="text-sky-900 font-extrabold text-xs uppercase tracking-wider bg-sky-100 px-3 py-1 rounded-full">
                Solusi Tuntas & Higienis
            </span>
            <h2 class="text-3xl sm:text-4xl font-extrabold text-slate-900 mt-3 tracking-tight">
                Layanan Saluran Pipa Mampet Kami
            </h2>
            <p class="text-slate-600 text-sm sm:text-base mt-3">
                Dikerjakan oleh teknisi berpengalaman menggunakan mesin drain rooter spiral elektrik dan kamera endoskopik pipa resolusi tinggi.
            </p>
        </div>

        <!-- 4 Grid Service Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 lg:gap-8">
            @forelse($services as $service)
                @php
                    $serviceWaMsg = urlencode("Halo Drainusantara, saya ingin memesan layanan " . $service->name . ". Mohon info biaya pengerjaan dan estimasi teknisi.");
                    $serviceWaUrl = "https://wa.me/{$whatsappNumber}?text={$serviceWaMsg}";
                @endphp
                <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300 flex flex-col justify-between group fade-up delay-{{ min($loop->iteration * 100, 300) }}">
                    <div>
                        <!-- Service Image Container -->
                        <div class="relative overflow-hidden aspect-[4/3] bg-slate-100">
                            <img 
                                src="{{ $service->image ?? 'https://placehold.co/600x400/0284c7/ffffff?text=' . urlencode($service->name) }}" 
                                alt="{{ $service->name }} - Drainusantara" 
                                width="600" 
                                height="400" 
                                loading="lazy"
                                class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                            >
                            <div class="absolute top-3 right-3 bg-sky-600/90 text-white text-[11px] font-bold px-2.5 py-1 rounded-full backdrop-blur-xs">
                                Garansi 30 Hari
                            </div>
                        </div>

                        <!-- Card Body -->
                        <div class="p-6">
                            <h3 class="text-lg font-bold text-slate-900 group-hover:text-sky-600 transition-colors">
                                {{ $service->name }}
                            </h3>
                            <p class="text-xs sm:text-sm text-slate-600 mt-2 leading-relaxed line-clamp-3">
                                {{ $service->short_description }}
                            </p>

                            <!-- Features List -->
                            @if(!empty($service->features) && is_array($service->features))
                                <ul class="mt-4 space-y-2 border-t border-slate-100 pt-4">
                                    @foreach($service->features as $feature)
                                        <li class="flex items-center gap-2 text-xs text-slate-700">
                                            <svg class="w-4 h-4 text-emerald-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                                            </svg>
                                            <span>{{ $feature }}</span>
                                        </li>
                                    @endforeach
                                </ul>
                            @endif
                        </div>
                    </div>

                    <!-- Card Footer: Pricing & WhatsApp CTA -->
                    <div class="p-6 pt-0 border-t border-slate-100 mt-4 bg-slate-50/50">
                        <div class="mb-4">
                            <span class="text-xs text-slate-500 block">Biaya pengerjaan mulai:</span>
                            <div class="text-xl font-extrabold text-slate-900">
                                @if($service->price_starting_from)
                                    Rp {{ number_format($service->price_starting_from, 0, ',', '.') }}
                                @else
                                    Hubungi Kami
                                @endif
                                <span class="text-xs font-normal text-slate-500">/ titik</span>
                            </div>
                        </div>

                        <a href="{{ $serviceWaUrl }}" target="_blank" rel="noopener noreferrer" class="w-full flex items-center justify-center gap-2 bg-orange-600 hover:bg-orange-700 text-white font-bold text-xs sm:text-sm py-3 px-4 rounded-xl shadow-md shadow-orange-600/20 transition-all duration-200 active:scale-98">
                            <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24">
                                <path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/>
                            </svg>
                            <span>Pesan via WhatsApp</span>
                        </a>
                    </div>
                </div>
            @empty
                <!-- Fallback Static 4 Cards if DB empty -->
                <div class="col-span-4 text-center py-8 text-slate-500">
                    Memuat layanan Drainusantara...
                </div>
            @endforelse
        </div>
    </div>
</section>

<!-- ====================================================================
     4. KEUNGGULAN (4 PILAR UTAMA)
==================================================================== -->
<section class="py-16 lg:py-24 bg-white border-y border-slate-200/80">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Section Header -->
        <div class="text-center max-w-3xl mx-auto mb-16 fade-up">
            <span class="text-orange-500 font-bold text-xs uppercase tracking-wider bg-orange-50 px-3 py-1 rounded-full border border-orange-200">
                Standar Layanan Unggulan
            </span>
            <h2 class="text-3xl sm:text-4xl font-extrabold text-slate-900 mt-3 tracking-tight">
                Mengapa Memilih Drainusantara?
            </h2>
            <p class="text-slate-600 text-sm sm:text-base mt-3">
                Kami memberikan standar teknis penanganan saluran pipa modern tanpa risiko kerusakan bangunan hunian Anda.
            </p>
        </div>

        <!-- 4 Pillars Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
            <!-- Pilar 1: Tanpa Bongkar Keramik -->
            <div class="p-6 rounded-2xl bg-slate-50 border border-slate-200/90 hover:border-sky-300 hover:shadow-lg transition-all duration-300 fade-up delay-100">
                <div class="w-14 h-14 rounded-2xl bg-sky-600 text-white flex items-center justify-center mb-6 shadow-md shadow-sky-600/20">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                    </svg>
                </div>
                <h3 class="text-lg font-bold text-slate-900 mb-2">Tanpa Bongkar Keramik</h3>
                <p class="text-sm text-slate-600 leading-relaxed">
                    Menggunakan mesin spiral baja fleksibel yang meliuk mengikuti alur pipa tanpa membongkar lantai keramik atau merusak dinding rumah Anda.
                </p>
            </div>

            <!-- Pilar 2: Inspeksi CCTV 30M -->
            <div class="p-6 rounded-2xl bg-slate-50 border border-slate-200/90 hover:border-sky-300 hover:shadow-lg transition-all duration-300 fade-up delay-150">
                <div class="w-14 h-14 rounded-2xl bg-sky-600 text-white flex items-center justify-center mb-6 shadow-md shadow-sky-600/20">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                    </svg>
                </div>
                <h3 class="text-lg font-bold text-slate-900 mb-2">Inspeksi CCTV 30M</h3>
                <p class="text-sm text-slate-600 leading-relaxed">
                    Kamera endoskopi tahan air IP68 berjarak hingga 30 meter. Mendiagnosis titik keretakan, posisi sumbatan, dan kondisi pipa secara akurat.
                </p>
            </div>

            <!-- Pilar 3: Garansi 30 Hari -->
            <div class="p-6 rounded-2xl bg-slate-50 border border-slate-200/90 hover:border-sky-300 hover:shadow-lg transition-all duration-300 fade-up delay-200">
                <div class="w-14 h-14 rounded-2xl bg-orange-600 text-white flex items-center justify-center mb-6 shadow-md shadow-orange-600/20">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/>
                    </svg>
                </div>
                <h3 class="text-lg font-bold text-slate-900 mb-2">Garansi 30 Hari</h3>
                <p class="text-sm text-slate-600 leading-relaxed">
                    Jaminan pengerjaan tuntas 100%. Jika timbul kendala mampet pada titik pengerjaan yang sama dalam 30 hari, teknisi kami siap melayani gratis.
                </p>
            </div>

            <!-- Pilar 4: Teknisi APD & K3 -->
            <div class="p-6 rounded-2xl bg-slate-50 border border-slate-200/90 hover:border-sky-300 hover:shadow-lg transition-all duration-300 fade-up delay-300">
                <div class="w-14 h-14 rounded-2xl bg-sky-600 text-white flex items-center justify-center mb-6 shadow-md shadow-sky-600/20">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                </div>
                <h3 class="text-lg font-bold text-slate-900 mb-2">Teknisi APD & K3</h3>
                <p class="text-sm text-slate-600 leading-relaxed">
                    Teknisi profesional, bersertifikasi, dan selalu mengenakan APD higienis untuk menjaga kenyamanan, keamanan, dan kebersihan properti Anda.
                </p>
            </div>
        </div>
    </div>
</section>

<!-- ====================================================================
     5. EDUKASI / SOLUSI CERDAS (PEMBERSIHAN MEKANIS VS BAHAYA SODA API)
==================================================================== -->
<section class="py-16 lg:py-24 bg-slate-50 overflow-hidden">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-3xl mx-auto mb-16">
            <span class="text-sky-900 font-extrabold text-xs uppercase tracking-wider bg-sky-100 px-3 py-1 rounded-full">
                Edukasi & Perlindungan Pipa
            </span>
            <h2 class="text-3xl sm:text-4xl font-extrabold text-slate-900 mt-3 tracking-tight">
                Solusi Cerdas: Kenapa Jangan Pakai Soda Api?
            </h2>
            <p class="text-slate-600 text-sm sm:text-base mt-3">
                Banyak pemilik rumah salah kaprah menggunakan soda api atau bahan kimia korosif yang berujung pada kerusakan fatal pipa instalasi.
            </p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 items-stretch">
            <!-- Kartu Bahaya Bahan Kimia / Soda Api -->
            <div class="rounded-3xl bg-red-50/70 border border-red-200 p-8 flex flex-col justify-between">
                <div>
                    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-red-100 text-red-700 text-xs font-bold mb-4">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                        </svg>
                        <span>BAHAYA FATAL SODA API & CHEMICAL</span>
                    </div>
                    <h3 class="text-xl font-bold text-slate-900 mb-4">
                        Risiko Nyata Pemakaian Bahan Kimia Keras
                    </h3>

                    <ul class="space-y-4 text-sm text-slate-700">
                        <li class="flex items-start gap-3">
                            <div class="w-6 h-6 rounded-full bg-red-200 text-red-700 flex items-center justify-center shrink-0 mt-0.5 font-bold text-xs">✕</div>
                            <div>
                                <strong class="text-slate-900 block font-semibold">Pipa PVC Meleleh & Melengkung</strong>
                                Reaksi kimia soda api menimbulkan panas ekstrem (>90°C) yang dapat melunakkan, merusak sambungan lem, dan membengkokkan pipa paralon.
                            </div>
                        </li>
                        <li class="flex items-start gap-3">
                            <div class="w-6 h-6 rounded-full bg-red-200 text-red-700 flex items-center justify-center shrink-0 mt-0.5 font-bold text-xs">✕</div>
                            <div>
                                <strong class="text-slate-900 block font-semibold">Lemak Mengeras Seperti Semen (Saponifikasi)</strong>
                                Minyak dan lemak beku yang bereaksi dengan soda api justru mengkristal menjadi gumpalan sabun keras yang mustahil ditembus air.
                            </div>
                        </li>
                        <li class="flex items-start gap-3">
                            <div class="w-6 h-6 rounded-full bg-red-200 text-red-700 flex items-center justify-center shrink-0 mt-0.5 font-bold text-xs">✕</div>
                            <div>
                                <strong class="text-slate-900 block font-semibold">Uap Korosif Beracun & Risiko Cedera</strong>
                                Menghasilkan gas pekat berbau tajam yang berbahaya bagi pernapasan serta risiko cipratan air panas kimia yang merusak kulit dan mata.
                            </div>
                        </li>
                    </ul>
                </div>

                <div class="mt-8 p-4 rounded-xl bg-red-100/60 border border-red-200 text-xs text-red-800">
                    <strong>Peringatan:</strong> Jika pipa sudah terlanjur melengkung atau pecah di dalam coran lantai beton, biaya renovasi dan bongkar keramik bisa mencapai jutaan rupiah.
                </div>
            </div>

            <!-- Kartu Solusi Mekanis Drainusantara -->
            <div class="rounded-3xl bg-white border border-sky-200 shadow-xl p-8 flex flex-col justify-between">
                <div>
                    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-sky-100 text-sky-800 text-xs font-bold mb-4">
                        <svg class="w-4 h-4 text-sky-600" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                        <span>SOLUSI MODERN DRAINUSANTARA</span>
                    </div>
                    <h3 class="text-xl font-bold text-slate-900 mb-4">
                        Pembersihan Mekanis & Inspeksi CCTV
                    </h3>

                    <ul class="space-y-4 text-sm text-slate-700">
                        <li class="flex items-start gap-3">
                            <div class="w-6 h-6 rounded-full bg-sky-100 text-sky-800 flex items-center justify-center shrink-0 mt-0.5 font-bold text-xs">✓</div>
                            <div>
                                <strong class="text-slate-900 block font-semibold">Spiral Baja Lentur Mengikis Lemak</strong>
                                Mesin rooter memutar kabel spiral pegas dengan torsi optimal untuk merontokkan kerak lemak dan menarik sumbatan tanpa melukai dinding pipa PVC.
                            </div>
                        </li>
                        <li class="flex items-start gap-3">
                            <div class="w-6 h-6 rounded-full bg-sky-100 text-sky-800 flex items-center justify-center shrink-0 mt-0.5 font-bold text-xs">✓</div>
                            <div>
                                <strong class="text-slate-900 block font-semibold">Visual Nyata dengan Kamera CCTV Pipa</strong>
                                Mendiagnosa kondisi real-time jalur pipa di layar monitor HD: melihat letak endapan kotoran, batu, patahan, atau kemiringan pipa.
                            </div>
                        </li>
                        <li class="flex items-start gap-3">
                            <div class="w-6 h-6 rounded-full bg-sky-100 text-sky-800 flex items-center justify-center shrink-0 mt-0.5 font-bold text-xs">✓</div>
                            <div>
                                <strong class="text-slate-900 block font-semibold">100% Ramah Lingkungan & Aman Bangunan</strong>
                                Tanpa bahan kimia beracun, aman bagi kesehatan keluarga Anda, serta menjaga instalasi pipa awet hingga bertahun-tahun ke depan.
                            </div>
                        </li>
                    </ul>
                </div>

                <div class="mt-8 pt-6 border-t border-slate-100 flex flex-col sm:flex-row items-center justify-between gap-4">
                    <div>
                        <span class="text-xs text-slate-500 block">Konsultasikan pipa mampet Anda:</span>
                        <span class="text-sm font-bold text-slate-900">Gratis konsultasi & pengecekan</span>
                    </div>
                    <a href="{{ $generalWaUrl }}" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-2 bg-sky-600 hover:bg-sky-700 text-white text-xs sm:text-sm font-bold px-5 py-2.5 rounded-xl shadow-md transition-colors">
                        <span>Tanya Teknisi Sekarang</span>
                    </a>
                </div>
            </div>
        </div>
    </div><!-- ====================================================================
     6. ULASAN PELANGGAN (TESTIMONI DARI DATABASE)
==================================================================== -->
@if(isset($reviews) && $reviews->isNotEmpty())
<section class="py-16 lg:py-24 bg-white border-t border-slate-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-3xl mx-auto mb-16 fade-up">
            <span class="text-sky-900 font-extrabold text-xs uppercase tracking-wider bg-sky-100 px-3 py-1 rounded-full">
                Ulasan Nyata
            </span>
            <h2 class="text-3xl sm:text-4xl font-extrabold text-slate-900 mt-3 tracking-tight">
                Apa Kata Pelanggan Drainusantara?
            </h2>
            <p class="text-slate-600 text-sm sm:text-base mt-3">
                Kepercayaan dari ratusan pemilik rumah, cafe, restoran, dan gedung perkantoran.
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach($reviews as $review)
                <div class="bg-slate-50 rounded-2xl p-6 border border-slate-200/80 flex flex-col justify-between hover:shadow-md transition-shadow fade-up delay-{{ min($loop->iteration * 100, 300) }}">
                    <div>
                        <!-- Bintang Rating -->
                        <div class="flex items-center gap-1 text-amber-400 mb-3">
                            @for($i = 1; $i <= 5; $i++)
                                <svg class="w-4 h-4 {{ $i <= $review->rating ? 'fill-current' : 'text-slate-200' }}" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                </svg>
                            @endfor
                        </div>
                        <p class="text-slate-700 text-sm italic leading-relaxed">
                            "{{ $review->comment }}"
                        </p>
                    </div>

                    <div class="mt-6 pt-4 border-t border-slate-200/70 flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full bg-sky-600 text-white flex items-center justify-center font-bold text-sm shrink-0">
                            {{ substr($review->customer_name, 0, 1) }}
                        </div>
                        <div>
                            <div class="font-bold text-slate-900 text-sm">{{ $review->customer_name }}</div>
                            <div class="text-xs text-slate-500">{{ $review->customer_role_or_location }}</div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
@endif

<!-- ====================================================================
     7. FAQ (ACCORDION INTERAKTIF DENGAN ALPINE.JS)
==================================================================== -->
<section class="py-16 lg:py-24 bg-slate-50 border-t border-slate-200">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-14 fade-up">
            <span class="text-sky-900 font-extrabold text-xs uppercase tracking-wider bg-sky-100 px-3 py-1 rounded-full">
                Pertanyaan Umum
            </span>
            <h2 class="text-3xl sm:text-4xl font-extrabold text-slate-900 mt-3 tracking-tight">
                Frequently Asked Questions (FAQ)
            </h2>
            <p class="text-slate-600 text-sm sm:text-base mt-2">
                Informasi seputar cara kerja, harga, dan jaminan layanan Drainusantara.
            </p>
        </div>

        <!-- Alpine.js Accordion Component -->
        <div x-data="{ active: null }" class="space-y-4 fade-up delay-100">
            <!-- FAQ 1 -->
            <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden shadow-2xs transition-all">
                <button 
                    @click="active = (active === 1 ? null : 1)" 
                    class="w-full flex items-center justify-between p-5 sm:p-6 text-left font-bold text-slate-900 hover:text-sky-600 transition-colors focus:outline-hidden"
                    type="button"
                >
                    <span class="text-base sm:text-lg">Apakah pengerjaan benar-benar 100% tanpa bongkar keramik atau lantai?</span>
                    <svg class="w-5 h-5 shrink-0 transform transition-transform duration-300 text-slate-500" :class="{ 'rotate-180 text-sky-600': active === 1 }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                </button>
                <div x-show="active === 1" x-collapse x-cloak class="px-5 pb-5 sm:px-6 sm:pb-6 text-sm sm:text-base text-slate-600 leading-relaxed border-t border-slate-100 pt-4">
                    Benar, 100% tanpa bongkar lantai atau dinding! Kami menggunakan mesin drain rooter fleksibel berteknologi spiral baja yang mampu meliuk mengikuti belokan pipa (knee/elbow) hingga ke titik sumbatan. Mesin ini menghancurkan kerak lemak atau menarik benda keras keluar tanpa merusak pipa.
                </div>
            </div>

            <!-- FAQ 2 -->
            <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden shadow-2xs transition-all">
                <button 
                    @click="active = (active === 2 ? null : 2)" 
                    class="w-full flex items-center justify-between p-5 sm:p-6 text-left font-bold text-slate-900 hover:text-sky-600 transition-colors focus:outline-hidden"
                    type="button"
                >
                    <span class="text-base sm:text-lg">Berapa lama estimasi waktu pengerjaan saluran mampet?</span>
                    <svg class="w-5 h-5 shrink-0 transform transition-transform duration-300 text-slate-500" :class="{ 'rotate-180 text-sky-600': active === 2 }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                </button>
                <div x-show="active === 2" x-collapse x-cloak class="px-5 pb-5 sm:px-6 sm:pb-6 text-sm sm:text-base text-slate-600 leading-relaxed border-t border-slate-100 pt-4">
                    Rata-rata pengerjaan berkisar antara 30 hingga 60 menit per titik saluran. Untuk kasus tertentu dengan jalur pipa sangat panjang atau sumbatan berat (seperti endapan semen mengeras), pengerjaan dapat memakan waktu hingga 1,5 jam disertai inspeksi CCTV.
                </div>
            </div>

            <!-- FAQ 3 -->
            <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden shadow-2xs transition-all">
                <button 
                    @click="active = (active === 3 ? null : 3)" 
                    class="w-full flex items-center justify-between p-5 sm:p-6 text-left font-bold text-slate-900 hover:text-sky-600 transition-colors focus:outline-hidden"
                    type="button"
                >
                    <span class="text-base sm:text-lg">Bagaimana ketentuan Garansi 30 Hari Drainusantara?</span>
                    <svg class="w-5 h-5 shrink-0 transform transition-transform duration-300 text-slate-500" :class="{ 'rotate-180 text-sky-600': active === 3 }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                </button>
                <div x-show="active === 3" x-collapse x-cloak class="px-5 pb-5 sm:px-6 sm:pb-6 text-sm sm:text-base text-slate-600 leading-relaxed border-t border-slate-100 pt-4">
                    Setiap pengerjaan kami berikan nota garansi resmi selama 30 hari kalender. Apabila dalam kurun waktu tersebut saluran pada titik yang sama mengalami mampet kembali, teknisi kami siap datang kembali untuk penanganan ulang tanpa dipungut biaya jasa tambahan.
                </div>
            </div>

            <!-- FAQ 4 -->
            <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden shadow-2xs transition-all">
                <button 
                    @click="active = (active === 4 ? null : 4)" 
                    class="w-full flex items-center justify-between p-5 sm:p-6 text-left font-bold text-slate-900 hover:text-sky-600 transition-colors focus:outline-hidden"
                    type="button"
                >
                    <span class="text-base sm:text-lg">Mengapa saya sangat tidak disarankan memakai soda api?</span>
                    <svg class="w-5 h-5 shrink-0 transform transition-transform duration-300 text-slate-500" :class="{ 'rotate-180 text-sky-600': active === 4 }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                </button>
                <div x-show="active === 4" x-collapse x-cloak class="px-5 pb-5 sm:px-6 sm:pb-6 text-sm sm:text-base text-slate-600 leading-relaxed border-t border-slate-100 pt-4">
                    Soda api bereaksi menghasilkan panas yang sangat tinggi sehingga rentan merusak dan melelehkan sambungan pipa paralon PVC. Selain itu, soda api yang bereaksi dengan minyak makanan akan mengeras menjadi zat sabun padat seperti batu cor, yang justru membuat saluran tersumbat total permanen.
                </div>
            </div>

            <!-- FAQ 5 -->
            <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden shadow-2xs transition-all">
                <button 
                    @click="active = (active === 5 ? null : 5)" 
                    class="w-full flex items-center justify-between p-5 sm:p-6 text-left font-bold text-slate-900 hover:text-sky-600 transition-colors focus:outline-hidden"
                    type="button"
                >
                    <span class="text-base sm:text-lg">Bagaimana cara memesan jadwal kedatangan teknisi?</span>
                    <svg class="w-5 h-5 shrink-0 transform transition-transform duration-300 text-slate-500" :class="{ 'rotate-180 text-sky-600': active === 5 }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                </button>
                <div x-show="active === 5" x-collapse x-cloak class="px-5 pb-5 sm:px-6 sm:pb-6 text-sm sm:text-base text-slate-600 leading-relaxed border-t border-slate-100 pt-4">
                    Cukup klik tombol <strong>"Hubungi Teknisi"</strong> berwarna oranye di website ini untuk terhubung langsung dengan customer service kami di WhatsApp. Sampaikan keluhan saluran Anda beserta alamat lengkap, dan teknisi terdekat akan segera dijadwalkan menuju lokasi Anda.
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ====================================================================
     8. FINAL BOTTOM CALL TO ACTION
==================================================================== -->
<section class="py-16 bg-slate-900 text-white relative overflow-hidden fade-up">
    <div class="absolute inset-0 bg-[radial-gradient(ellipse_at_top,_var(--tw-gradient-stops))] from-sky-800/30 via-slate-900 to-slate-900"></div>

    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 relative text-center zoom-in delay-100">
        <h2 class="text-3xl sm:text-4xl font-extrabold tracking-tight">
            Saluran Air Anda Mampet Hari Ini? Jangan Tunggu Sampai Meluap!
        </h2>
        <p class="text-slate-300 text-sm sm:text-base mt-4 max-w-2xl mx-auto">
            Hubungi hotline WhatsApp Drainusantara sekarang juga. Teknisi kami siap meluncur dengan peralatan rooter spiral lengkap dan garansi 30 hari.
        </p>

        <div class="mt-8 flex flex-col sm:flex-row items-center justify-center gap-4">
            <a href="{{ $generalWaUrl }}" target="_blank" rel="noopener noreferrer" class="w-full sm:w-auto inline-flex items-center justify-center gap-3 bg-orange-600 hover:bg-orange-700 text-white font-bold text-base px-8 py-4 rounded-xl shadow-xl shadow-orange-600/30 transition-all duration-300 transform hover:-translate-y-0.5 active:translate-y-0">
                <svg class="w-5 h-5 fill-current" viewBox="0 0 24 24">
                    <path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/>
                </svg>
                <span>Panggil Teknisi Sekarang (WA)</span>
            </a>
            <a href="tel:{{ $whatsappNumber }}" class="w-full sm:w-auto inline-flex items-center justify-center gap-2 bg-slate-800 hover:bg-slate-700 text-white font-bold text-base px-6 py-4 rounded-xl border border-slate-700 transition-colors">
                <svg class="w-5 h-5 text-sky-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                </svg>
                <span>Telepon Hotline</span>
            </a>
        </div>
    </div>
</section>
@endsection
