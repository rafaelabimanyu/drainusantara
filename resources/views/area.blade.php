@extends('layouts.app')

@section('content')
@php
    $whatsappNumber = config('app.whatsapp_number', '6281234567890');
    $emergencyWaMsg = urlencode("Halo teknisi Drainusantara, saya butuh perbaikan saluran mampet di area {$area->district}, {$area->city}. Mohon info biaya dan estimasi kedatangan teknisi ke lokasi saya.");
    $emergencyWaUrl = "https://wa.me/{$whatsappNumber}?text={$emergencyWaMsg}";
@endphp

<!-- ====================================================================
     1. HERO SECTION AREA LAYANAN DINAMIS
==================================================================== -->
<section class="relative overflow-hidden bg-gradient-to-b from-sky-50/80 via-white to-slate-50 pt-8 pb-16 lg:pt-14 lg:pb-20 border-b border-slate-200/80">
    <!-- Ambient glowing accents -->
    <div class="absolute top-0 right-0 -mr-24 -mt-24 w-96 h-96 rounded-full bg-sky-200/30 blur-3xl pointer-events-none"></div>
    <div class="absolute bottom-0 left-0 -ml-24 -mb-24 w-96 h-96 rounded-full bg-orange-100/40 blur-3xl pointer-events-none"></div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative">
        <!-- Breadcrumb Navigation -->
        <nav class="flex items-center gap-2 text-xs sm:text-sm text-slate-500 mb-6" aria-label="Breadcrumb">
            <a href="{{ url('/') }}" class="hover:text-sky-600 transition-colors">Beranda</a>
            <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
            </svg>
            <span class="text-slate-600">Area Layanan</span>
            <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
            </svg>
            <span class="text-slate-600">{{ $area->city }}</span>
            <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
            </svg>
            <span class="text-sky-700 font-semibold">{{ $area->district }}</span>
        </nav>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 items-center">
            <!-- Hero Left: Text & CTA -->
            <div class="lg:col-span-7 space-y-6 text-center lg:text-left fade-up">
                <!-- Live Response Pill / Badge -->
                <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs sm:text-sm font-semibold shadow-2xs">
                    <span class="flex h-2.5 w-2.5 rounded-full bg-emerald-500 animate-ping"></span>
                    <span>Teknisi Siap Meluncur ke {{ $area->district }}</span>
                </div>

                <!-- Dynamic Main SEO Heading -->
                <h1 class="text-3xl sm:text-4xl md:text-5xl font-extrabold text-slate-900 tracking-tight leading-tight">
                    Jasa Pipa & Saluran Mampet <span class="text-sky-600">{{ $area->district }}, {{ $area->city }}</span>
                </h1>

                <!-- Persuasive Dynamic Subheading -->
                <p class="text-base sm:text-lg text-slate-600 leading-relaxed max-w-2xl mx-auto lg:mx-0">
                    Layanan pelancaran wastafel, kloset toilet, dan floor drain tersumbat untuk perumahan, ruko, restoran, dan kantor di area <strong>{{ $area->district }}</strong>. Menggunakan mesin spiral mekanis modern tanpa bongkar keramik dan bergaransi 30 hari.
                </p>

                <!-- Estimasi Respon & Highlights -->
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 pt-2">
                    <div class="bg-white p-3.5 rounded-xl border border-slate-200 shadow-2xs flex items-center gap-3">
                        <div class="w-10 h-10 rounded-lg bg-sky-50 text-sky-600 flex items-center justify-center shrink-0">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <div class="text-left">
                            <div class="text-[11px] text-slate-500 font-medium">Estimasi Kedatangan</div>
                            <div class="text-xs sm:text-sm font-bold text-slate-900">30 - 45 Menit</div>
                        </div>
                    </div>

                    <div class="bg-white p-3.5 rounded-xl border border-slate-200 shadow-2xs flex items-center gap-3">
                        <div class="w-10 h-10 rounded-lg bg-orange-50 text-orange-500 flex items-center justify-center shrink-0">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                            </svg>
                        </div>
                        <div class="text-left">
                            <div class="text-[11px] text-slate-500 font-medium">Garansi Layanan</div>
                            <div class="text-xs sm:text-sm font-bold text-slate-900">Garansi 30 Hari</div>
                        </div>
                    </div>

                    <div class="bg-white p-3.5 rounded-xl border border-slate-200 shadow-2xs flex items-center gap-3">
                        <div class="w-10 h-10 rounded-lg bg-sky-50 text-sky-600 flex items-center justify-center shrink-0">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                            </svg>
                        </div>
                        <div class="text-left">
                            <div class="text-[11px] text-slate-500 font-medium">Metode Pengerjaan</div>
                            <div class="text-xs sm:text-sm font-bold text-slate-900">Tanpa Bongkar</div>
                        </div>
                    </div>
                </div>

                <!-- 2 CTA Buttons with dynamic WhatsApp destination -->
                <div class="flex flex-col sm:flex-row items-center justify-center lg:justify-start gap-4 pt-3">
                    <!-- WhatsApp Emergency CTA (bg-orange-600) -->
                    <a href="{{ $emergencyWaUrl }}" target="_blank" rel="noopener noreferrer" class="w-full sm:w-auto inline-flex items-center justify-center gap-3 bg-orange-600 hover:bg-orange-700 text-white font-bold text-base px-8 py-4 rounded-xl shadow-xl shadow-orange-600/25 transition-all duration-300 transform hover:-translate-y-0.5 active:translate-y-0">
                        <svg class="w-5 h-5 fill-current" viewBox="0 0 24 24">
                            <path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/>
                        </svg>
                        <span>Panggil Teknisi {{ $area->district }}</span>
                    </a>

                    <!-- Tombol Sekunder -->
                    <a href="#layanan-area" class="w-full sm:w-auto inline-flex items-center justify-center gap-2 bg-sky-700 hover:bg-sky-800 text-white font-bold text-base px-7 py-4 rounded-xl shadow-lg shadow-sky-700/20 transition-all duration-300">
                        <span>Lihat Layanan Tersedia</span>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </a>
                </div>
            </div>

            <!-- Hero Right: Posko & Info Card -->
            <div class="lg:col-span-5 fade-up delay-150">
                <div class="bg-white rounded-3xl border border-slate-200 shadow-xl p-6 sm:p-8 space-y-6">
                    <div class="flex items-center justify-between border-b border-slate-100 pb-4">
                        <div>
                            <span class="text-xs font-semibold uppercase tracking-wider text-sky-600 block">Unit Reaksi Cepat</span>
                            <h3 class="text-lg font-bold text-slate-900">Posko Layanan {{ $area->city }}</h3>
                        </div>
                        <span class="px-3 py-1 rounded-full bg-emerald-100 text-emerald-800 text-xs font-bold">Aktif 24/7</span>
                    </div>

                    <div class="space-y-3.5 text-sm text-slate-600">
                        <div class="flex items-start gap-3">
                            <svg class="w-5 h-5 text-sky-600 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                            <div>
                                <strong class="text-slate-800 block">Cakupan Wilayah:</strong>
                                <span>Kecamatan {{ $area->district }}, {{ $area->city }} dan sekitarnya @if($area->postal_code) (Kode Pos: {{ $area->postal_code }}) @endif.</span>
                            </div>
                        </div>

                        <div class="flex items-start gap-3">
                            <svg class="w-5 h-5 text-sky-600 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <div>
                                <strong class="text-slate-800 block">Keamanan Properti:</strong>
                                <span>100% tanpa bongkar keramik, tidak berisik, dan tanpa limbah kimia berbahaya.</span>
                            </div>
                        </div>

                        <div class="flex items-start gap-3">
                            <svg class="w-5 h-5 text-sky-600 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                            </svg>
                            <div>
                                <strong class="text-slate-800 block">Transparansi Biaya:</strong>
                                <span>Estimasi harga disepakati di awal. Tanpa biaya tersembunyi.</span>
                            </div>
                        </div>
                    </div>

                    <div class="pt-4 border-t border-slate-100">
                        <a href="{{ $emergencyWaUrl }}" target="_blank" rel="noopener noreferrer" class="w-full flex items-center justify-center gap-2 bg-slate-900 hover:bg-slate-800 text-white font-bold text-sm py-3 px-4 rounded-xl transition-colors">
                            <svg class="w-4 h-4 fill-current text-orange-400" viewBox="0 0 24 24">
                                <path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/>
                            </svg>
                            <span>Hubungi Teknisi Posko Terdekat</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ====================================================================
     2. LAYANAN POPULER DI AREA TERSEBUT
