@extends('layouts.app')

@section('content')
@php
    $whatsappNumber = config('app.whatsapp_number') ?: '6285609009009';
    $waText = urlencode("Halo Tim Dispatcher Darurat Drainusantara (PT Jawa Jaya Rooter), saya membutuhkan layanan teknisi pelancar saluran pipa darurat segera ke lokasi.");
    $waUrl = "https://wa.me/{$whatsappNumber}?text={$waText}";
@endphp

<div class="py-12 sm:py-16 lg:py-24 bg-slate-50 border-b border-slate-200">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Header Status Card -->
        <div class="bg-white border border-slate-200 rounded-2xl p-6 sm:p-10 md:p-12 text-center shadow-xs">
            
            <!-- HTTP Status Eyebrow -->
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-md border border-sky-200 bg-sky-50 text-xs font-mono font-bold tracking-wider text-sky-800 uppercase mb-4">
                <span>Status HTTP 503: Pemeliharaan Sistem Berkala</span>
            </div>

            <!-- Technical Vector Illustration: Maintenance Gear & Plumbing Wrench -->
            <div class="flex justify-center mb-6">
                <div class="w-24 h-24 sm:w-28 sm:h-28 rounded-2xl bg-sky-50/80 border border-sky-100 flex items-center justify-center text-sky-700 p-4">
                    <svg class="w-full h-full" viewBox="0 0 96 96" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                        <!-- Pipeline Base -->
                        <path d="M12 60H84V74H12V60Z" fill="#E0F2FE" stroke="#0369A1" stroke-width="3" stroke-linejoin="round"/>
                        <path d="M12 56H18V78H12V56Z" fill="#BAE6FD" stroke="#0369A1" stroke-width="3" stroke-linejoin="round"/>
                        <path d="M78 56H84V78H78V56Z" fill="#BAE6FD" stroke="#0369A1" stroke-width="3" stroke-linejoin="round"/>
                        
                        <!-- Center Inspection Flange -->
                        <rect x="40" y="44" width="16" height="16" rx="2" fill="#BAE6FD" stroke="#0369A1" stroke-width="3"/>
                        
                        <!-- Maintenance Gear -->
                        <path d="M48 22C43.58 22 40 25.58 40 30C40 34.42 43.58 38 48 38C52.42 38 56 34.42 56 30C56 25.58 52.42 22 48 22Z" fill="#FFFFFF" stroke="#0284C7" stroke-width="3"/>
                        <path d="M48 18V22M48 38V42M36 30H40M56 30H60M39.5 21.5L42.5 24.5M53.5 35.5L56.5 38.5M39.5 38.5L42.5 35.5M53.5 24.5L56.5 21.5" stroke="#0284C7" stroke-width="2.5" stroke-linecap="round"/>
                        <circle cx="48" cy="30" r="3" fill="#0284C7"/>
                    </svg>
                </div>
            </div>

            <!-- Big Status Code & Headline -->
            <div class="relative mb-3">
                <span class="text-6xl sm:text-7xl md:text-8xl font-black text-slate-100 select-none tracking-tight block">503</span>
                <h1 class="text-2xl sm:text-3xl md:text-4xl font-extrabold text-slate-900 tracking-tight -mt-6 sm:-mt-8 relative">
                    Platform Sedang Pemeliharaan Sistem
                </h1>
            </div>

            <!-- Explanatory Copy: Reassuring Emergency Dispatch -->
            <p class="text-sm sm:text-base text-slate-600 max-w-2xl mx-auto leading-relaxed mb-6">
                Website Drainusantara sedang dalam proses pemeliharaan rutin guna peningkatan performa dan keamanan. Anda tidak perlu khawatir: <strong>seluruh armada teknisi mekanis non-destruktif dan layanan darurat tetap siaga 24 jam penuh</strong> di bawah naungan <strong>PT Jawa Jaya Rooter</strong>.
            </p>

            <!-- Emergency Hotline Badge Card -->
            <div class="mb-8 max-w-md mx-auto p-4 bg-emerald-50 border border-emerald-200 rounded-xl text-emerald-950 flex flex-col sm:flex-row items-center justify-between gap-3 text-left">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-lg bg-emerald-700 text-white flex items-center justify-center shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                        </svg>
                    </div>
                    <div>
                        <span class="text-xs font-bold uppercase tracking-wider text-emerald-800 block">Hotline Darurat Siaga 24 Jam</span>
                        <span class="text-sm sm:text-base font-extrabold text-slate-900">0856-0900-9009</span>
                    </div>
                </div>
                <div class="text-xs font-semibold px-2.5 py-1 rounded-md bg-white border border-emerald-300 text-emerald-800 shrink-0">
                    Respon Cepat
                </div>
            </div>

            <!-- Action Buttons: WhatsApp Emergency & Check Back Later -->
            <div class="flex flex-col sm:flex-row items-center justify-center gap-3 sm:gap-4 max-w-lg mx-auto">
                <a href="{{ $waUrl }}" 
                   target="_blank" 
                   rel="noopener noreferrer" 
                   class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-6 py-3.5 rounded-lg bg-emerald-700 hover:bg-emerald-800 text-white font-bold text-sm sm:text-base transition-colors shadow-xs focus-visible:outline-hidden focus-visible:ring-2 focus-visible:ring-emerald-600">
                    <svg class="w-5 h-5 text-emerald-200" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12.031 2C6.495 2 2 6.495 2 12.031c0 1.99.58 3.844 1.583 5.409L2 22l4.707-1.542c1.517.935 3.308 1.473 5.324 1.473 5.536 0 10.031-4.495 10.031-10.031S17.567 2 12.031 2zm0 18.271c-1.748 0-3.37-.506-4.747-1.378l-.34-.216-2.793.916.936-2.721-.222-.353a8.217 8.217 0 01-1.264-4.489c0-4.57 3.719-8.289 8.289-8.289 4.57 0 8.289 3.719 8.289 8.289 0 4.57-3.719 8.289-8.289 8.289zm4.542-6.195c-.249-.124-1.473-.727-1.701-.81-.228-.083-.394-.124-.56.124-.166.249-.643.81-.788.976-.145.166-.29.187-.539.062s-1.05-.387-2.001-1.234c-.74-.66-1.24-1.475-1.385-1.724-.145-.249-.015-.383.109-.507.112-.112.249-.29.373-.435.124-.145.166-.249.249-.415.083-.166.041-.311-.021-.435-.062-.124-.56-1.349-.768-1.847-.202-.486-.407-.42-.56-.428h-.477c-.166 0-.436.062-.664.311-.228.249-.871.851-.871 2.075s.892 2.407 1.016 2.573c.124.166 1.755 2.68 4.252 3.757.594.256 1.058.409 1.42.524.597.19 1.14.163 1.569.099.479-.072 1.473-.602 1.681-1.183.208-.581.208-1.079.145-1.183-.062-.104-.228-.166-.477-.29z"/>
                    </svg>
                    <span>Hubungi Dispatcher via WA</span>
                </a>

                <button type="button" 
                        onclick="window.location.reload();" 
                        class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-6 py-3.5 rounded-lg bg-white hover:bg-slate-50 text-slate-700 font-bold text-sm sm:text-base transition-colors border border-slate-300 shadow-2xs focus-visible:outline-hidden focus-visible:ring-2 focus-visible:ring-slate-400">
                    <svg class="w-5 h-5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                    </svg>
                    <span>Muat Ulang Halaman</span>
                </button>
            </div>

            <!-- Standard Commitments Reminder -->
            <div class="mt-10 pt-6 border-t border-slate-100 grid grid-cols-1 sm:grid-cols-3 gap-4 text-left">
                <div class="flex items-start gap-2.5">
                    <div class="w-6 h-6 rounded-md bg-sky-50 text-sky-700 flex items-center justify-center shrink-0 text-xs font-bold">✓</div>
                    <p class="text-xs text-slate-600"><strong>No Cure No Pay:</strong> Tanpa hasil lancar tuntas, gratis biaya jasa mekanis.</p>
                </div>
                <div class="flex items-start gap-2.5">
                    <div class="w-6 h-6 rounded-md bg-sky-50 text-sky-700 flex items-center justify-center shrink-0 text-xs font-bold">✓</div>
                    <p class="text-xs text-slate-600"><strong>Garansi 30 Hari:</strong> Nota fisik resmi bergaransi re-visit bebas biaya.</p>
                </div>
                <div class="flex items-start gap-2.5">
                    <div class="w-6 h-6 rounded-md bg-sky-50 text-sky-700 flex items-center justify-center shrink-0 text-xs font-bold">✓</div>
                    <p class="text-xs text-slate-600"><strong>Non-Destruktif:</strong> 100% tanpa bongkar keramik lantai atau tembok.</p>
                </div>
            </div>

        </div>

        <!-- Trust Note Footer -->
        <div class="mt-8 text-center text-xs text-slate-500">
            Badan Usaha Resmi &bull; <strong>PT JAWA JAYA ROOTER</strong> &bull; Nomor Registrasi Kemenkumham &amp; NIB OSS Terverifikasi
        </div>

    </div>
</div>
@endsection

