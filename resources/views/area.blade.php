@extends('layouts.app')

@section('content')
@php
    $whatsappNumber = config('app.whatsapp_number', '6281234567890');
    $emergencyWaMsg = urlencode("Halo teknisi Drainusantara, saya butuh perbaikan saluran mampet di area {$area->district}, {$area->city}. Mohon info biaya dan estimasi kedatangan teknisi ke lokasi saya.");
    $emergencyWaUrl = "https://wa.me/{$whatsappNumber}?text={$emergencyWaMsg}";
@endphp

<!-- ====================================================================
     1. HERO SECTION AREA LAYANAN DINAMIS (MODERN FRIENDLY & HIGIENIS)
==================================================================== -->
<section class="relative bg-slate-50 border-b border-slate-200 pt-8 pb-14 lg:pt-12 lg:pb-18 overflow-hidden">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <!-- Breadcrumb Navigation -->
        <nav class="flex items-center gap-2 text-xs text-slate-500 mb-6 font-medium flex-wrap" aria-label="Breadcrumb">
            <a href="{{ url('/') }}" class="hover:text-sky-700 transition-colors flex items-center gap-1.5">
                <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                </svg>
                <span>Beranda</span>
            </a>
            <span class="text-slate-300">/</span>
            <a href="{{ route('area.index') }}" class="hover:text-sky-700 transition-colors">Area</a>
            @if(isset($cityData) && !empty($cityData['province_slug']))
                <span class="text-slate-300">/</span>
                <a href="{{ route('area.province', ['province' => $cityData['province_slug']]) }}" class="hover:text-sky-700 transition-colors">
                    {{ $cityData['province_name'] }}
                </a>
            @endif
            <span class="text-slate-300">/</span>
            <a href="{{ route('area.city', ['city' => $cityData['slug'] ?? \Illuminate\Support\Str::slug($area->city)]) }}" class="hover:text-sky-700 transition-colors">
                {{ $area->city }}
            </a>
            <span class="text-slate-300">/</span>
            <span class="text-sky-700 font-bold">{{ $area->district }}</span>
        </nav>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-10 items-center">
            <!-- Hero Left: Text & CTA -->
            <div class="lg:col-span-7 space-y-5 text-left fade-up">
                <!-- Live Response Pill / Badge -->
                <div class="inline-flex items-center gap-2 px-3.5 py-1.5 bg-white border border-slate-200 rounded-full text-xs font-bold text-slate-800 shadow-2xs">
                    <span class="w-2 h-2 bg-emerald-500 rounded-full animate-pulse"></span>
                    <span>Posko Siaga: Melayani Wilayah {{ $area->district }} &bull; Tiba 30-45 Mnt</span>
                </div>

                <!-- Dynamic Main SEO Heading -->
                <h1 class="text-3xl sm:text-4xl md:text-5xl font-extrabold text-slate-900 tracking-tight leading-tight">
                    Jasa Pipa & Saluran Mampet <span class="text-sky-700 underline decoration-sky-400 decoration-2 underline-offset-4">{{ $area->district }}, {{ $area->city }}</span>
                </h1>

                <!-- Persuasive Dynamic Subheading -->
                <p class="text-base text-slate-600 leading-relaxed max-w-2xl">
                    Layanan pelancaran wastafel cuci piring, kloset toilet meluap, dan floor drain kamar mandi untuk perumahan, ruko, restoran, serta gedung kantor di area <strong>{{ $area->district }}</strong>. Dikerjakan aman dengan kabel spiral mekanis torsi fleksibel tanpa membongkar keramik lantai dan bergaransi 30 hari.
                </p>

                <!-- Estimasi Respon & Highlights -->
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 pt-1">
                    <div class="bg-white p-3.5 rounded-xl border border-slate-200/90 shadow-xs flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-sky-50 border border-sky-200 text-sky-700 flex items-center justify-center shrink-0">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <div class="text-left">
                            <div class="text-[11px] text-slate-500 font-medium">Estimasi Tiba</div>
                            <div class="text-xs sm:text-sm font-extrabold text-slate-900">30 - 45 Menit</div>
                        </div>
                    </div>

                    <div class="bg-white p-3.5 rounded-xl border border-slate-200/90 shadow-xs flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-amber-50 border border-amber-200 text-amber-700 flex items-center justify-center shrink-0">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                            </svg>
                        </div>
                        <div class="text-left">
                            <div class="text-[11px] text-slate-500 font-medium">Jaminan Nota</div>
                            <div class="text-xs sm:text-sm font-extrabold text-slate-900">Garansi 30 Hari</div>
                        </div>
                    </div>

                    <div class="bg-white p-3.5 rounded-xl border border-slate-200/90 shadow-xs flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-700 flex items-center justify-center shrink-0">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                            </svg>
                        </div>
                        <div class="text-left">
                            <div class="text-[11px] text-slate-500 font-medium">Metode Kerja</div>
                            <div class="text-xs sm:text-sm font-extrabold text-slate-900">Tanpa Bongkar</div>
                        </div>
                    </div>
                </div>

                <!-- 2 CTA Buttons with dynamic WhatsApp destination -->
                <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3 pt-2">
                    <a href="{{ $emergencyWaUrl }}" target="_blank" rel="noopener noreferrer" 
                       class="inline-flex items-center justify-center gap-3 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-sm sm:text-base px-6 py-3.5 rounded-xl shadow-sm hover:shadow transition-all">
                        <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24">
                            <path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/>
                        </svg>
                        <span>Panggil Teknisi {{ $area->district }}</span>
                    </a>

                    <!-- Tombol Sekunder -->
                    <a href="#layanan-area" 
                       class="inline-flex items-center justify-center gap-2 bg-white hover:bg-slate-50 text-slate-800 font-bold text-sm sm:text-base px-6 py-3.5 rounded-xl border border-slate-200 shadow-xs transition-colors">
                        <span>Lihat Layanan Tersedia</span>
                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </a>
                </div>
            </div>

            <!-- Hero Right: Posko & Info Card -->
            <div class="lg:col-span-5 fade-up delay-150">
                <div class="bg-white rounded-2xl border border-slate-200/90 shadow-sm p-6 sm:p-7 space-y-4">
                    <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                        <div>
                            <span class="text-xs uppercase tracking-wider text-sky-700 font-bold block">UNIT REAKSI CEPAT</span>
                            <h3 class="text-lg font-bold text-slate-900 tracking-tight">Posko Layanan {{ $area->city }}</h3>
                        </div>
                        <span class="px-3 py-1 bg-emerald-50 text-emerald-800 border border-emerald-200 text-xs font-bold rounded-full">
                            STANDBY 24/7
                        </span>
                    </div>

                    <div class="space-y-3.5 text-xs sm:text-sm text-slate-600">
                        <div class="flex items-start gap-3">
                            <div class="w-6 h-6 rounded-lg bg-sky-50 text-sky-700 flex items-center justify-center shrink-0 font-bold text-xs mt-0.5">
                                📍
                            </div>
                            <div>
                                <strong class="text-slate-800 block font-semibold">Cakupan Wilayah:</strong>
                                <span>Kecamatan {{ $area->district }}, {{ $area->city }} dan sekitarnya @if($area->postal_code) (Kode Pos: {{ $area->postal_code }}) @endif.</span>
                            </div>
                        </div>

                        <div class="flex items-start gap-3">
                            <div class="w-6 h-6 rounded-lg bg-sky-50 text-sky-700 flex items-center justify-center shrink-0 font-bold text-xs mt-0.5">
                                🛡️
                            </div>
                            <div>
                                <strong class="text-slate-800 block font-semibold">Keamanan Properti:</strong>
                                <span>100% tanpa bongkar keramik, pengerjaan steril, dan bebas zat kimia beracun.</span>
                            </div>
                        </div>

                        <div class="flex items-start gap-3">
                            <div class="w-6 h-6 rounded-lg bg-emerald-50 text-emerald-700 flex items-center justify-center shrink-0 font-bold text-xs mt-0.5">
                                🏷️
                            </div>
                            <div>
                                <strong class="text-slate-800 block font-semibold">Transparansi Biaya:</strong>
                                <span>Estimasi harga disepakati di awal sebelum pengerjaan. Tanpa biaya siluman.</span>
                            </div>
                        </div>
                    </div>

                    <div class="pt-3 border-t border-slate-100">
                        <a href="{{ $emergencyWaUrl }}" target="_blank" rel="noopener noreferrer" 
                           class="w-full flex items-center justify-center gap-2 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs sm:text-sm py-3 px-4 rounded-xl shadow-xs transition-colors">
                            <span>Hubungi Teknisi Posko Terdekat &rarr;</span>
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
<section id="layanan-area" class="py-14 sm:py-20 bg-white border-b border-slate-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-3xl mx-auto mb-14 fade-up">
            <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-sky-50 border border-sky-200 text-sky-800 text-xs font-bold rounded-full uppercase tracking-wider mb-2">
                SPESIFIKASI LAYANAN {{ strtoupper($area->district) }}
            </span>
            <h2 class="text-3xl sm:text-4xl font-extrabold text-slate-900 mt-2 tracking-tight">
                Layanan Pipa Mampet di {{ $area->district }}, {{ $area->city }}
            </h2>
            <p class="text-slate-600 text-sm sm:text-base mt-2 leading-relaxed">
                Pengerjaan langsung di lokasi oleh teknisi tersertifikasi dengan garansi resmi 30 hari kalender.
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <!-- 1. Kloset & WC -->
            @php
                $toiletWaMsg = urlencode("Halo teknisi Drainusantara, saya butuh perbaikan Kloset/WC Mampet di area {$area->district}, {$area->city}. Mohon info jadwal teknisi.");
                $toiletWaUrl = "https://wa.me/{$whatsappNumber}?text={$toiletWaMsg}";
            @endphp
            <div class="bg-white rounded-2xl border border-slate-200/90 p-6 flex flex-col justify-between shadow-sm hover:shadow-md hover:border-sky-300 transition-all duration-200 group fade-up delay-100">
                <div>
                    <div class="w-12 h-12 rounded-xl bg-sky-50 border border-sky-200 text-sky-700 flex items-center justify-center mb-4 group-hover:bg-sky-700 group-hover:text-white transition-colors shadow-2xs">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                        </svg>
                    </div>
                    <span class="text-xs font-bold text-sky-700 bg-sky-50 px-2.5 py-0.5 rounded-full border border-sky-200 block w-fit mb-2">TOILET & KLOSET</span>
                    <h3 class="text-lg font-bold text-slate-900 mb-2 tracking-tight">Kloset & WC Tersumbat</h3>
                    <p class="text-xs sm:text-sm text-slate-600 leading-relaxed">
                        Atasi toilet duduk/jongkok tersumbat pembalut atau tisu tanpa mencabut kloset dan tanpa merusak ubin di {{ $area->district }}.
                    </p>
                    <ul class="mt-4 pt-3 border-t border-slate-100 space-y-1.5 text-xs text-slate-700 font-medium">
                        <li class="flex items-center gap-2"><span class="text-emerald-600 font-bold">✓</span> Tanpa bongkar kloset</li>
                        <li class="flex items-center gap-2"><span class="text-emerald-600 font-bold">✓</span> APD steril & bebas bau</li>
                        <li class="flex items-center gap-2"><span class="text-emerald-600 font-bold">✓</span> Garansi nota 30 hari</li>
                    </ul>
                </div>
                <div class="mt-6 pt-4 border-t border-slate-100">
                    <div class="text-[11px] text-slate-500">Estimasi Biaya:</div>
                    <div class="text-lg font-extrabold text-slate-900 mb-3 tracking-tight">Mulai Rp 400.000 <span class="text-xs font-normal text-slate-500">/ titik</span></div>
                    <a href="{{ $toiletWaUrl }}" target="_blank" rel="noopener noreferrer" 
                       class="w-full flex items-center justify-center gap-2 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs py-3 px-3 rounded-xl shadow-xs transition-all">
                        <span>Pesan Kloset (WhatsApp)</span>
                    </a>
                </div>
            </div>

            <!-- 2. Wastafel & Cuci Piring -->
            @php
                $sinkWaMsg = urlencode("Halo teknisi Drainusantara, saya butuh perbaikan Wastafel Cuci Piring Mampet di area {$area->district}, {$area->city}. Mohon info biaya.");
                $sinkWaUrl = "https://wa.me/{$whatsappNumber}?text={$sinkWaMsg}";
            @endphp
            <div class="bg-white rounded-2xl border border-slate-200/90 p-6 flex flex-col justify-between shadow-sm hover:shadow-md hover:border-sky-300 transition-all duration-200 group fade-up delay-150">
                <div>
                    <div class="w-12 h-12 rounded-xl bg-sky-50 border border-sky-200 text-sky-700 flex items-center justify-center mb-4 group-hover:bg-sky-700 group-hover:text-white transition-colors shadow-2xs">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/>
                        </svg>
                    </div>
                    <span class="text-xs font-bold text-sky-700 bg-sky-50 px-2.5 py-0.5 rounded-full border border-sky-200 block w-fit mb-2">DAPUR & RESIDENSIAL</span>
                    <h3 class="text-lg font-bold text-slate-900 mb-2 tracking-tight">Wastafel & Kitchen Sink</h3>
                    <p class="text-xs sm:text-sm text-slate-600 leading-relaxed">
                        Pembersihan kerak minyak dan endapan lemak beku pada bak cuci piring rumah atau dapur resto di {{ $area->district }}.
                    </p>
                    <ul class="mt-4 pt-3 border-t border-slate-100 space-y-1.5 text-xs text-slate-700 font-medium">
                        <li class="flex items-center gap-2"><span class="text-emerald-600 font-bold">✓</span> Lemak beku rontok 100%</li>
                        <li class="flex items-center gap-2"><span class="text-emerald-600 font-bold">✓</span> Aman untuk pipa sifon PVC</li>
                        <li class="flex items-center gap-2"><span class="text-emerald-600 font-bold">✓</span> Garansi nota 30 hari</li>
                    </ul>
                </div>
                <div class="mt-6 pt-4 border-t border-slate-100">
                    <div class="text-[11px] text-slate-500">Estimasi Biaya:</div>
                    <div class="text-lg font-extrabold text-slate-900 mb-3 tracking-tight">Mulai Rp 400.000 <span class="text-xs font-normal text-slate-500">/ titik</span></div>
                    <a href="{{ $sinkWaUrl }}" target="_blank" rel="noopener noreferrer" 
                       class="w-full flex items-center justify-center gap-2 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs py-3 px-3 rounded-xl shadow-xs transition-all">
                        <span>Pesan Wastafel (WhatsApp)</span>
                    </a>
                </div>
            </div>

            <!-- 3. Floor Drain & Kamar Mandi -->
            @php
                $floorWaMsg = urlencode("Halo teknisi Drainusantara, saya butuh perbaikan Floor Drain Kamar Mandi Mampet di area {$area->district}, {$area->city}. Mohon info teknisi.");
                $floorWaUrl = "https://wa.me/{$whatsappNumber}?text={$floorWaMsg}";
            @endphp
            <div class="bg-white rounded-2xl border border-slate-200/90 p-6 flex flex-col justify-between shadow-sm hover:shadow-md hover:border-sky-300 transition-all duration-200 group fade-up delay-200">
                <div>
                    <div class="w-12 h-12 rounded-xl bg-sky-50 border border-sky-200 text-sky-700 flex items-center justify-center mb-4 group-hover:bg-sky-700 group-hover:text-white transition-colors shadow-2xs">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/>
                        </svg>
                    </div>
                    <span class="text-xs font-bold text-sky-700 bg-sky-50 px-2.5 py-0.5 rounded-full border border-sky-200 block w-fit mb-2">SALURAN LANTAI</span>
                    <h3 class="text-lg font-bold text-slate-900 mb-2 tracking-tight">Floor Drain & Got Mandi</h3>
                    <p class="text-xs sm:text-sm text-slate-600 leading-relaxed">
                        Menuntaskan sumbatan rambut dan residu sabun yang memicu luapan air kotor pada saluran pembuangan kamar mandi Anda.
                    </p>
                    <ul class="mt-4 pt-3 border-t border-slate-100 space-y-1.5 text-xs text-slate-700 font-medium">
                        <li class="flex items-center gap-2"><span class="text-emerald-600 font-bold">✓</span> Bersihkan gumpalan rambut</li>
                        <li class="flex items-center gap-2"><span class="text-emerald-600 font-bold">✓</span> Hilangkan bau got menguap</li>
                        <li class="flex items-center gap-2"><span class="text-emerald-600 font-bold">✓</span> Garansi nota 30 hari</li>
                    </ul>
                </div>
                <div class="mt-6 pt-4 border-t border-slate-100">
                    <div class="text-[11px] text-slate-500">Estimasi Biaya:</div>
                    <div class="text-lg font-extrabold text-slate-900 mb-3 tracking-tight">Mulai Rp 400.000 <span class="text-xs font-normal text-slate-500">/ titik</span></div>
                    <a href="{{ $floorWaUrl }}" target="_blank" rel="noopener noreferrer" 
                       class="w-full flex items-center justify-center gap-2 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs py-3 px-3 rounded-xl shadow-xs transition-all">
                        <span>Pesan Floor Drain (WhatsApp)</span>
                    </a>
                </div>
            </div>

            <!-- 4. Kamera CCTV 30M -->
            @php
                $cctvWaMsg = urlencode("Halo teknisi Drainusantara, saya butuh layanan Inspeksi CCTV Pipa 30M di area {$area->district}, {$area->city}. Mohon info estimasi biaya.");
                $cctvWaUrl = "https://wa.me/{$whatsappNumber}?text={$cctvWaMsg}";
            @endphp
            <div class="bg-white rounded-2xl border border-slate-200/90 p-6 flex flex-col justify-between shadow-sm hover:shadow-md hover:border-sky-300 transition-all duration-200 group fade-up delay-250">
                <div>
                    <div class="w-12 h-12 rounded-xl bg-sky-50 border border-sky-200 text-sky-700 flex items-center justify-center mb-4 group-hover:bg-sky-700 group-hover:text-white transition-colors shadow-2xs">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    <span class="text-xs font-bold text-sky-700 bg-sky-50 px-2.5 py-0.5 rounded-full border border-sky-200 block w-fit mb-2">DIAGNOSTIK DIGITAL</span>
                    <h3 class="text-lg font-bold text-slate-900 mb-2 tracking-tight">Inspeksi CCTV 30M</h3>
                    <p class="text-xs sm:text-sm text-slate-600 leading-relaxed">
                        Mendeteksi titik pipa patah, sambungan lepas, atau intrusi akar di bawah cor dengan monitor HD berjarak hingga 30 meter.
                    </p>
                    <ul class="mt-4 pt-3 border-t border-slate-100 space-y-1.5 text-xs text-slate-700 font-medium">
                        <li class="flex items-center gap-2"><span class="text-emerald-600 font-bold">✓</span> Jangkauan kabel 30 meter</li>
                        <li class="flex items-center gap-2"><span class="text-emerald-600 font-bold">✓</span> Rekaman visual monitor HD</li>
                        <li class="flex items-center gap-2"><span class="text-emerald-600 font-bold">✓</span> Diagnosa akurat 100%</li>
                    </ul>
                </div>
                <div class="mt-6 pt-4 border-t border-slate-100">
                    <div class="text-[11px] text-slate-500">Estimasi Biaya:</div>
                    <div class="text-lg font-extrabold text-slate-900 mb-3 tracking-tight">Mulai Rp 400.000 <span class="text-xs font-normal text-slate-500">/ sesi</span></div>
                    <a href="{{ $cctvWaUrl }}" target="_blank" rel="noopener noreferrer" 
                       class="w-full flex items-center justify-center gap-2 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs py-3 px-3 rounded-xl shadow-xs transition-all">
                        <span>Pesan Inspeksi CCTV (WhatsApp)</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ====================================================================
     3. EDUKASI KHUSUS AREA (BAHAYA SODA API VS SOLUSI MEKANIS)