==================================================================== -->
<section id="layanan-area" class="py-16 lg:py-24 bg-slate-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-3xl mx-auto mb-14 fade-up">
            <span class="text-sky-900 font-extrabold text-xs uppercase tracking-wider bg-sky-100 px-3 py-1 rounded-full">
                Layanan Unggulan di {{ $area->district }}
            </span>
            <h2 class="text-3xl sm:text-4xl font-extrabold text-slate-900 mt-3 tracking-tight">
                Layanan Pipa Mampet Populer di {{ $area->district }}, {{ $area->city }}
            </h2>
            <p class="text-slate-600 text-sm sm:text-base mt-2">
                Pilih kebutuhan saluran Anda. Seluruh pengerjaan dilengkapi garansi 30 hari resmi.
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <!-- 1. Kloset & WC -->
            @php
                $toiletWaMsg = urlencode("Halo teknisi Drainusantara, saya butuh perbaikan Kloset/WC Mampet di area {$area->district}, {$area->city}. Mohon info jadwal teknisi.");
                $toiletWaUrl = "https://wa.me/{$whatsappNumber}?text={$toiletWaMsg}";
            @endphp
            <div class="bg-white rounded-2xl border border-slate-200 p-6 flex flex-col justify-between shadow-sm hover:shadow-xl transition-all duration-300 group fade-up delay-100">
                <div>
                    <div class="w-12 h-12 rounded-xl bg-sky-100 text-sky-600 flex items-center justify-center mb-4 group-hover:bg-sky-600 group-hover:text-white transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-slate-900 mb-2">Kloset & WC Tersumbat</h3>
                    <p class="text-xs sm:text-sm text-slate-600 leading-relaxed">
                        Atasi toilet duduk/jongkok tersumbat tisu, pembalut, atau benda keras tanpa mencabut kloset dan tanpa merusak keramik di {{ $area->district }}.
                    </p>
                    <ul class="mt-4 space-y-1.5 text-xs text-slate-700">
                        <li class="flex items-center gap-1.5"><span class="text-emerald-500 font-bold">✓</span> Tanpa bongkar kloset</li>
                        <li class="flex items-center gap-1.5"><span class="text-emerald-500 font-bold">✓</span> Teknisi higienis & APD</li>
                        <li class="flex items-center gap-1.5"><span class="text-emerald-500 font-bold">✓</span> Garansi 30 hari</li>
                    </ul>
                </div>
                <div class="mt-6 pt-4 border-t border-slate-100">
                    <div class="text-xs text-slate-500">Mulai dari</div>
                    <div class="text-lg font-extrabold text-slate-900 mb-3">Rp 400.000 <span class="text-xs font-normal text-slate-500">/ titik</span></div>
                    <a href="{{ $toiletWaUrl }}" target="_blank" rel="noopener noreferrer" class="w-full flex items-center justify-center gap-2 bg-orange-600 hover:bg-orange-700 text-white font-bold text-xs py-2.5 px-3 rounded-xl transition-colors">
                        <span>Pesan Kloset (WA)</span>
                    </a>
                </div>
            </div>

            <!-- 2. Wastafel & Cuci Piring -->
            @php
                $sinkWaMsg = urlencode("Halo teknisi Drainusantara, saya butuh perbaikan Wastafel Cuci Piring Mampet di area {$area->district}, {$area->city}. Mohon info biaya.");
                $sinkWaUrl = "https://wa.me/{$whatsappNumber}?text={$sinkWaMsg}";
            @endphp
            <div class="bg-white rounded-2xl border border-slate-200 p-6 flex flex-col justify-between shadow-sm hover:shadow-xl transition-all duration-300 group fade-up delay-150">
                <div>
                    <div class="w-12 h-12 rounded-xl bg-sky-100 text-sky-600 flex items-center justify-center mb-4 group-hover:bg-sky-600 group-hover:text-white transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/>
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-slate-900 mb-2">Wastafel & Kitchen Sink</h3>
                    <p class="text-xs sm:text-sm text-slate-600 leading-relaxed">
                        Pembersihan kerak minyak dan sisa lemak beku pada bak cuci piring rumah atau restoran di {{ $area->district }} secara tuntas.
                    </p>
                    <ul class="mt-4 space-y-1.5 text-xs text-slate-700">
                        <li class="flex items-center gap-1.5"><span class="text-emerald-500 font-bold">✓</span> Kerak lemak rontok 100%</li>
                        <li class="flex items-center gap-1.5"><span class="text-emerald-500 font-bold">✓</span> Aman untuk pipa sifon PVC</li>
                        <li class="flex items-center gap-1.5"><span class="text-emerald-500 font-bold">✓</span> Garansi 30 hari</li>
                    </ul>
                </div>
                <div class="mt-6 pt-4 border-t border-slate-100">
                    <div class="text-xs text-slate-500">Mulai dari</div>
                    <div class="text-lg font-extrabold text-slate-900 mb-3">Rp 400.000 <span class="text-xs font-normal text-slate-500">/ titik</span></div>
                    <a href="{{ $sinkWaUrl }}" target="_blank" rel="noopener noreferrer" class="w-full flex items-center justify-center gap-2 bg-orange-600 hover:bg-orange-700 text-white font-bold text-xs py-2.5 px-3 rounded-xl transition-colors">
                        <span>Pesan Wastafel (WA)</span>
                    </a>
                </div>
            </div>

            <!-- 3. Floor Drain & Kamar Mandi -->
            @php
                $floorWaMsg = urlencode("Halo teknisi Drainusantara, saya butuh perbaikan Floor Drain Kamar Mandi Mampet di area {$area->district}, {$area->city}. Mohon info teknisi.");
                $floorWaUrl = "https://wa.me/{$whatsappNumber}?text={$floorWaMsg}";
            @endphp
            <div class="bg-white rounded-2xl border border-slate-200 p-6 flex flex-col justify-between shadow-sm hover:shadow-xl transition-all duration-300 group fade-up delay-200">
                <div>
                    <div class="w-12 h-12 rounded-xl bg-sky-100 text-sky-600 flex items-center justify-center mb-4 group-hover:bg-sky-600 group-hover:text-white transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/>
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-slate-900 mb-2">Floor Drain & Got Mandi</h3>
                    <p class="text-xs sm:text-sm text-slate-600 leading-relaxed">
                        Menuntaskan genangan air akibat gumpalan rambut dan kerak sabun yang menyumbat saluran pembuangan kamar mandi Anda.
                    </p>
                    <ul class="mt-4 space-y-1.5 text-xs text-slate-700">
                        <li class="flex items-center gap-1.5"><span class="text-emerald-500 font-bold">✓</span> Tarik gumpalan rambut</li>
                        <li class="flex items-center gap-1.5"><span class="text-emerald-500 font-bold">✓</span> Bebas bau got menguap</li>
                        <li class="flex items-center gap-1.5"><span class="text-emerald-500 font-bold">✓</span> Garansi 30 hari</li>
                    </ul>
                </div>
                <div class="mt-6 pt-4 border-t border-slate-100">
                    <div class="text-xs text-slate-500">Mulai dari</div>
                    <div class="text-lg font-extrabold text-slate-900 mb-3">Rp 400.000 <span class="text-xs font-normal text-slate-500">/ titik</span></div>
                    <a href="{{ $floorWaUrl }}" target="_blank" rel="noopener noreferrer" class="w-full flex items-center justify-center gap-2 bg-orange-600 hover:bg-orange-700 text-white font-bold text-xs py-2.5 px-3 rounded-xl transition-colors">
                        <span>Pesan Floor Drain (WA)</span>
                    </a>
                </div>
            </div>

            <!-- 4. Kamera CCTV 30M -->
            @php
                $cctvWaMsg = urlencode("Halo teknisi Drainusantara, saya butuh layanan Inspeksi CCTV Pipa 30M di area {$area->district}, {$area->city}. Mohon info estimasi biaya.");
                $cctvWaUrl = "https://wa.me/{$whatsappNumber}?text={$cctvWaMsg}";
            @endphp
            <div class="bg-white rounded-2xl border border-slate-200 p-6 flex flex-col justify-between shadow-sm hover:shadow-xl transition-all duration-300 group fade-up delay-250">
                <div>
                    <div class="w-12 h-12 rounded-xl bg-sky-100 text-sky-600 flex items-center justify-center mb-4 group-hover:bg-sky-600 group-hover:text-white transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-slate-900 mb-2">Inspeksi Kamera CCTV 30M</h3>
                    <p class="text-xs sm:text-sm text-slate-600 leading-relaxed">
                        Mendeteksi titik pecah, sambungan lepas, atau posisi endapan benda asing dalam pipa dengan monitor HD berjarak hingga 30 meter.
                    </p>
                    <ul class="mt-4 space-y-1.5 text-xs text-slate-700">
                        <li class="flex items-center gap-1.5"><span class="text-emerald-500 font-bold">✓</span> Jangkauan kabel 30 meter</li>
                        <li class="flex items-center gap-1.5"><span class="text-emerald-500 font-bold">✓</span> Rekaman visual foto & video</li>
                        <li class="flex items-center gap-1.5"><span class="text-emerald-500 font-bold">✓</span> Diagnosis akurat 100%</li>
                    </ul>
                </div>
                <div class="mt-6 pt-4 border-t border-slate-100">
                    <div class="text-xs text-slate-500">Mulai dari</div>
                    <div class="text-lg font-extrabold text-slate-900 mb-3">Rp 400.000 <span class="text-xs font-normal text-slate-500">/ sesi</span></div>
                    <a href="{{ $cctvWaUrl }}" target="_blank" rel="noopener noreferrer" class="w-full flex items-center justify-center gap-2 bg-orange-600 hover:bg-orange-700 text-white font-bold text-xs py-2.5 px-3 rounded-xl transition-colors">
                        <span>Pesan Inspeksi CCTV (WA)</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ====================================================================
     3. EDUKASI KHUSUS AREA (BAHAYA SODA API DI PERUMAHAN/KULINER AREA)
