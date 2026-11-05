@extends('layouts.app')

@section('content')
@php
    $whatsappNumber = config('app.whatsapp_number') ?: '6285609009009';
    $waText = urlencode("Halo Admin Drainusantara, saya mendapatkan notifikasi akses ditolak (403) di website dan ingin berkonsultasi mengenai pemesanan layanan pipa mampet.");
    $waUrl = "https://wa.me/{$whatsappNumber}?text={$waText}";

    $popularServices = [
        [
            'title' => 'Wastafel & Cuci Piring',
            'desc' => 'Pelancaran lemak beku dan sisa makanan di pipa leher angsa.',
            'url' => url('/#layanan'),
        ],
        [
            'title' => 'Kloset & Toilet Meluap',
            'desc' => 'Penanganan tuntas tanpa bongkar dudukan kloset porselen.',
            'url' => url('/#layanan'),
        ],
        [
            'title' => 'Floor Drain Kamar Mandi',
            'desc' => 'Pembersihan endapan rambut rontok dan kerak residu sabun.',
            'url' => url('/#layanan'),
        ],
        [
            'title' => 'Inspeksi Kamera CCTV 30M',
            'desc' => 'Deteksi visual retak atau jalur pipa tersembunyi di dinding.',
            'url' => url('/#layanan'),
        ],
    ];
@endphp

<div class="py-12 sm:py-16 lg:py-24 bg-slate-50 border-b border-slate-200">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Header Status Card -->
        <div class="bg-white border border-slate-200 rounded-2xl p-6 sm:p-10 md:p-12 text-center shadow-xs">
            
            <!-- HTTP Status Eyebrow -->
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-md border border-slate-300 bg-slate-100 text-xs font-mono font-bold tracking-wider text-slate-800 uppercase mb-4">
                <span>Status HTTP 403: Akses Terbatas / Ditolak</span>
            </div>

            <!-- Technical Vector Illustration: Security Shield & Padlock -->
            <div class="flex justify-center mb-6">
                <div class="w-24 h-24 sm:w-28 sm:h-28 rounded-2xl bg-slate-100 border border-slate-300 flex items-center justify-center text-slate-700 p-4">
                    <svg class="w-full h-full" viewBox="0 0 96 96" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                        <!-- Shield Outline -->
                        <path d="M48 14L20 26V46C20 64 32 80 48 86C64 80 76 64 76 46V26L48 14Z" fill="#F1F5F9" stroke="#334155" stroke-width="3" stroke-linejoin="round"/>
                        <!-- Keyhole / Padlock inside Shield -->
                        <rect x="36" y="44" width="24" height="20" rx="3" fill="#FFFFFF" stroke="#1E293B" stroke-width="2.5"/>
                        <path d="M41 44V37C41 33.134 44.134 30 48 30C51.866 30 55 33.134 55 37V44" stroke="#1E293B" stroke-width="2.5" stroke-linecap="round"/>
                        <circle cx="48" cy="53" r="2" fill="#0F172A"/>
                        <path d="M48 55V59" stroke="#0F172A" stroke-width="2" stroke-linecap="round"/>
                    </svg>
                </div>
            </div>

            <!-- Big Status Code & Headline -->
            <div class="relative mb-3">
                <span class="text-6xl sm:text-7xl md:text-8xl font-black text-slate-100 select-none tracking-tight block">403</span>
                <h1 class="text-2xl sm:text-3xl md:text-4xl font-extrabold text-slate-900 tracking-tight -mt-6 sm:-mt-8 relative">
                    Akses Halaman Dibatasi oleh Sistem
                </h1>
            </div>

            <!-- Descriptive Context Text -->
            <p class="text-slate-600 text-sm sm:text-base max-w-xl mx-auto leading-relaxed mb-8">
                Halaman atau direktori yang Anda tuju memerlukan izin akses administratif khusus atau telah diproteksi oleh protokol keamanan server Drainusantara.
            </p>

            <!-- Action Buttons: Beranda & WhatsApp -->
            <div class="flex flex-col sm:flex-row items-center justify-center gap-3.5 max-w-md mx-auto">
                <a href="{{ url('/') }}" 
                   class="w-full sm:w-auto inline-flex items-center justify-center gap-2 bg-sky-700 hover:bg-sky-800 text-white font-bold text-sm px-6 py-3 rounded-lg transition-colors shadow-2xs">
                    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                    </svg>
                    <span>Kembali ke Beranda</span>
                </a>

                <a href="{{ $waUrl }}" 
                   target="_blank" 
                   rel="noopener noreferrer" 
                   class="w-full sm:w-auto inline-flex items-center justify-center gap-2 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-sm px-6 py-3 rounded-lg transition-colors shadow-2xs">
                    <svg class="w-4 h-4 fill-current shrink-0" viewBox="0 0 24 24">
                        <path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/>
                    </svg>
                    <span>Hubungi Hotline 24 Jam</span>
                </a>
            </div>
            
            <div class="mt-6 pt-5 border-t border-slate-100 flex flex-wrap items-center justify-center gap-y-2 gap-x-4 text-xs text-slate-500">
                <span class="inline-flex items-center gap-1.5 font-medium">
                    <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                    Hotline Teknisi Siaga: <strong class="text-slate-800">0856-0900-9009</strong>
                </span>
                <span class="text-slate-300">&bull;</span>
                <span class="text-slate-600">Unit Operasional <strong>PT JAWA JAYA ROOTER</strong></span>
            </div>
        </div>

        <!-- Directory Quicklinks -->
        <div class="mt-8">
            <h2 class="text-xs font-bold uppercase tracking-wider text-slate-700 text-center mb-4">
                Navigasi Cepat Layanan Spesialis Drainusantara
            </h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3.5">
                @foreach($popularServices as $service)
                    <a href="{{ $service['url'] }}" 
                       class="bg-white border border-slate-200 hover:border-sky-300 rounded-xl p-4 transition-colors shadow-2xs group flex flex-col justify-between">
                        <div>
                            <div class="font-bold text-slate-900 text-sm group-hover:text-sky-700 transition-colors flex items-center justify-between">
                                <span>{{ $service['title'] }}</span>
                                <span class="text-slate-400 group-hover:text-sky-700 transition-transform group-hover:translate-x-0.5">&rarr;</span>
                            </div>
                            <p class="text-xs text-slate-600 mt-1 leading-relaxed">
                                {{ $service['desc'] }}
                            </p>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>

    </div>
</div>
@endsection

