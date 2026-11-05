@extends('layouts.app')

@section('content')
@php
    $whatsappNumber = config('app.whatsapp_number') ?: '6285609009009';
    $waText = urlencode("Halo Admin Drainusantara, sesi web saya berakhir (419) dan saya ingin langsung berkonsultasi mengenai penanganan saluran air mampet.");
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
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-md border border-amber-200 bg-amber-50 text-xs font-mono font-bold tracking-wider text-amber-800 uppercase mb-4">
                <span>Status HTTP 419: Sesi Pengisian Berakhir</span>
            </div>

            <!-- Technical Vector Illustration: Security Token Refresh / Clock Loop -->
            <div class="flex justify-center mb-6">
                <div class="w-24 h-24 sm:w-28 sm:h-28 rounded-2xl bg-amber-50/70 border border-amber-200 flex items-center justify-center text-amber-700 p-4">
                    <svg class="w-full h-full" viewBox="0 0 96 96" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                        <!-- Shield Background Outline -->
                        <path d="M48 14L20 26V46C20 64 32 80 48 86C64 80 76 64 76 46V26L48 14Z" fill="#FEF3C7" stroke="#D97706" stroke-width="3" stroke-linejoin="round"/>
                        <!-- Clock / Timeout Hands inside Shield -->
                        <circle cx="48" cy="50" r="18" fill="#FFFFFF" stroke="#B45309" stroke-width="2.5"/>
                        <path d="M48 38V50L56 54" stroke="#B45309" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
                        <!-- Refresh Circular Arrow -->
                        <path d="M68 34C72 38 74 44 74 50" stroke="#D97706" stroke-width="2.5" stroke-linecap="round"/>
                        <path d="M72 30L68 34L64 30" stroke="#D97706" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </div>
            </div>

            <!-- Big Status Code & Headline -->
            <div class="relative mb-3">
                <span class="text-6xl sm:text-7xl md:text-8xl font-black text-slate-100 select-none tracking-tight block">419</span>
                <h1 class="text-2xl sm:text-3xl md:text-4xl font-extrabold text-slate-900 tracking-tight -mt-6 sm:-mt-8 relative">
                    Sesi Keamanan Halaman Telah Berakhir
                </h1>
            </div>

            <!-- Explanatory Copy -->
            <p class="text-sm sm:text-base text-slate-600 max-w-2xl mx-auto leading-relaxed mb-8">
                Halaman ini dibiarkan tidak aktif dalam beberapa waktu sehingga masa berlaku token keamanan formulir kedaluwarsa. Silakan muat ulang halaman atau kembali ke formulir sebelumnya untuk melanjutkan pengisian data Anda.
            </p>

            <!-- Action Buttons: Reload, Back, and WhatsApp -->
            <div class="flex flex-col sm:flex-row items-center justify-center gap-3 sm:gap-4 max-w-lg mx-auto">
                <button type="button" 
                        onclick="window.location.reload();" 
                        class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-6 py-3.5 rounded-lg bg-sky-700 hover:bg-sky-800 text-white font-bold text-sm sm:text-base transition-colors shadow-xs cursor-pointer focus-visible:outline-hidden focus-visible:ring-2 focus-visible:ring-sky-600">
                    <svg class="w-5 h-5 text-sky-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                    </svg>
                    <span>Segarkan Halaman</span>
                </button>

                <a href="{{ route('home') }}" 
                   class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-6 py-3.5 rounded-lg bg-slate-100 hover:bg-slate-200 text-slate-800 font-bold text-sm sm:text-base transition-colors border border-slate-300 focus-visible:outline-hidden focus-visible:ring-2 focus-visible:ring-slate-500">
                    <svg class="w-5 h-5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                    </svg>
                    <span>Kembali ke Beranda</span>
                </a>

                <a href="{{ $waUrl }}" 
                   target="_blank" 
                   rel="noopener noreferrer" 
                   class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-6 py-3.5 rounded-lg bg-emerald-700 hover:bg-emerald-800 text-white font-bold text-sm sm:text-base transition-colors shadow-xs focus-visible:outline-hidden focus-visible:ring-2 focus-visible:ring-emerald-600">
                    <svg class="w-5 h-5 text-emerald-200" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12.031 2C6.495 2 2 6.495 2 12.031c0 1.99.58 3.844 1.583 5.409L2 22l4.707-1.542c1.517.935 3.308 1.473 5.324 1.473 5.536 0 10.031-4.495 10.031-10.031S17.567 2 12.031 2zm0 18.271c-1.748 0-3.37-.506-4.747-1.378l-.34-.216-2.793.916.936-2.721-.222-.353a8.217 8.217 0 01-1.264-4.489c0-4.57 3.719-8.289 8.289-8.289 4.57 0 8.289 3.719 8.289 8.289 0 4.57-3.719 8.289-8.289 8.289zm4.542-6.195c-.249-.124-1.473-.727-1.701-.81-.228-.083-.394-.124-.56.124-.166.249-.643.81-.788.976-.145.166-.29.187-.539.062s-1.05-.387-2.001-1.234c-.74-.66-1.24-1.475-1.385-1.724-.145-.249-.015-.383.109-.507.112-.112.249-.29.373-.435.124-.145.166-.249.249-.415.083-.166.041-.311-.021-.435-.062-.124-.56-1.349-.768-1.847-.202-.486-.407-.42-.56-.428h-.477c-.166 0-.436.062-.664.311-.228.249-.871.851-.871 2.075s.892 2.407 1.016 2.573c.124.166 1.755 2.68 4.252 3.757.594.256 1.058.409 1.42.524.597.19 1.14.163 1.569.099.479-.072 1.473-.602 1.681-1.183.208-.581.208-1.079.145-1.183-.062-.104-.228-.166-.477-.29z"/>
                    </svg>
                    <span>Hubungi WA</span>
                </a>
            </div>

            <!-- Helpful Navigation Alternatives -->
            <div class="mt-12 pt-8 border-t border-slate-100 text-left">
                <div class="flex items-center justify-between mb-4">
                    <span class="text-xs font-bold uppercase tracking-wider text-slate-500">
                        Pilihan Navigasi Layanan Terkait
                    </span>
                    <a href="{{ route('home') }}" class="text-xs font-semibold text-sky-700 hover:text-sky-800">
                        Beranda Utama
                    </a>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    @foreach($popularServices as $svc)
                    <a href="{{ $svc['url'] }}" 
                       class="group p-3.5 rounded-xl border border-slate-200 hover:border-sky-300 hover:bg-sky-50/50 transition-all text-left flex items-start gap-3">
                        <div class="w-8 h-8 rounded-lg bg-sky-50 text-sky-700 border border-sky-100 flex items-center justify-center shrink-0 group-hover:bg-sky-700 group-hover:text-white transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                            </svg>
                        </div>
                        <div>
                            <div class="text-xs sm:text-sm font-bold text-slate-900 group-hover:text-sky-700 transition-colors">
                                {{ $svc['title'] }}
                            </div>
                            <p class="text-xs text-slate-500 mt-0.5 line-clamp-1">
                                {{ $svc['desc'] }}
                            </p>
                        </div>
                    </a>
                    @endforeach
                </div>
            </div>

        </div>

        <!-- Trust Note Footer -->
        <div class="mt-8 text-center text-xs text-slate-500">
            Unit Layanan Resmi &bull; <strong>PT JAWA JAYA ROOTER</strong> &bull; Hotline Darurat: <strong>0856-0900-9009</strong>
        </div>

    </div>
</div>
@endsection

