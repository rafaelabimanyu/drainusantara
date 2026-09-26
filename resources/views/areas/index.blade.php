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

        <div class="max-w-3xl space-y-4">
            <div class="inline-flex items-center gap-2 px-3.5 py-1.5 bg-white border border-slate-200 rounded-lg text-xs font-bold text-slate-800 shadow-2xs reveal-fade">
                <span class="w-2 h-2 bg-emerald-500 rounded-full animate-pulse"></span>
                <span>Armada Siaga &bull; Jabodetabek, Jawa Tengah, Lampung</span>
            </div>

            <h1 class="text-3xl sm:text-4xl md:text-5xl font-extrabold text-slate-900 tracking-tight leading-tight reveal-soft delay-100">
                Pusat Jangkauan Layanan Drainusantara
            </h1>

            <p class="text-base text-slate-600 leading-relaxed reveal-soft delay-200">
                Pilih provinsi dan kota administrasi Anda di bawah untuk melihat posko siaga teknisi terdekat, daftar kecamatan yang dilayani, serta layanan respon cepat WhatsApp.
            </p>

            <!-- Quick Province Jump Pills -->
            <div class="pt-2 flex flex-wrap gap-2 reveal-soft delay-300">
                @foreach($provinces as $provSlug => $province)
                    <a href="#prov-{{ $provSlug }}" class="px-3.5 py-1.5 rounded-lg bg-white hover:bg-sky-50 text-slate-700 hover:text-sky-700 text-xs font-semibold border border-slate-200 hover:border-sky-300 shadow-2xs transition-all flex items-center gap-1.5 btn-press">
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
            <div id="prov-{{ $provSlug }}" class="bg-slate-50 hover:bg-slate-50/80 rounded-xl p-6 sm:p-8 border border-slate-200 shadow-sm transition-all reveal-soft card-lift delay-{{ min(($loop->iteration - 1) * 100, 300) }}">
                <!-- Province Header -->
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-6 border-b border-slate-200">
                    <div>
                        <div class="flex items-center gap-2 mb-2">
                            <span class="text-xs uppercase font-bold text-sky-800 bg-sky-50 px-3 py-0.5 rounded-md border border-sky-200">
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
                           class="inline-flex items-center gap-2 text-xs font-bold text-sky-700 hover:text-sky-800 bg-white hover:bg-sky-50 border border-slate-200 hover:border-sky-300 px-4 py-2.5 rounded-lg transition-all shadow-xs btn-press">
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
                        <div class="bg-white rounded-xl border border-slate-200 hover:border-sky-300 hover:shadow-md p-6 transition-all flex flex-col justify-between group card-lift">
                            <div>
                                <div class="flex items-center justify-between mb-3">
                                    <span class="text-xs font-bold text-sky-700 bg-sky-50 px-2.5 py-0.5 rounded-md border border-sky-200">
                                        {{ $city['type'] }}
                                    </span>
                                    <span class="text-[11px] text-emerald-800 font-bold bg-emerald-50 px-2.5 py-0.5 rounded-md border border-emerald-200 flex items-center gap-1">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                        <span>Respon Cepat</span>
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
                                               class="px-2 py-0.5 rounded-md bg-slate-50 hover:bg-sky-50 hover:text-sky-700 border border-slate-200 transition-colors">
                                                {{ $district }}
                                            </a>
                                        @endforeach
                                        @if(count($city['districts']) > 5)
                                            <a href="{{ route('area.city', ['city' => $citySlug]) }}" class="px-2 py-0.5 rounded-md bg-slate-100 text-slate-500 text-[11px] font-semibold hover:bg-slate-200 transition-colors">
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
                                   class="inline-flex items-center gap-1.5 text-xs font-bold text-white bg-emerald-600 hover:bg-emerald-700 px-3 py-1.5 rounded-lg shadow-2xs transition-colors btn-press">
                                    <svg class="w-3.5 h-3.5 fill-current shrink-0" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/></svg>
                                    <span>Panggil WA</span>
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
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center reveal-fade">
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
               class="min-h-[48px] inline-flex items-center justify-center gap-2.5 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-sm px-6 py-3.5 rounded-xl shadow-md transition-all btn-press">
                <svg class="w-4 h-4 fill-current shrink-0" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/></svg>
                <span>Konsultasi Wilayah via WhatsApp</span>
            </a>
            <a href="{{ url('/') }}" 
               class="min-h-[48px] inline-flex items-center justify-center gap-2 bg-slate-800 hover:bg-slate-700 text-slate-200 font-bold text-sm px-6 py-3.5 rounded-xl border border-slate-700 transition-colors btn-press">
                <span>Kembali ke Beranda</span>
            </a>
        </div>
    </div>
</section>
@endsection
