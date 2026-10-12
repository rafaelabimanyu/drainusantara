@extends('layouts.app')

@section('content')
@php
    $whatsappNumber = config('app.whatsapp_number') ?: '6285609009009';
    $waText = urlencode("Halo Admin Drainusantara, saya mengakses link yang telah dinonaktifkan permanen (410) dan ingin menanyakan informasi layanan terkait.");
    $waUrl = "https://wa.me/{$whatsappNumber}?text={$waText}";

    $recommendedSections = [
        [
            'title' => 'Layanan & Solusi Pipa Terkini',
            'desc' => 'Daftar penanganan pipa wastafel, kloset, talang air, dan saluran buang.',
            'url' => route('home'),
            'badge' => 'Katalog Utama',
        ],
        [
            'title' => 'Pusat Pengetahuan Sanitasi',
            'desc' => 'Artikel edukasi perawatan instalasi pipa PVC dan mitigasi risiko kimia.',
            'url' => route('articles.index'),
            'badge' => 'Artikel Edukasi',
        ],
        [
            'title' => 'Dokumentasi Galeri Kerja',
            'desc' => 'Bukti nyata hasil pembersihan endapan lemak dan kotoran pipa di lapangan.',
            'url' => route('gallery'),
            'badge' => 'Foto Real',
        ],
    ];
@endphp

