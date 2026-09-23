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
<section class="relative bg-slate-50 border-b border-slate-200 pt-8 pb-14 lg:pt-12 lg:pb-18 overflow-hidden">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <!-- Breadcrumb -->
        <nav class="flex items-center gap-2 text-xs text-slate-500 mb-6 flex-wrap font-medium" aria-label="Breadcrumb">
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

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-10 items-center">
            <div class="lg:col-span-8 space-y-4 fade-up">
                <div class="inline-flex items-center gap-2 px-3.5 py-1.5 bg-white border border-slate-200 rounded-full text-xs font-bold text-slate-800 shadow-2xs">
                    <span class="w-2 h-2 bg-emerald-500 rounded-full animate-pulse"></span>
                    <span>Posko Siaga Provinsi {{ $provinceData['name'] }} &bull; 24 Jam</span>
                </div>

                <h1 class="text-3xl sm:text-4xl md:text-5xl font-extrabold text-slate-900 tracking-tight leading-tight">
                    Jasa Saluran Pipa Mampet <span class="text-sky-700">Provinsi {{ $provinceData['name'] }}</span>
                </h1>

                <p class="text-base text-slate-600 leading-relaxed max-w-2xl">
                    {{ $provinceData['description'] }} Dikerjakan teknisi profesional berseragam rapi dengan mesin rooter spiral mekanis torsi fleksibel tanpa membongkar keramik lantai hunian Anda.
                </p>

                <!-- Action Buttons -->
                <div class="flex flex-wrap items-center gap-3 pt-2">
                    <a href="{{ $waUrl }}" target="_blank" rel="noopener noreferrer" 
                       class="inline-flex items-center gap-2 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-sm px-6 py-3.5 rounded-xl shadow-sm hover:shadow transition-all">
                        <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24">
                            <path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/>
                        </svg>
                        <span>Hubungi Teknisi {{ $provinceData['name'] }}</span>
                    </a>
                    <a href="#daftar-kota" 
                       class="inline-flex items-center gap-2 bg-white hover:bg-slate-50 text-slate-800 font-bold text-sm px-5 py-3.5 rounded-xl border border-slate-200 shadow-xs transition-colors">
                        <span>Pilih Kota / Kabupaten</span>
                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </a>
                </div>
            </div>

            <!-- Stats Modern Card -->
            <div class="lg:col-span-4 fade-up delay-100">
                <div class="bg-white p-6 rounded-2xl border border-slate-200/90 shadow-sm space-y-4">
                    <span class="text-xs uppercase tracking-wider text-sky-700 font-bold block">RINGKASAN CAKUPAN:</span>
                    <div class="space-y-3 text-xs sm:text-sm text-slate-600">
                        <div class="flex justify-between items-center border-b border-slate-100 pb-2.5">
                            <span class="font-medium text-slate-500">Jumlah Wilayah:</span>
                            <span class="font-bold text-slate-900">{{ count($provinceData['cities']) }} Kota / Kabupaten</span>
                        </div>
                        <div class="flex justify-between items-center border-b border-slate-100 pb-2.5">
                            <span class="font-medium text-slate-500">Estimasi Tiba:</span>
                            <span class="font-bold text-emerald-700 bg-emerald-50 px-2 py-0.5 rounded-full border border-emerald-200">30 - 45 Menit</span>
                        </div>
                        <div class="flex justify-between items-center border-b border-slate-100 pb-2.5">
                            <span class="font-medium text-slate-500">Metode Kerja:</span>
                            <span class="font-bold text-slate-900">100% Tanpa Bongkar</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="font-medium text-slate-500">Jaminan Garansi:</span>
                            <span class="font-bold text-amber-800 bg-amber-50 px-2 py-0.5 rounded-full border border-amber-200">Garansi Resmi 30 Hari</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ====================================================================
     DAFTAR KOTA & KECAMATAN DI PROVINSI INI
