@extends('layouts.app')

@section('content')
@php
    $whatsappNumber = config('app.whatsapp_number') ?: '6281234567890';
    $waMsg = urlencode("Halo Drainusantara, saya butuh penanganan pipa mampet di Provinsi {$provinceData['name']}. Mohon info armada teknisi terdekat.");
    $waUrl = "https://wa.me/{$whatsappNumber}?text={$waMsg}";
@endphp

<!-- ====================================================================
     HERO SECTION PROVINSI
==================================================================== -->
<section class="relative bg-slate-50 border-b border-slate-200 pt-5 pb-8 sm:pt-8 sm:pb-14 lg:pt-12 lg:pb-18 overflow-hidden">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <!-- Breadcrumb: Compact Backlink on Mobile, Full on Desktop -->
        <div class="sm:hidden mb-3 reveal-fade">
            <a href="{{ route('area.index') }}" 
               class="inline-flex items-center gap-1.5 text-xs font-semibold text-slate-600 hover:text-sky-700 transition-colors">
                <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
                <span>Direktori Wilayah</span>
            </a>
        </div>

        <nav class="hidden sm:flex items-center gap-2 text-xs text-slate-500 mb-6 flex-wrap font-medium reveal-fade" aria-label="Breadcrumb">
            <a href="{{ url('/') }}" class="hover:text-sky-700 transition-colors flex items-center gap-1.5">
                <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                </svg>
                <span>Beranda</span>
            </a>
            <span class="text-slate-300">/</span>
            <a href="{{ route('area.index') }}" class="hover:text-sky-700 transition-colors">Direktori Wilayah</a>
            <span class="text-slate-300">/</span>
            <span class="text-sky-700 font-bold">Provinsi {{ $provinceData['name'] }}</span>
        </nav>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 lg:gap-10 items-center">
            <div class="lg:col-span-8 space-y-4 sm:space-y-5">
                <div class="inline-flex items-center gap-2 px-3 py-1 bg-white border border-slate-200 rounded-lg text-xs font-bold text-slate-800 shadow-2xs reveal-fade delay-50">
                    <span class="w-2 h-2 bg-emerald-500 rounded-full animate-pulse"></span>
                    <span class="sm:hidden">Provinsi {{ $provinceData['name'] }} &bull; Respon Cepat</span>
                    <span class="hidden sm:inline">Posko Siaga: Provinsi {{ $provinceData['name'] }} &bull; Respon Cepat</span>
                </div>

                <h1 class="text-2xl sm:text-4xl md:text-5xl font-extrabold text-slate-900 tracking-tight leading-snug sm:leading-tight reveal-soft delay-100">
                    Jasa Saluran Pipa Mampet <span class="text-sky-700">Provinsi {{ $provinceData['name'] }}</span>
                </h1>

                <p class="text-sm sm:text-base text-slate-600 leading-relaxed max-w-2xl reveal-soft delay-150">
                    Pelancaran wastafel, kloset toilet, dan saluran mampet di seluruh kota &amp; kabupaten <strong>Provinsi {{ $provinceData['name'] }}</strong>. Dikerjakan mekanis tanpa bongkar dan bergaransi 30 hari.
                </p>

                <!-- Estimasi Respon & Highlights: 3 Compact Pills on Mobile with Stagger Delays -->
                <div class="grid grid-cols-3 gap-2 sm:gap-3 pt-1">
                    <div class="bg-white p-2.5 sm:p-3.5 rounded-lg border border-slate-200 shadow-2xs flex flex-col sm:flex-row items-center sm:items-center gap-1.5 sm:gap-3 text-center sm:text-left card-lift reveal-soft stagger-1">
                        <div class="w-8 h-8 sm:w-10 sm:h-10 rounded-md bg-sky-50 border border-sky-200 text-sky-700 flex items-center justify-center shrink-0">
                            <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <div class="min-w-0">
                            <div class="text-[10px] sm:text-[11px] text-slate-500 font-medium leading-tight">Respon WA</div>
                            <div class="text-xs sm:text-sm font-extrabold text-emerald-700 truncate">Respon Cepat</div>
                        </div>
                    </div>

                    <div class="bg-white p-2.5 sm:p-3.5 rounded-lg border border-slate-200 shadow-2xs flex flex-col sm:flex-row items-center sm:items-center gap-1.5 sm:gap-3 text-center sm:text-left card-lift reveal-soft stagger-2">
                        <div class="w-8 h-8 sm:w-10 sm:h-10 rounded-md bg-amber-50 border border-amber-200 text-amber-700 flex items-center justify-center shrink-0">
                            <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                            </svg>
                        </div>
                        <div class="min-w-0">
                            <div class="text-[10px] sm:text-[11px] text-slate-500 font-medium leading-tight">Garansi</div>
                            <div class="text-xs sm:text-sm font-extrabold text-slate-900 truncate">Garansi 30 Hari</div>
                        </div>
                    </div>

                    <div class="bg-white p-2.5 sm:p-3.5 rounded-lg border border-slate-200 shadow-2xs flex flex-col sm:flex-row items-center sm:items-center gap-1.5 sm:gap-3 text-center sm:text-left card-lift reveal-soft stagger-3">
                        <div class="w-8 h-8 sm:w-10 sm:h-10 rounded-md bg-emerald-50 border border-emerald-200 text-emerald-700 flex items-center justify-center shrink-0">
                            <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                            </svg>
                        </div>
                        <div class="min-w-0">
                            <div class="text-[10px] sm:text-[11px] text-slate-500 font-medium leading-tight">Metode</div>
                            <div class="text-xs sm:text-sm font-extrabold text-slate-900 truncate">Tanpa Bongkar</div>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-2.5 sm:gap-3 pt-1 reveal-soft delay-200">
                    <a href="{{ $waUrl }}" target="_blank" rel="noopener noreferrer" 
                       class="min-h-[48px] inline-flex items-center justify-center gap-2.5 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-sm sm:text-base px-6 py-3 rounded-lg shadow-sm hover:shadow transition-all btn-press">
                        <svg class="w-4 h-4 fill-current shrink-0" viewBox="0 0 24 24">
                            <path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/>
                        </svg>
                        <span>Hubungi Teknisi {{ $provinceData['name'] }}</span>
                    </a>
                    <a href="#daftar-kota" 
                       class="min-h-[44px] inline-flex items-center justify-center gap-2 bg-white hover:bg-slate-50 text-slate-800 font-bold text-xs sm:text-sm px-5 py-2.5 rounded-lg border border-slate-200 shadow-2xs transition-colors btn-press">
                        <span>Pilih Kota / Kabupaten ({{ count($provinceData['cities']) }})</span>
                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </a>
                </div>
            </div>

            <!-- Stats Modern Card -->
            <div class="lg:col-span-4 reveal-soft delay-150">
                <div class="bg-white p-4 sm:p-6 rounded-xl border border-slate-200 shadow-sm space-y-3 sm:space-y-4 card-lift">
                    <span class="text-[11px] sm:text-xs uppercase tracking-wider text-sky-700 font-bold block">RINGKASAN CAKUPAN:</span>
                    <div class="space-y-2.5 sm:space-y-3 text-xs sm:text-sm text-slate-600">
                        <div class="flex justify-between items-center border-b border-slate-100 pb-2 sm:pb-2.5">
                            <span class="font-medium text-slate-500">Jumlah Wilayah:</span>
                            <span class="font-bold text-slate-900">{{ count($provinceData['cities']) }} Kota / Kabupaten</span>
                        </div>
                        <div class="flex justify-between items-center border-b border-slate-100 pb-2 sm:pb-2.5">
                            <span class="font-medium text-slate-500">Respon WhatsApp:</span>
                            <span class="font-bold text-emerald-700 bg-emerald-50 px-2 py-0.5 rounded-md border border-emerald-200">Respon Cepat</span>
                        </div>
                        <div class="flex justify-between items-center border-b border-slate-100 pb-2 sm:pb-2.5">
                            <span class="font-medium text-slate-500">Metode Kerja:</span>
                            <span class="font-bold text-slate-900">Tanpa Bongkar</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="font-medium text-slate-500">Jaminan Garansi:</span>
                            <span class="font-bold text-amber-800 bg-amber-50 px-2 py-0.5 rounded-md border border-amber-200">Garansi 30 Hari</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ====================================================================
     DAFTAR KOTA & KECAMATAN DI PROVINSI INI