==================================================================== -->
<section class="py-16 lg:py-24 bg-white border-y border-slate-200/80">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 items-center">
            <!-- Left: Warning Illustration / Alert -->
            <div class="lg:col-span-5 fade-up">
                <div class="rounded-3xl bg-orange-50 border-2 border-orange-200/80 p-6 sm:p-8 space-y-5">
                    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-orange-100 text-orange-800 text-xs font-bold">
                        <svg class="w-4 h-4 text-orange-600" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                        </svg>
                        <span>PERINGATAN TEKNISI WILAYAH {{ strtoupper($area->district) }}</span>
                    </div>

                    <h3 class="text-xl font-bold text-slate-900 leading-snug">
                        Sering Terjadi di Wilayah {{ $area->district }}: Pipa Rusak Akibat Soda Api!
                    </h3>

                    <p class="text-sm text-slate-700 leading-relaxed">
                        Banyak penghuni rumah dan pelaku usaha kuliner di <strong>{{ $area->district }}, {{ $area->city }}</strong> menuangkan soda api saat wastafel atau WC mampet. Padahal, tindakan ini berisiko fatal:
                    </p>

                    <div class="space-y-3 pt-2 text-xs sm:text-sm text-slate-700">
                        <div class="p-3 bg-white rounded-xl border border-orange-200 flex items-start gap-2.5">
                            <span class="text-red-500 font-extrabold text-sm">✕</span>
                            <div>
                                <strong class="text-slate-900 block">Saponifikasi (Lemak Mengeras Seperti Semen)</strong>
                                Di {{ $area->district }}, lemak dapur yang terkena soda api akan memadat menjadi bongkahan batu sabun yang mengunci pipa secara permanen.
                            </div>
                        </div>
                        <div class="p-3 bg-white rounded-xl border border-orange-200 flex items-start gap-2.5">
                            <span class="text-red-500 font-extrabold text-sm">✕</span>
                            <div>
                                <strong class="text-slate-900 block">Panas >90°C Melelehkan Sambungan Lem PVC</strong>
                                Pipa paralon di bawah keramik lantai melengkung dan sambungan lepas, memicu rembesan air kotor ke pondasi bangunan.
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right: Solusi Aman Mekanis Drainusantara -->
            <div class="lg:col-span-7 space-y-6 fade-up delay-150">
                <span class="text-sky-900 font-extrabold text-xs uppercase tracking-wider bg-sky-100 px-3 py-1 rounded-full">
                    Solusi Tuntas & Aman
                </span>
                <h2 class="text-2xl sm:text-3xl lg:text-4xl font-extrabold text-slate-900 tracking-tight">
                    Penanganan Mekanis Ramah Lingkungan untuk Warga {{ $area->district }}
                </h2>
                <p class="text-slate-600 text-sm sm:text-base leading-relaxed">
                    Drainusantara hadir di <strong>{{ $area->district }}, {{ $area->city }}</strong> dengan teknologi rooter spiral elektrik yang aman untuk seluruh jenis pipa bangunan lama maupun residensial modern.
                </p>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 pt-2">
                    <div class="flex items-start gap-3 p-4 rounded-xl bg-slate-50 border border-slate-200/80">
                        <div class="w-8 h-8 rounded-lg bg-sky-600 text-white flex items-center justify-center shrink-0 text-sm font-bold">1</div>
                        <div>
                            <h4 class="font-bold text-slate-900 text-sm">Kabel Spiral Baja Lentur</h4>
                            <p class="text-xs text-slate-600 mt-1">Mengikuti belokan pipa tanpa menggores atau merusak instalasi sifon.</p>
                        </div>
                    </div>

                    <div class="flex items-start gap-3 p-4 rounded-xl bg-slate-50 border border-slate-200/80">
                        <div class="w-8 h-8 rounded-lg bg-sky-600 text-white flex items-center justify-center shrink-0 text-sm font-bold">2</div>
                        <div>
                            <h4 class="font-bold text-slate-900 text-sm">Inspeksi Kamera Endoskopik</h4>
                            <p class="text-xs text-slate-600 mt-1">Melihat kondisi dalam pipa secara langsung di layar monitor HD.</p>
                        </div>
                    </div>

                    <div class="flex items-start gap-3 p-4 rounded-xl bg-slate-50 border border-slate-200/80">
                        <div class="w-8 h-8 rounded-lg bg-orange-600 text-white flex items-center justify-center shrink-0 text-sm font-bold">3</div>
                        <div>
                            <h4 class="font-bold text-slate-900 text-sm">Garansi Resmi 30 Hari</h4>
                            <p class="text-xs text-slate-600 mt-1">Mampet lagi di titik yang sama? Teknisi datang kembali gratis!</p>
                        </div>
                    </div>

                    <div class="flex items-start gap-3 p-4 rounded-xl bg-slate-50 border border-slate-200/80">
                        <div class="w-8 h-8 rounded-lg bg-emerald-600 text-white flex items-center justify-center shrink-0 text-sm font-bold">4</div>
                        <div>
                            <h4 class="font-bold text-slate-900 text-sm">Bebas Bahan Kimia</h4>
                            <p class="text-xs text-slate-600 mt-1">Aman bagi anak-anak, hewan peliharaan, dan ramah lingkungan.</p>
                        </div>
                    </div>
                </div>

                <div class="pt-2">
                    <a href="{{ $emergencyWaUrl }}" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-2.5 bg-orange-600 hover:bg-orange-700 text-white font-bold text-sm px-6 py-3.5 rounded-xl shadow-lg shadow-orange-600/25 transition-colors">
                        <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24">
                            <path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/>
                        </svg>
                        <span>Konsultasikan Masalah Pipa {{ $area->district }}</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ====================================================================
     4. ALUR LAYANAN PRAKTIS 3 LANGKAH