<div class="py-12 sm:py-16 lg:py-24 bg-slate-50 border-b border-slate-200">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Header Status Card -->
        <div class="bg-white border border-slate-200 rounded-2xl p-6 sm:p-10 md:p-12 text-center shadow-xs reveal-soft">
            
            <!-- HTTP Status Badge -->
            <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-amber-50 border border-amber-200 text-amber-900 text-xs font-bold tracking-wide uppercase mb-6">
                <span class="w-2 h-2 rounded-full bg-amber-500"></span>
                <span>Status HTTP 410: Konten Dinonaktifkan Permanen</span>
            </div>

            <!-- Technical Vector Illustration: Sealed Pipe Cap -->
            <div class="flex justify-center mb-6">
                <div class="w-24 h-24 sm:w-28 sm:h-28 rounded-2xl bg-amber-50/60 border border-amber-100 flex items-center justify-center text-amber-700 p-4">
                    <svg class="w-full h-full" viewBox="0 0 96 96" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                        <!-- Pipe Left Base -->
                        <path d="M12 40H44V56H12V40Z" fill="#FEF3C7" stroke="#B45309" stroke-width="3" stroke-linejoin="round"/>
                        <path d="M12 36H18V60H12V36Z" fill="#FDE68A" stroke="#B45309" stroke-width="3" stroke-linejoin="round"/>
                        <!-- Pipe Coupling Flange -->
                        <path d="M44 32H54V64H44V32Z" fill="#FDE68A" stroke="#B45309" stroke-width="3" stroke-linejoin="round"/>
                        <!-- Threaded Pipe Cap Seal (Dop Pipa Tertutup Rapat) -->
                        <path d="M54 36H72C76.4183 36 80 39.5817 80 44V52C80 56.4183 76.4183 60 72 60H54V36Z" fill="#F59E0B" stroke="#B45309" stroke-width="3" stroke-linejoin="round"/>
                        <!-- Cap Rib Detail -->
                        <line x1="62" y1="40" x2="62" y2="56" stroke="#B45309" stroke-width="2.5" stroke-linecap="round"/>
                        <line x1="70" y1="42" x2="70" y2="54" stroke="#B45309" stroke-width="2.5" stroke-linecap="round"/>
                        <!-- Inspection Verified Seal Tick -->
                        <circle cx="70" cy="74" r="10" fill="#059669"/>
                        <path d="M66 74L69 77L75 71" stroke="white" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </div>
            </div>

            <!-- Big Status Code & Headline -->
            <div class="relative mb-3">
                <span class="text-6xl sm:text-7xl md:text-8xl font-black text-slate-100 select-none tracking-tight block">410</span>
                <h1 class="text-2xl sm:text-3xl md:text-4xl font-extrabold text-slate-900 tracking-tight -mt-6 sm:-mt-8 relative">
                    Halaman atau Informasi Ini Telah Ditutup Permanen
                </h1>
            </div>

            <!-- Explanatory Copy (No Em Dash, Honest, Transparent) -->
            <p class="text-sm sm:text-base text-slate-600 max-w-2xl mx-auto leading-relaxed mb-8">
                Konten arsip, promosi lama, atau halaman yang Anda tuju telah kami nonaktifkan secara permanen dari server dan tidak akan dipulihkan kembali. Langkah ini kami terapkan agar seluruh spesifikasi teknis, garansi resmi 30 hari, serta acuan biaya layanan Drainusantara selalu akurat dan terverifikasi.
            </p>

            <!-- Action Buttons: Clear & High Contrast -->
            <div class="flex flex-col sm:flex-row items-center justify-center gap-3 sm:gap-4 max-w-lg mx-auto">
                <a href="{{ route('home') }}" 
                   class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-6 py-3.5 rounded-lg bg-sky-700 hover:bg-sky-800 text-white font-bold text-sm sm:text-base transition-colors shadow-xs focus-visible:outline-hidden focus-visible:ring-2 focus-visible:ring-sky-600">
                    <svg class="w-5 h-5 text-sky-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                    </svg>
                    <span>Ke Halaman Utama</span>
                </a>

                <a href="{{ $waUrl }}" 
                   target="_blank" 
                   rel="noopener noreferrer" 
                   class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-6 py-3.5 rounded-lg bg-emerald-700 hover:bg-emerald-800 text-white font-bold text-sm sm:text-base transition-colors shadow-xs focus-visible:outline-hidden focus-visible:ring-2 focus-visible:ring-emerald-600">
                    <svg class="w-5 h-5 text-emerald-200" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12.031 2C6.495 2 2 6.495 2 12.031c0 1.99.58 3.844 1.583 5.409L2 22l4.707-1.542c1.517.935 3.308 1.473 5.324 1.473 5.536 0 10.031-4.495 10.031-10.031S17.567 2 12.031 2zm0 18.271c-1.748 0-3.37-.506-4.747-1.378l-.34-.216-2.793.916.936-2.721-.222-.353a8.217 8.217 0 01-1.264-4.489c0-4.57 3.719-8.289 8.289-8.289 4.57 0 8.289 3.719 8.289 8.289 0 4.57-3.719 8.289-8.289 8.289zm4.542-6.195c-.249-.124-1.473-.727-1.701-.81-.228-.083-.394-.124-.56.124-.166.249-.643.81-.788.976-.145.166-.29.187-.539.062s-1.05-.387-2.001-1.234c-.74-.66-1.24-1.475-1.385-1.724-.145-.249-.015-.383.109-.507.112-.112.249-.29.373-.435.124-.145.166-.249.249-.415.083-.166.041-.311-.021-.435-.062-.124-.56-1.349-.768-1.847-.202-.486-.407-.42-.56-.428h-.477c-.166 0-.436.062-.664.311-.228.249-.871.851-.871 2.075s.892 2.407 1.016 2.573c.124.166 1.755 2.68 4.252 3.757.594.256 1.058.409 1.42.524.597.19 1.14.163 1.569.099.479-.072 1.473-.602 1.681-1.183.208-.581.208-1.079.145-1.183-.062-.104-.228-.166-.477-.29z"/>
                    </svg>
                    <span>Konfirmasi via WhatsApp</span>
                </a>
            </div>

            <!-- Alternative Relevant Destinations -->
            <div class="mt-12 pt-8 border-t border-slate-100 text-left">
                <div class="mb-4">
                    <span class="text-xs font-bold uppercase tracking-wider text-slate-500">
                        Destinasi Resmi Terkini Drainusantara
                    </span>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                    @foreach($recommendedSections as $section)
                        <a href="{{ $section['url'] }}" 
                           class="p-4 rounded-xl border border-slate-200/90 bg-slate-50/50 hover:bg-sky-50/40 hover:border-sky-200 transition-colors group flex flex-col justify-between">
                            <div>
                                <div class="flex items-center justify-between gap-2 mb-1.5">
                                    <span class="text-xs font-bold text-slate-900 group-hover:text-sky-700 transition-colors">
                                        {{ $section['title'] }}
                                    </span>
                                </div>
                                <p class="text-xs text-slate-500 leading-relaxed">
                                    {{ $section['desc'] }}
                                </p>
                            </div>
                            <span class="mt-3 text-[10px] font-semibold text-sky-700 bg-sky-100/60 px-2 py-0.5 rounded-md self-start">
                                {{ $section['badge'] }}
                            </span>
                        </a>
                    @endforeach
                </div>
            </div>

        </div>

        <!-- Micro-Trust Note -->
        <div class="mt-6 text-center text-xs text-slate-500">
            Perlu konfirmasi mengenai dokumen SPK, penawaran proyek B2B terdahulu, atau nota pekerjaan lama? Tim kantor pusat Drainusantara siap melayani konfirmasi arsip melalui WhatsApp.
        </div>

    </div>
</div>
@endsection