=================================================================== -->
<section id="daftar-kota" class="py-14 lg:py-20 bg-white border-b border-slate-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="max-w-2xl mb-10 reveal-soft">
            <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-sky-50 border border-sky-200 text-sky-800 text-xs font-bold rounded-md uppercase tracking-wider mb-2">
                KOTA & KABUPATEN
            </span>
            <h2 class="text-3xl sm:text-4xl font-extrabold text-slate-900 tracking-tight">
                Pilih Kota Anda di Provinsi {{ $provinceData['name'] }}
            </h2>
            <p class="text-slate-600 text-sm sm:text-base mt-2 leading-relaxed">
                Pilih kota untuk melihat posko spesifik, atau klik langsung nama kecamatan Anda di bawahnya untuk respon cepat teknisi.
            </p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            @foreach($provinceData['cities'] as $citySlug => $city)
                <div class="bg-slate-50 hover:bg-white rounded-xl border border-slate-200 p-6 sm:p-7 hover:border-sky-300 hover:shadow-md transition-all card-lift reveal-soft delay-{{ min($loop->iteration * 75, 300) }} flex flex-col justify-between">
                    <div>
                        <div class="flex flex-col sm:flex-row sm:items-start justify-between gap-4 pb-5 border-b border-slate-200">
                            <div>
                                <div class="flex items-center gap-2 mb-2">
                                    <span class="text-xs font-bold text-sky-700 bg-sky-50 px-2.5 py-0.5 rounded-md border border-sky-200">
                                        {{ $city['type'] }}
                                    </span>
                                    <span class="text-xs text-emerald-800 font-bold bg-emerald-50 px-2.5 py-0.5 rounded-md border border-emerald-200 flex items-center gap-1">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                        <span>Armada Siaga &bull; Respon Cepat</span>
                                    </span>
                                </div>
                                <h3 class="text-xl font-bold text-slate-900 tracking-tight">
                                    <a href="{{ route('area.city', ['city' => $citySlug]) }}" class="hover:text-sky-700 transition-colors">
                                        {{ $city['name'] }}
                                    </a>
                                </h3>
                                <p class="text-xs text-slate-500 mt-1">
                                    {{ $city['posko_address'] }}
                                </p>
                            </div>

                            <a href="{{ route('area.city', ['city' => $citySlug]) }}" 
                               class="inline-flex items-center gap-1.5 text-xs font-bold text-white bg-sky-700 hover:bg-sky-800 px-4 py-2.5 rounded-lg transition-colors shrink-0 shadow-xs btn-press">
                                <span>Buka Halaman Kota</span>
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                </svg>
                            </a>
                        </div>

                        <!-- Kecamatan Links List -->
                        <div class="mt-5">
                            <span class="text-xs text-slate-500 uppercase font-bold tracking-wider block mb-3">
                                PILIH KECAMATAN DI {{ strtoupper($city['name']) }}:
                            </span>
                            <div class="grid grid-cols-2 sm:grid-cols-3 gap-2 text-xs">
                                @foreach($city['districts'] as $district)
                                    @php
                                        $districtSlug = \Illuminate\Support\Str::slug($district);
                                    @endphp
                                    <a href="{{ route('area.detail', ['city' => $citySlug, 'district' => $districtSlug]) }}" 
                                       class="p-2.5 rounded-lg bg-white hover:bg-sky-50 border border-slate-200 hover:border-sky-300 text-slate-800 hover:text-sky-700 font-semibold transition-all truncate flex items-center gap-1.5 btn-press">
                                        <span class="w-1.5 h-1.5 rounded-full bg-slate-300 shrink-0"></span>
                                        <span class="truncate">{{ $district }}</span>
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