==================================================================== -->
<section class="py-14 sm:py-20 bg-slate-50 border-b border-slate-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-10 items-stretch">
            <!-- Left: Warning Alert Card -->
            <div class="lg:col-span-5 fade-up">
                <div class="h-full rounded-2xl bg-red-50/60 border border-red-200 p-7 sm:p-8 flex flex-col justify-between shadow-xs">
                    <div>
                        <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-red-700 text-white text-xs font-bold mb-4 shadow-2xs">
                            <span>PERINGATAN TEKNISI {{ strtoupper($area->district) }}</span>
                        </div>

                        <h3 class="text-xl font-bold text-slate-900 leading-snug tracking-tight mb-3">
                            Sering Terjadi di {{ $area->district }}: Pipa Rusak Akibat Soda Api!
                        </h3>

                        <p class="text-sm text-slate-700 leading-relaxed mb-4">
                            Banyak penghuni dan pengelola usaha di <strong>{{ $area->district }}, {{ $area->city }}</strong> menuangkan soda api saat saluran tersumbat. Reaksi kimia korosif seringkali merusak permanen:
                        </p>

                        <div class="space-y-3 text-xs text-slate-700">
                            <div class="p-3.5 bg-white rounded-xl border border-red-200 flex items-start gap-3">
                                <span class="text-red-700 font-extrabold text-base select-none shrink-0">✕</span>
                                <div>
                                    <strong class="text-slate-900 block font-bold mb-0.5">Saponifikasi (Lemak Mengeras Menjadi Batu)</strong>
                                    Di {{ $area->district }}, lemak dapur yang bereaksi dengan soda api akan mengkristal jadi sabun padat yang mengunci pipa secara permanen.
                                </div>
                            </div>
                            <div class="p-3.5 bg-white rounded-xl border border-red-200 flex items-start gap-3">
                                <span class="text-red-700 font-extrabold text-base select-none shrink-0">✕</span>
                                <div>
                                    <strong class="text-slate-900 block font-bold mb-0.5">Panas >90°C Melelehkan Sambungan Paralon</strong>
                                    Paralon PVC di bawah lantai melengkung dan lem sambungan knee lepas, memicu rembesan air limbah ke plafon lantai bawah.
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-6 p-4 rounded-xl bg-white border border-red-200 text-xs text-red-900 leading-relaxed font-medium">
                        <strong>Peringatan Biaya:</strong> Membongkar keramik lantai cor untuk mengganti pipa PVC pecah memerlukan biaya jutaan rupiah.
                    </div>
                </div>
            </div>

            <!-- Right: Solusi Aman Mekanis Drainusantara -->
            <div class="lg:col-span-7 fade-up delay-150">
                <div class="h-full rounded-2xl bg-white border-2 border-emerald-500/90 shadow-sm p-7 sm:p-8 flex flex-col justify-between">
                    <div>
                        <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-emerald-700 text-white text-xs font-bold mb-4 shadow-2xs">
                            <span>SOLUSI MODERN DRAINUSANTARA</span>
                        </div>
                        <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight mb-3">
                            Penanganan Mekanis Tanpa Kimia untuk Warga {{ $area->district }}
                        </h2>
                        <p class="text-slate-600 text-sm sm:text-base leading-relaxed mb-6">
                            Drainusantara hadir di <strong>{{ $area->district }}, {{ $area->city }}</strong> dengan unit rooter spiral elektrik yang aman untuk seluruh instalasi pipa bangunan baru maupun bangunan lama.
                        </p>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3.5">
                            <div class="flex items-start gap-3 p-4 rounded-xl bg-slate-50 border border-slate-200/80">
                                <div class="w-8 h-8 rounded-lg bg-sky-700 text-white flex items-center justify-center shrink-0 text-xs font-bold">01</div>
                                <div>
                                    <h4 class="font-bold text-slate-900 text-sm">Kabel Spiral Baja Lentur</h4>
                                    <p class="text-xs text-slate-600 mt-0.5">Mengikuti belokan pipa knee tanpa menggores dinding sifon PVC.</p>
                                </div>
                            </div>

                            <div class="flex items-start gap-3 p-4 rounded-xl bg-slate-50 border border-slate-200/80">
                                <div class="w-8 h-8 rounded-lg bg-sky-700 text-white flex items-center justify-center shrink-0 text-xs font-bold">02</div>
                                <div>
                                    <h4 class="font-bold text-slate-900 text-sm">Inspeksi Kamera Endoskopik</h4>
                                    <p class="text-xs text-slate-600 mt-0.5">Melihat kondisi dalam pipa secara langsung di monitor HD.</p>
                                </div>
                            </div>

                            <div class="flex items-start gap-3 p-4 rounded-xl bg-slate-50 border border-slate-200/80">
                                <div class="w-8 h-8 rounded-lg bg-amber-600 text-white flex items-center justify-center shrink-0 text-xs font-bold">03</div>
                                <div>
                                    <h4 class="font-bold text-slate-900 text-sm">Garansi Resmi 30 Hari</h4>
                                    <p class="text-xs text-slate-600 mt-0.5">Mampet lagi di titik yang sama? Teknisi datang kembali gratis!</p>
                                </div>
                            </div>

                            <div class="flex items-start gap-3 p-4 rounded-xl bg-slate-50 border border-slate-200/80">
                                <div class="w-8 h-8 rounded-lg bg-emerald-600 text-white flex items-center justify-center shrink-0 text-xs font-bold">04</div>
                                <div>
                                    <h4 class="font-bold text-slate-900 text-sm">Bebas Bahan Kimia</h4>
                                    <p class="text-xs text-slate-600 mt-0.5">Aman bagi anak-anak, hewan peliharaan, dan ramah lingkungan.</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-8 pt-6 border-t border-slate-100 flex flex-col sm:flex-row items-center justify-between gap-4">
                        <div>
                            <span class="text-xs text-slate-500 block">Konsultasi Bebas Kimia:</span>
                            <span class="text-sm font-bold text-slate-900">Konsultasi teknis & estimasi gratis</span>
                        </div>
                        <a href="{{ $emergencyWaUrl }}" target="_blank" rel="noopener noreferrer" 
                           class="inline-flex items-center gap-2 bg-emerald-600 hover:bg-emerald-700 text-white text-xs sm:text-sm font-bold px-6 py-3 rounded-xl shadow-xs transition-colors">
                            <span>Panggil Teknisi {{ $area->district }}</span>
                            <span>&rarr;</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ====================================================================
     4. ALUR LAYANAN PRAKTIS 3 LANGKAH
