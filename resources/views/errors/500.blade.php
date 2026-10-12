@extends('layouts.app')

@section('content')
@php
    $whatsappNumber = config('app.whatsapp_number') ?: '6285609009009';
    $waText = urlencode("Halo Admin Drainusantara, website sedang mengalami kendala server (error 500) dan saya membutuhkan bantuan darurat teknisi pelancar saluran air.");
    $waUrl = "https://wa.me/{$whatsappNumber}?text={$waText}";
@endphp

<div class="py-12 sm:py-16 lg:py-24 bg-slate-50 border-b border-slate-200">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Header Status Card -->
        <div class="bg-white border border-slate-200 rounded-2xl p-6 sm:p-10 md:p-12 text-center shadow-xs reveal-soft">
            
            <!-- HTTP Status Badge -->
            <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-rose-50 border border-rose-200 text-rose-900 text-xs font-bold tracking-wide uppercase mb-6">
                <span class="w-2 h-2 rounded-full bg-rose-600 animate-ping"></span>
                <span>Status HTTP 500: Gangguan Sistem Sementara</span>
            </div>

            <!-- Technical Vector Illustration: Pressure Gauge & Safety Relief Valve -->
            <div class="flex justify-center mb-6">
                <div class="w-24 h-24 sm:w-28 sm:h-28 rounded-2xl bg-rose-50/60 border border-rose-100 flex items-center justify-center text-rose-700 p-4">
                    <svg class="w-full h-full" viewBox="0 0 96 96" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                        <!-- Main Pipeline Body -->
                        <path d="M12 56H84V72H12V56Z" fill="#FFE4E6" stroke="#BE123C" stroke-width="3" stroke-linejoin="round"/>
                        <path d="M12 52H18V76H12V52Z" fill="#FECDD3" stroke="#BE123C" stroke-width="3" stroke-linejoin="round"/>
                        <path d="M78 52H84V76H78V52Z" fill="#FECDD3" stroke="#BE123C" stroke-width="3" stroke-linejoin="round"/>
                        
                        <!-- Riser to Gauge -->
                        <path d="M42 42H54V56H42V42Z" fill="#FECDD3" stroke="#BE123C" stroke-width="3" stroke-linejoin="round"/>
                        
                        <!-- Circular Pressure Gauge -->
                        <circle cx="48" cy="28" r="16" fill="white" stroke="#BE123C" stroke-width="3"/>
                        <!-- Gauge Needle Pointing to Alert Zone -->
                        <path d="M48 28L57 21" stroke="#E11D48" stroke-width="2.5" stroke-linecap="round"/>
                        <circle cx="48" cy="28" r="2.5" fill="#BE123C"/>
                        <path d="M54 18C57 21 59 25 59 29" stroke="#E11D48" stroke-width="2" stroke-linecap="round"/>
                        
                        <!-- Safety Valve Handle -->
                        <line x1="36" y1="46" x2="60" y2="46" stroke="#BE123C" stroke-width="3" stroke-linecap="round"/>
                        <line x1="48" y1="42" x2="48" y2="46" stroke="#BE123C" stroke-width="3"/>
                    </svg>
                </div>
            </div>

            <!-- Big Status Code & Headline -->
            <div class="relative mb-3">
                <span class="text-6xl sm:text-7xl md:text-8xl font-black text-slate-100 select-none tracking-tight block">500</span>
                <h1 class="text-2xl sm:text-3xl md:text-4xl font-extrabold text-slate-900 tracking-tight -mt-6 sm:-mt-8 relative">
                    Terjadi Kendala Sistem Sementara pada Server Kami
                </h1>
            </div>

            <!-- Explanatory Copy (No Em Dash, Reassuring, Problem Solver) -->
            <p class="text-sm sm:text-base text-slate-600 max-w-2xl mx-auto leading-relaxed mb-8">
                Sistem website kami sedang mengalami kendala internal dan tim teknis sedang melakukan proses perbaikan. Jika Anda saat ini sedang menghadapi situasi darurat pipa air meluap di rumah atau ruko, Anda tidak perlu menunggu perbaikan server: seluruh armada teknisi lapangan kami tetap siaga 24 jam nonstop untuk merespons panggilan Anda.
            </p>

            <!-- Action Buttons: Clear & Functional -->
            <div class="flex flex-col sm:flex-row items-center justify-center gap-3 sm:gap-4 max-w-lg mx-auto">
                <a href="{{ $waUrl }}" 
                   target="_blank" 
                   rel="noopener noreferrer" 
                   class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-6 py-3.5 rounded-lg bg-emerald-700 hover:bg-emerald-800 text-white font-bold text-sm sm:text-base transition-colors shadow-xs focus-visible:outline-hidden focus-visible:ring-2 focus-visible:ring-emerald-600">
                    <svg class="w-5 h-5 text-emerald-200" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12.031 2C6.495 2 2 6.495 2 12.031c0 1.99.58 3.844 1.583 5.409L2 22l4.707-1.542c1.517.935 3.308 1.473 5.324 1.473 5.536 0 10.031-4.495 10.031-10.031S17.567 2 12.031 2zm0 18.271c-1.748 0-3.37-.506-4.747-1.378l-.34-.216-2.793.916.936-2.721-.222-.353a8.217 8.217 0 01-1.264-4.489c0-4.57 3.719-8.289 8.289-8.289 4.57 0 8.289 3.719 8.289 8.289 0 4.57-3.719 8.289-8.289 8.289zm4.542-6.195c-.249-.124-1.473-.727-1.701-.81-.228-.083-.394-.124-.56.124-.166.249-.643.81-.788.976-.145.166-.29.187-.539.062s-1.05-.387-2.001-1.234c-.74-.66-1.24-1.475-1.385-1.724-.145-.249-.015-.383.109-.507.112-.112.249-.29.373-.435.124-.145.166-.249.249-.415.083-.166.041-.311-.021-.435-.062-.124-.56-1.349-.768-1.847-.202-.486-.407-.42-.56-.428h-.477c-.166 0-.436.062-.664.311-.228.249-.871.851-.871 2.075s.892 2.407 1.016 2.573c.124.166 1.755 2.68 4.252 3.757.594.256 1.058.409 1.42.524.597.19 1.14.163 1.569.099.479-.072 1.473-.602 1.681-1.183.208-.581.208-1.079.145-1.183-.062-.104-.228-.166-.477-.29z"/>
                    </svg>
                    <span>Hubungi Teknisi via WA</span>
                </a>

                <button type="button"
                        onclick="window.location.reload()" 
                        class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-6 py-3.5 rounded-lg border border-slate-300 bg-white hover:bg-slate-50 text-slate-800 font-bold text-sm sm:text-base transition-colors shadow-xs cursor-pointer focus-visible:outline-hidden focus-visible:ring-2 focus-visible:ring-sky-600">
                    <svg class="w-5 h-5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                    </svg>
                    <span>Muat Ulang Halaman</span>
                </button>
            </div>

            <!-- Direct Contact Box (Zero DB Dependency) -->
            <div class="mt-12 pt-8 border-t border-slate-100 text-left">
                <div class="rounded-xl bg-slate-900 text-slate-200 p-5 sm:p-6 border border-slate-800">
                    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                        <div>
                            <span class="text-[10px] font-bold uppercase tracking-wider text-amber-400 block mb-1">
                                Posko Siaga Darurat 24 Jam Nonstop
                            </span>
                            <h2 class="text-base font-bold text-white">
                                Pelayanan Lapangan Pipa Mampet Tetap Berjalan Penuh
                            </h2>
                            <p class="text-xs text-slate-400 mt-1">
                                Bengkel Kerja: Jl. Duren Sawit Raya No. 45, Jakarta Timur. Armada siap dipanggil ke seluruh Jabodetabek.
                            </p>
                        </div>
                        <a href="{{ route('home') }}" 
                           class="inline-flex items-center gap-1.5 px-4 py-2 rounded-lg bg-slate-800 hover:bg-slate-700 text-slate-200 text-xs font-semibold border border-slate-700 transition-colors shrink-0">
                            <span>Ke Beranda</span>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>

        </div>

        <!-- Micro-Trust Note -->
        <div class="mt-6 text-center text-xs text-slate-500">
            Kendala ini tercatat otomatis pada log sistem kami dan sedang ditindaklanjuti oleh teknisi pengembang Drainusantara.
        </div>

    </div>
</div>
@endsection