==================================================================== -->
<section id="daftar-kota" class="py-14 lg:py-20 bg-white border-b border-slate-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="max-w-2xl mb-10 fade-up">
            <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-sky-50 border border-sky-200 text-sky-800 text-xs font-bold rounded-full uppercase tracking-wider mb-2">
                KOTA & KABUPATEN
            </span>
            <h2 class="text-3xl sm:text-4xl font-extrabold text-slate-900 tracking-tight">
                Pilih Kota Anda di Provinsi {{ $provinceData['name'] }}
            </h2>
            <p class="text-slate-600 text-sm sm:text-base mt-2 leading-relaxed">
                Klik nama kota untuk melihat posko spesifik, atau klik langsung nama kecamatan Anda di bawahnya untuk estimasi penanganan.
            </p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            @foreach($provinceData['cities'] as $citySlug => $city)
                <div class="bg-slate-50/60 rounded-2xl border border-slate-200/90 p-6 sm:p-7 hover:border-sky-300 hover:shadow-md transition-all fade-up">
                    <div class="flex flex-col sm:flex-row sm:items-start justify-between gap-4 pb-5 border-b border-slate-200/80">
                        <div>
                            <div class="flex items-center gap-2 mb-2">
                                <span class="text-xs font-bold text-sky-700 bg-sky-50 px-2.5 py-0.5 rounded-full border border-sky-200">
                                    {{ $city['type'] }}
                                </span>
                                <span class="text-xs text-emerald-800 font-bold bg-emerald-50 px-2.5 py-0.5 rounded-full border border-emerald-200 flex items-center gap-1">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                    <span>Posko Siaga {{ $city['eta_minutes'] }}</span>
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
                           class="inline-flex items-center gap-1.5 text-xs font-bold text-white bg-sky-700 hover:bg-sky-800 px-4 py-2.5 rounded-xl transition-colors shrink-0 shadow-xs">
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
                                   class="p-2.5 rounded-xl bg-white hover:bg-sky-50 border border-slate-200/80 hover:border-sky-300 text-slate-800 hover:text-sky-700 font-semibold transition-all truncate flex items-center gap-1.5">
                                    <span class="w-1.5 h-1.5 rounded-full bg-slate-300 shrink-0"></span>
                                    <span class="truncate">{{ $district }}</span>
                                </a>
                            @endforeach
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
<section class="py-14 lg:py-20 bg-slate-900 text-white">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center fade-up">
        <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-slate-800 border border-slate-700 text-sky-400 text-xs font-bold rounded-full uppercase tracking-wider mb-3">
            RESPON CEPAT PROVINSI {{ strtoupper($provinceData['name']) }}
        </span>
        <h2 class="text-3xl sm:text-4xl font-extrabold text-white tracking-tight">
            Saluran Pipa di Lokasi Anda Tersumbat Hari Ini?
        </h2>
        <p class="text-slate-400 text-sm sm:text-base mt-3 max-w-xl mx-auto leading-relaxed">
            Teknisi kami siap meluncur ke seluruh penjuru {{ $provinceData['name'] }} dalam 30–45 menit. Bebas biaya bongkar dan dilindungi garansi 30 hari.
        </p>
        <div class="mt-8 flex flex-col sm:flex-row items-center justify-center gap-4">
            <a href="{{ $waUrl }}" target="_blank" rel="noopener noreferrer" 
               class="inline-flex items-center gap-2 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-sm px-6 py-3.5 rounded-xl shadow-md transition-all">
                <span>Panggil Teknisi via WhatsApp</span>
                <span class="text-base">&rarr;</span>
            </a>
            <a href="{{ route('area.index') }}" 
               class="inline-flex items-center gap-2 bg-slate-800 hover:bg-slate-700 text-slate-200 font-bold text-sm px-6 py-3.5 rounded-xl border border-slate-700 transition-colors">
                <span>Lihat Provinsi Lainnya</span>
            </a>
        </div>
    </div>
</section>
@endsection
