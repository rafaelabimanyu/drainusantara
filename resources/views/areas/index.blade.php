@extends('layouts.app')

@section('content')
@php
    $whatsappNumber = config('app.whatsapp_number') ?: '6281234567890';
    $generalWaUrl = "https://wa.me/{$whatsappNumber}?text=" . urlencode("Halo Admin Drainusantara, saya ingin cek ketersediaan teknisi saluran mampet untuk wilayah saya.");
@endphp

<!-- ====================================================================
     HERO & DIREKTORI WILAYAH UTAMA
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
            <span class="text-sky-700 font-bold">Direktori Wilayah Layanan</span>
        </nav>

        <div class="max-w-3xl space-y-4 fade-up">
            <div class="inline-flex items-center gap-2 px-3.5 py-1.5 bg-white border border-slate-200 rounded-full text-xs font-bold text-slate-800 shadow-2xs">
                <span class="w-2 h-2 bg-emerald-500 rounded-full animate-pulse"></span>
                <span>Armada Siaga 24 Jam &bull; Jabodetabek, Jawa Tengah, Lampung</span>
            </div>

            <h1 class="text-3xl sm:text-4xl md:text-5xl font-extrabold text-slate-900 tracking-tight leading-tight">
                Pusat Jangkauan Layanan Drainusantara
            </h1>

            <p class="text-base text-slate-600 leading-relaxed">
                Pilih provinsi dan kota administrasi Anda di bawah untuk melihat posko siaga teknisi terdekat, daftar kecamatan yang dilayani, serta estimasi waktu tiba (30–45 menit).
            </p>

            <!-- Quick Province Jump Pills -->
            <div class="pt-2 flex flex-wrap gap-2">
                @foreach($provinces as $provSlug => $province)
                    <a href="#prov-{{ $provSlug }}" class="px-3.5 py-1.5 rounded-xl bg-white hover:bg-sky-50 text-slate-700 hover:text-sky-700 text-xs font-semibold border border-slate-200 hover:border-sky-300 shadow-2xs transition-all flex items-center gap-1.5">
                        <span class="w-1.5 h-1.5 rounded-full bg-sky-500"></span>
                        <span>{{ $province['name'] }}</span>
                    </a>
                @endforeach
            </div>
        </div>
    </div>
</section>

<!-- ====================================================================
     DAFTAR PER PROVINSI & KOTA LAYANAN