==================================================================== -->
<section class="py-16 bg-slate-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-2xl mx-auto mb-12 fade-up">
            <h3 class="text-2xl sm:text-3xl font-bold text-slate-900">Cara Pesan Teknisi di {{ $area->district }}</h3>
            <p class="text-slate-600 text-sm mt-2">Cukup 3 langkah mudah, saluran mampet di rumah Anda langsung lancar kembali.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="bg-white p-6 rounded-2xl border border-slate-200 text-center space-y-3 fade-up delay-100">
                <div class="w-12 h-12 rounded-full bg-sky-100 text-sky-600 font-extrabold text-lg flex items-center justify-center mx-auto">1</div>
                <h4 class="font-bold text-slate-900">Hubungi WhatsApp</h4>
                <p class="text-xs sm:text-sm text-slate-600">Klik tombol WhatsApp dan kirim alamat lengkap Anda di {{ $area->district }}, {{ $area->city }}.</p>
            </div>

            <div class="bg-white p-6 rounded-2xl border border-slate-200 text-center space-y-3 fade-up delay-200">
                <div class="w-12 h-12 rounded-full bg-orange-100 text-orange-500 font-extrabold text-lg flex items-center justify-center mx-auto">2</div>
                <h4 class="font-bold text-slate-900">Teknisi Meluncur</h4>
                <p class="text-xs sm:text-sm text-slate-600">Teknisi dari posko terdekat langsung datang membawa mesin rooter spiral lengkap dalam 30-45 menit.</p>
            </div>

            <div class="bg-white p-6 rounded-2xl border border-slate-200 text-center space-y-3 fade-up delay-300">
                <div class="w-12 h-12 rounded-full bg-emerald-100 text-emerald-600 font-extrabold text-lg flex items-center justify-center mx-auto">3</div>
                <h4 class="font-bold text-slate-900">Tuntas & Bergaransi</h4>
                <p class="text-xs sm:text-sm text-slate-600">Pengerjaan selesai tanpa bongkar keramik, dites bersama, dan diberikan garansi resmi 30 hari.</p>
            </div>
        </div>
    </div>