<!-- ====================================================================
     BOTTOM CTA PROVINSI
==================================================================== -->
<section class="py-14 lg:py-20 bg-slate-900 text-white relative overflow-hidden reveal-soft">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center reveal-scale delay-100">
        <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-slate-800 border border-slate-700 text-sky-400 text-xs font-bold rounded-full uppercase tracking-wider mb-3">
            RESPON CEPAT PROVINSI {{ strtoupper($provinceData['name']) }}
        </span>
        <h2 class="text-3xl sm:text-4xl font-extrabold text-white tracking-tight">
            Saluran Pipa di Lokasi Anda Tersumbat Hari Ini?
        </h2>
        <p class="text-slate-400 text-sm sm:text-base mt-3 max-w-xl mx-auto leading-relaxed">
            Tim kami siap memberikan respon WhatsApp sigap dan cepat ke seluruh penjuru {{ $provinceData['name'] }}. Bebas biaya bongkar dan dilindungi garansi 30 hari.
        </p>
        <div class="mt-8 flex flex-col sm:flex-row items-center justify-center gap-4">
            <a href="{{ $waUrl }}" target="_blank" rel="noopener noreferrer" 
               class="min-h-[48px] inline-flex items-center justify-center gap-2.5 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-sm px-6 py-3.5 rounded-xl shadow-md transition-all btn-press">
                <svg class="w-4 h-4 fill-current shrink-0" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/></svg>
                <span>Panggil Teknisi via WhatsApp</span>
            </a>
            <a href="{{ route('area.index') }}" 
               class="min-h-[48px] inline-flex items-center justify-center gap-2 bg-slate-800 hover:bg-slate-700 text-slate-200 font-bold text-sm px-6 py-3.5 rounded-xl border border-slate-700 transition-colors btn-press">
                <span>Lihat Provinsi Lainnya</span>
            </a>
        </div>
    </div>
</section>
@endsection