==================================================================== -->
<section class="py-14 sm:py-20 bg-white border-b border-slate-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-2xl mx-auto mb-12 fade-up">
            <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-sky-50 border border-sky-200 text-sky-800 text-xs font-bold rounded-full uppercase tracking-wider mb-2">
                ALUR MUDAH
            </span>
            <h3 class="text-3xl sm:text-4xl font-extrabold text-slate-900 tracking-tight">Cara Pesan Teknisi di {{ $area->district }}</h3>
            <p class="text-slate-600 text-sm sm:text-base mt-2">Cukup 3 langkah mudah, saluran mampet di hunian Anda langsung lancar kembali.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-slate-50 p-7 rounded-2xl border border-slate-200/80 hover:border-sky-300 hover:shadow-md transition-all text-center space-y-3 fade-up delay-100">
                <div class="w-12 h-12 rounded-2xl bg-sky-700 text-white font-extrabold text-lg flex items-center justify-center mx-auto shadow-xs">01</div>
                <h4 class="font-bold text-slate-900 text-lg">Hubungi WhatsApp</h4>
                <p class="text-xs sm:text-sm text-slate-600 leading-relaxed">Klik tombol WhatsApp dan kirim alamat lengkap atau foto sumbatan Anda di {{ $area->district }}, {{ $area->city }}.</p>
            </div>

            <div class="bg-slate-50 p-7 rounded-2xl border border-slate-200/80 hover:border-sky-300 hover:shadow-md transition-all text-center space-y-3 fade-up delay-200">
                <div class="w-12 h-12 rounded-2xl bg-sky-700 text-white font-extrabold text-lg flex items-center justify-center mx-auto shadow-xs">02</div>
                <h4 class="font-bold text-slate-900 text-lg">Teknisi Meluncur</h4>
                <p class="text-xs sm:text-sm text-slate-600 leading-relaxed">Teknisi berseragam rapi dari posko terdekat tiba di lokasi membawa mesin rooter spiral dalam 30–45 menit.</p>
            </div>

            <div class="bg-slate-50 p-7 rounded-2xl border border-slate-200/80 hover:border-sky-300 hover:shadow-md transition-all text-center space-y-3 fade-up delay-300">
                <div class="w-12 h-12 rounded-2xl bg-emerald-600 text-white font-extrabold text-lg flex items-center justify-center mx-auto shadow-xs">03</div>
                <h4 class="font-bold text-slate-900 text-lg">Tuntas & Bergaransi</h4>
                <p class="text-xs sm:text-sm text-slate-600 leading-relaxed">Pengerjaan selesai tanpa bongkar keramik, aliran air dites bersama, dan diberikan nota garansi resmi 30 hari.</p>
            </div>
        </div>
    </div>