</section>

<!-- ====================================================================
     5. WILAYAH JANGKAUAN LAINNYA
==================================================================== -->
<section class="py-12 bg-white border-t border-slate-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-3xl mx-auto mb-8 fade-up">
            <span class="text-xs uppercase tracking-wider font-bold text-sky-600 bg-sky-50 px-3 py-1 rounded-full border border-sky-200">Cakupan Layanan Terdekat</span>
            <h3 class="text-xl sm:text-2xl font-bold text-slate-900 mt-2">Area Layanan Drainusantara Lainnya</h3>
            <p class="text-xs sm:text-sm text-slate-500 mt-1">Teknisi kami juga siaga di seluruh wilayah Jabodetabek, Semarang, dan Lampung.</p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Jabodetabek -->
            <div class="p-5 rounded-2xl bg-slate-50 border border-slate-200 fade-up delay-100">
                <div class="flex items-center gap-2 mb-3">
                    <span class="text-xs font-bold uppercase text-orange-600 bg-orange-100 px-2.5 py-0.5 rounded-md">JABODETABEK</span>
                    <span class="text-xs text-slate-500">10 Posko Siaga</span>
                </div>
                <div class="flex flex-wrap gap-2 text-xs">
                    <a href="{{ url('/area/jakarta-selatan/tebet') }}" class="px-2.5 py-1.5 rounded-lg bg-white hover:bg-sky-600 text-slate-700 hover:text-white border border-slate-200 transition-colors">Jakarta Selatan (Tebet)</a>
                    <a href="{{ url('/area/jakarta-timur/duren-sawit') }}" class="px-2.5 py-1.5 rounded-lg bg-white hover:bg-sky-600 text-slate-700 hover:text-white border border-slate-200 transition-colors">Jakarta Timur (Duren Sawit)</a>
                    <a href="{{ url('/area/jakarta-utara/kelapa-gading') }}" class="px-2.5 py-1.5 rounded-lg bg-white hover:bg-sky-600 text-slate-700 hover:text-white border border-slate-200 transition-colors">Jakarta Utara (Kelapa Gading)</a>
                    <a href="{{ url('/area/jakarta-pusat/kemayoran') }}" class="px-2.5 py-1.5 rounded-lg bg-white hover:bg-sky-600 text-slate-700 hover:text-white border border-slate-200 transition-colors">Jakarta Pusat (Kemayoran)</a>
                    <a href="{{ url('/area/jakarta-barat/kebon-jeruk') }}" class="px-2.5 py-1.5 rounded-lg bg-white hover:bg-sky-600 text-slate-700 hover:text-white border border-slate-200 transition-colors">Jakarta Barat (Kebon Jeruk)</a>
                    <a href="{{ url('/area/bogor/cibinong') }}" class="px-2.5 py-1.5 rounded-lg bg-white hover:bg-sky-600 text-slate-700 hover:text-white border border-slate-200 transition-colors">Bogor (Cibinong)</a>
                    <a href="{{ url('/area/depok-cinere/cinere') }}" class="px-2.5 py-1.5 rounded-lg bg-white hover:bg-sky-600 text-slate-700 hover:text-white border border-slate-200 transition-colors">Depok & Cinere</a>
                    <a href="{{ url('/area/tangerang-kota/cipondoh') }}" class="px-2.5 py-1.5 rounded-lg bg-white hover:bg-sky-600 text-slate-700 hover:text-white border border-slate-200 transition-colors">Tangerang Kota</a>
                    <a href="{{ url('/area/tangerang-selatan/serpong') }}" class="px-2.5 py-1.5 rounded-lg bg-white hover:bg-sky-600 text-slate-700 hover:text-white border border-slate-200 transition-colors">Tangerang Selatan (Serpong)</a>
                    <a href="{{ url('/area/bekasi-cikarang/cikarang-selatan') }}" class="px-2.5 py-1.5 rounded-lg bg-white hover:bg-sky-600 text-slate-700 hover:text-white border border-slate-200 transition-colors">Bekasi & Cikarang</a>
                </div>
            </div>

            <!-- Semarang & Lampung -->
            <div class="p-5 rounded-2xl bg-slate-50 border border-slate-200 fade-up delay-200">
                <div class="flex items-center gap-2 mb-3">
                    <span class="text-xs font-bold uppercase text-sky-700 bg-sky-100 px-2.5 py-0.5 rounded-md">SEMARANG & LAMPUNG</span>
                    <span class="text-xs text-slate-500">Kota Cabang</span>
                </div>
                <div class="flex flex-wrap gap-2 text-xs">
                    <a href="{{ url('/area/kota-semarang/candisari') }}" class="px-3 py-1.5 rounded-lg bg-white hover:bg-sky-600 text-slate-700 hover:text-white border border-slate-200 transition-colors">Kota Semarang (Candisari)</a>
                    <a href="{{ url('/area/bandar-lampung/kedaton') }}" class="px-3 py-1.5 rounded-lg bg-white hover:bg-sky-600 text-slate-700 hover:text-white border border-slate-200 transition-colors">Bandar Lampung (Kedaton)</a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ====================================================================
     6. BOTTOM EMERGENCY STICKY CTA