==================================================================== -->
<section class="py-14 lg:py-20 bg-white border-b border-slate-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-12">
        @foreach($provinces as $provSlug => $province)
            <div id="prov-{{ $provSlug }}" class="bg-slate-50/50 rounded-2xl p-6 sm:p-8 border border-slate-200/90 shadow-sm hover:shadow-md transition-all fade-up">
                <!-- Province Header -->
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-6 border-b border-slate-200/80">
                    <div>
                        <div class="flex items-center gap-2 mb-2">
                            <span class="text-xs uppercase font-bold text-sky-800 bg-sky-50 px-3 py-0.5 rounded-full border border-sky-200">
                                PROVINSI
                            </span>
                            <span class="text-xs text-slate-500 font-medium">{{ count($province['cities']) }} Kota / Wilayah Siaga</span>
                        </div>
                        <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">
                            {{ $province['name'] }}
                        </h2>
                        <p class="text-xs sm:text-sm text-slate-600 mt-1 max-w-2xl leading-relaxed">
                            {{ $province['description'] }}
                        </p>
                    </div>

                    <div>
                        <a href="{{ route('area.province', ['province' => $provSlug]) }}" 
                           class="inline-flex items-center gap-2 text-xs font-bold text-sky-700 hover:text-sky-800 bg-white hover:bg-sky-50 border border-slate-200 hover:border-sky-300 px-4 py-2.5 rounded-xl transition-all shadow-xs">
                            <span>Buka Halaman {{ $province['name'] }}</span>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                            </svg>
                        </a>
                    </div>
                </div>

                <!-- Cities in this Province -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5 mt-6">
                    @foreach($province['cities'] as $citySlug => $city)
                        <div class="bg-white rounded-2xl border border-slate-200 hover:border-sky-300 hover:shadow-md p-6 transition-all flex flex-col justify-between group">
                            <div>
                                <div class="flex items-center justify-between mb-3">
                                    <span class="text-xs font-bold text-sky-700 bg-sky-50 px-2.5 py-0.5 rounded-full border border-sky-200">
                                        {{ $city['type'] }}
                                    </span>
                                    <span class="text-[11px] text-emerald-800 font-bold bg-emerald-50 px-2.5 py-0.5 rounded-full border border-emerald-200 flex items-center gap-1">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                        <span>ETA {{ $city['eta_minutes'] }}</span>
                                    </span>
                                </div>

                                <h3 class="text-lg font-bold text-slate-900 group-hover:text-sky-700 transition-colors tracking-tight">
                                    <a href="{{ route('area.city', ['city' => $citySlug]) }}">
                                        {{ $city['name'] }}
                                    </a>
                                </h3>

                                <div class="mt-3 pt-3 border-t border-slate-100">
                                    <span class="text-[11px] text-slate-400 font-bold uppercase tracking-wider block mb-2">
                                        {{ count($city['districts']) }} KECAMATAN SIAGA:
                                    </span>
                                    <div class="flex flex-wrap gap-1.5 text-xs text-slate-600">
                                        @foreach(array_slice($city['districts'], 0, 5) as $district)
                                            <a href="{{ route('area.detail', ['city' => $citySlug, 'district' => \Illuminate\Support\Str::slug($district)]) }}" 
                                               class="px-2 py-0.5 rounded-lg bg-slate-50 hover:bg-sky-50 hover:text-sky-700 border border-slate-200/80 transition-colors">
                                                {{ $district }}
                                            </a>
                                        @endforeach
                                        @if(count($city['districts']) > 5)
                                            <a href="{{ route('area.city', ['city' => $citySlug]) }}" class="px-2 py-0.5 rounded-lg bg-slate-100 text-slate-500 text-[11px] font-semibold hover:bg-slate-200 transition-colors">
                                                +{{ count($city['districts']) - 5 }} lainnya
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="mt-5 pt-4 border-t border-slate-100 flex items-center justify-between gap-2">
                                <a href="{{ route('area.city', ['city' => $citySlug]) }}" 
                                   class="text-xs font-bold text-sky-700 hover:text-sky-800 inline-flex items-center gap-1">
                                    <span>Lihat Kecamatan</span>
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                    </svg>
                                </a>

                                <a href="https://wa.me/{{ $whatsappNumber }}?text={{ urlencode('Halo Drainusantara, saya butuh penanganan pipa mampet di area ' . $city['name'] . '. Mohon info kedatangan teknisi.') }}"
                                   target="_blank" 
                                   rel="noopener noreferrer" 
                                   class="inline-flex items-center gap-1.5 text-xs font-bold text-white bg-emerald-600 hover:bg-emerald-700 px-3 py-1.5 rounded-xl shadow-2xs transition-colors">
                                    <span>Panggil WA</span>
                                    <span>&rarr;</span>
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endforeach
    </div>
</section>

<!-- ====================================================================
     BOTTOM CTA
==================================================================== -->
<section class="py-14 lg:py-20 bg-slate-900 text-white">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center fade-up">
        <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-slate-800 border border-slate-700 text-sky-400 text-xs font-bold rounded-full uppercase tracking-wider mb-3">
            KONSULTASI AREA
        </span>
        <h2 class="text-3xl sm:text-4xl font-extrabold text-white tracking-tight">
            Wilayah Hunian Anda Belum Terdaftar?
        </h2>
        <p class="text-slate-400 text-sm sm:text-base mt-3 max-w-xl mx-auto leading-relaxed">
            Hubungi customer service Drainusantara untuk mengecek ketersediaan rute dan penjadwalan armada teknisi terdekat langsung ke lokasi Anda.
        </p>
        <div class="mt-8 flex flex-col sm:flex-row items-center justify-center gap-4">
            <a href="{{ $generalWaUrl }}" target="_blank" rel="noopener noreferrer" 
               class="inline-flex items-center gap-2 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-sm px-6 py-3.5 rounded-xl shadow-md transition-all">
                <span>Konsultasi Wilayah via WhatsApp</span>
                <span class="text-base">&rarr;</span>
            </a>
            <a href="{{ url('/') }}" 
               class="inline-flex items-center gap-2 bg-slate-800 hover:bg-slate-700 text-slate-200 font-bold text-sm px-6 py-3.5 rounded-xl border border-slate-700 transition-colors">
                <span>Kembali ke Beranda</span>
            </a>
        </div>
    </div>
</section>
@endsection