</section>

<!-- ====================================================================
     5. WILAYAH JANGKAUAN LAINNYA
==================================================================== -->
<section class="py-14 sm:py-20 bg-slate-50 border-b border-slate-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-3xl mx-auto mb-10 fade-up">
            <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-white border border-slate-200 text-slate-800 text-xs font-bold rounded-full uppercase tracking-wider mb-2 shadow-2xs">
                POSKO STRATEGIS
            </span>
            <h3 class="text-2xl sm:text-3xl font-extrabold text-slate-900 mt-2 tracking-tight">Area Layanan Drainusantara Lainnya</h3>
            <p class="text-xs sm:text-sm text-slate-600 mt-1">Teknisi kami juga siaga di seluruh wilayah Jabodetabek, Semarang, dan Lampung.</p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Jabodetabek -->
            <div class="p-6 rounded-2xl bg-white border border-slate-200/90 shadow-sm fade-up delay-100">
                <div class="flex items-center gap-2 mb-4">
                    <span class="text-xs font-bold uppercase text-sky-800 bg-sky-50 px-3 py-1 rounded-full border border-sky-200">JABODETABEK</span>
                    <span class="text-xs text-slate-500 font-medium">10 Posko Siaga 24 Jam</span>
                </div>
                <div class="flex flex-wrap gap-2 text-xs">
                    <a href="{{ url('/area/jakarta-selatan/tebet') }}" class="px-3.5 py-2 rounded-xl bg-slate-50 hover:bg-white text-slate-800 hover:text-sky-700 font-semibold border border-slate-200 hover:border-sky-300 hover:shadow-2xs transition-all">Jakarta Selatan (Tebet)</a>
                    <a href="{{ url('/area/jakarta-timur/duren-sawit') }}" class="px-3.5 py-2 rounded-xl bg-slate-50 hover:bg-white text-slate-800 hover:text-sky-700 font-semibold border border-slate-200 hover:border-sky-300 hover:shadow-2xs transition-all">Jakarta Timur (Duren Sawit)</a>
                    <a href="{{ url('/area/jakarta-utara/kelapa-gading') }}" class="px-3.5 py-2 rounded-xl bg-slate-50 hover:bg-white text-slate-800 hover:text-sky-700 font-semibold border border-slate-200 hover:border-sky-300 hover:shadow-2xs transition-all">Jakarta Utara (Kelapa Gading)</a>
                    <a href="{{ url('/area/jakarta-pusat/kemayoran') }}" class="px-3.5 py-2 rounded-xl bg-slate-50 hover:bg-white text-slate-800 hover:text-sky-700 font-semibold border border-slate-200 hover:border-sky-300 hover:shadow-2xs transition-all">Jakarta Pusat (Kemayoran)</a>
                    <a href="{{ url('/area/jakarta-barat/kebon-jeruk') }}" class="px-3.5 py-2 rounded-xl bg-slate-50 hover:bg-white text-slate-800 hover:text-sky-700 font-semibold border border-slate-200 hover:border-sky-300 hover:shadow-2xs transition-all">Jakarta Barat (Kebon Jeruk)</a>
                    <a href="{{ url('/area/bogor/cibinong') }}" class="px-3.5 py-2 rounded-xl bg-slate-50 hover:bg-white text-slate-800 hover:text-sky-700 font-semibold border border-slate-200 hover:border-sky-300 hover:shadow-2xs transition-all">Bogor (Cibinong)</a>
                    <a href="{{ url('/area/depok-cinere/cinere') }}" class="px-3.5 py-2 rounded-xl bg-slate-50 hover:bg-white text-slate-800 hover:text-sky-700 font-semibold border border-slate-200 hover:border-sky-300 hover:shadow-2xs transition-all">Depok & Cinere</a>
                    <a href="{{ url('/area/tangerang-kota/cipondoh') }}" class="px-3.5 py-2 rounded-xl bg-slate-50 hover:bg-white text-slate-800 hover:text-sky-700 font-semibold border border-slate-200 hover:border-sky-300 hover:shadow-2xs transition-all">Tangerang Kota</a>
                    <a href="{{ url('/area/tangerang-selatan/serpong') }}" class="px-3.5 py-2 rounded-xl bg-slate-50 hover:bg-white text-slate-800 hover:text-sky-700 font-semibold border border-slate-200 hover:border-sky-300 hover:shadow-2xs transition-all">Tangerang Selatan (Serpong)</a>
                    <a href="{{ url('/area/bekasi-cikarang/cikarang-selatan') }}" class="px-3.5 py-2 rounded-xl bg-slate-50 hover:bg-white text-slate-800 hover:text-sky-700 font-semibold border border-slate-200 hover:border-sky-300 hover:shadow-2xs transition-all">Bekasi & Cikarang</a>
                </div>
            </div>

            <!-- Semarang & Lampung -->
            <div class="p-6 rounded-2xl bg-white border border-slate-200/90 shadow-sm fade-up delay-200">
                <div class="flex items-center gap-2 mb-4">
                    <span class="text-xs font-bold uppercase text-sky-800 bg-sky-50 px-3 py-1 rounded-full border border-sky-200">SEMARANG & LAMPUNG</span>
                    <span class="text-xs text-slate-500 font-medium">Kota Cabang Siaga</span>
                </div>
                <div class="flex flex-wrap gap-2 text-xs">
                    <a href="{{ url('/area/semarang/candisari') }}" class="px-3.5 py-2 rounded-xl bg-slate-50 hover:bg-white text-slate-800 hover:text-sky-700 font-semibold border border-slate-200 hover:border-sky-300 hover:shadow-2xs transition-all">Kota Semarang (Candisari)</a>
                    <a href="{{ url('/area/bandar-lampung/kedaton') }}" class="px-3.5 py-2 rounded-xl bg-slate-50 hover:bg-white text-slate-800 hover:text-sky-700 font-semibold border border-slate-200 hover:border-sky-300 hover:shadow-2xs transition-all">Bandar Lampung (Kedaton)</a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ====================================================================
     6. BOTTOM EMERGENCY STICKY CTA
==================================================================== -->
<section class="py-14 lg:py-20 bg-slate-900 text-white text-center border-t border-slate-800 relative overflow-hidden">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 relative fade-up">
        <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-slate-800 border border-slate-700 text-sky-400 text-xs font-bold rounded-full uppercase tracking-wider mb-3">
            RESPON CEPAT WILAYAH {{ strtoupper($area->district) }}
        </span>
        <h2 class="text-3xl sm:text-4xl font-extrabold tracking-tight">
            Saluran Air di {{ $area->district }} Mampet Hari Ini?
        </h2>
        <p class="text-slate-400 text-sm sm:text-base mt-3 max-w-xl mx-auto leading-relaxed">
            Teknisi kami siap melayani area {{ $area->district }}, {{ $area->city }} 24 jam sehari. Tanpa bongkar keramik, cepat, dan bergaransi resmi 30 hari.
        </p>

        <div class="mt-8 flex flex-col sm:flex-row items-center justify-center gap-4">
            <a href="{{ $emergencyWaUrl }}" target="_blank" rel="noopener noreferrer" 
               class="w-full sm:w-auto inline-flex items-center justify-center gap-3 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-base px-8 py-4 rounded-xl shadow-md transition-all">
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