==================================================================== -->
<section class="py-14 bg-slate-900 text-white text-center relative overflow-hidden">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 relative zoom-in">
        <h2 class="text-2xl sm:text-3xl lg:text-4xl font-extrabold tracking-tight">
            Saluran Air di {{ $area->district }} Mampet Hari Ini?
        </h2>
        <p class="text-slate-300 text-sm sm:text-base mt-3 max-w-xl mx-auto">
            Teknisi kami siap melayani area {{ $area->district }}, {{ $area->city }} 24 jam sehari. Tanpa bongkar keramik, cepat, dan bergaransi resmi 30 hari.
        </p>

        <div class="mt-8 flex flex-col sm:flex-row items-center justify-center gap-4">
            <a href="{{ $emergencyWaUrl }}" target="_blank" rel="noopener noreferrer" class="w-full sm:w-auto inline-flex items-center justify-center gap-3 bg-orange-600 hover:bg-orange-700 text-white font-bold text-base px-8 py-4 rounded-xl shadow-xl shadow-orange-600/30 transition-all duration-300 transform hover:-translate-y-0.5">
                <svg class="w-5 h-5 fill-current" viewBox="0 0 24 24">
                    <path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/>
                </svg>
                <span>Panggil Teknisi {{ $area->district }} Sekarang</span>
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
