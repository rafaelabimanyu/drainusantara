@extends('layouts.app')

@section('content')
@php
    $whatsappNumber = config('app.whatsapp_number') ?: '6285609009009';
    $waText = urlencode("Halo Admin Drainusantara, saya membuka link yang tidak ditemukan (404) dan ingin berkonsultasi mengenai penanganan saluran air mampet.");
    $waUrl = "https://wa.me/{$whatsappNumber}?text={$waText}";

    $popularServices = [
        [
            'title' => 'Wastafel & Cuci Piring',
            'desc' => 'Pelancaran lemak beku dan sisa makanan di pipa leher angsa.',
            'url' => url('/#layanan'),
            'tag' => 'Pipa Dapur',
        ],
        [
            'title' => 'Kloset & Toilet Meluap',
            'desc' => 'Penanganan tuntas tanpa bongkar dudukan kloset porselen.',
            'url' => url('/#layanan'),
            'tag' => 'Darurat 24 Jam',
        ],
        [
            'title' => 'Floor Drain Kamar Mandi',
            'desc' => 'Pembersihan endapan rambut rontok dan kerak residu sabun.',
            'url' => url('/#layanan'),
            'tag' => 'Saluran Mandi',
        ],
        [
            'title' => 'Inspeksi Kamera CCTV 30M',
            'desc' => 'Deteksi visual retak atau jalur pipa tersembunyi di dinding.',
            'url' => url('/#layanan'),
            'tag' => 'Endoskopi Pipa',
        ],
        [
            'title' => 'Cakupan Area Layanan',
            'desc' => 'Posko teknisi siaga di Jabodetabek, Semarang, dan Lampung.',
            'url' => route('area.index'),
            'tag' => 'Lokasi Posko',
        ],
        [
            'title' => 'Artikel & Solusi Sanitasi',
            'desc' => 'Panduan pencegahan mampet dan bahaya cairan kimia keras.',
            'url' => route('articles.index'),
            'tag' => 'Pusat Edukasi',
        ],
    ];
@endphp

<div class="py-12 sm:py-16 lg:py-24 bg-slate-50 border-b border-slate-200">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Header Status Card -->
        <div class="bg-white border border-slate-200 rounded-2xl p-6 sm:p-10 md:p-12 text-center shadow-xs reveal-soft">
            
            <!-- HTTP Status Badge -->
            <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-sky-50 border border-sky-200 text-sky-800 text-xs font-bold tracking-wide uppercase mb-6">
                <span class="w-2 h-2 rounded-full bg-sky-600 animate-pulse"></span>
                <span>Status HTTP 404: Halaman Tidak Ditemukan</span>
            </div>

            <!-- Technical Vector Illustration: Disconnected Plumbing Fitting -->
            <div class="flex justify-center mb-6">
                <div class="w-24 h-24 sm:w-28 sm:h-28 rounded-2xl bg-sky-50/70 border border-sky-100 flex items-center justify-center text-sky-700 p-4">
                    <svg class="w-full h-full" viewBox="0 0 96 96" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                        <!-- Pipe Left Segment -->
                        <path d="M12 40H34V56H12V40Z" fill="#E0F2FE" stroke="#0369A1" stroke-width="3" stroke-linejoin="round"/>
                        <path d="M12 36H18V60H12V36Z" fill="#BAE6FD" stroke="#0369A1" stroke-width="3" stroke-linejoin="round"/>
                        <!-- Pipe Elbow Curve Up -->
                        <path d="M34 40C46 40 50 36 50 24V14H66V24C66 45 52 56 34 56" fill="#E0F2FE" stroke="#0369A1" stroke-width="3" stroke-linejoin="round"/>
                        <!-- Disconnected Pipe Right Segment -->
                        <path d="M62 70H84V86H62V70Z" fill="#F1F5F9" stroke="#64748B" stroke-width="3" stroke-linejoin="round" stroke-dasharray="4 4"/>
                        <path d="M78 66H84V90H78V66Z" fill="#E2E8F0" stroke="#64748B" stroke-width="3" stroke-linejoin="round"/>
                        <!-- Water Drops Signaling Pipe Work -->
                        <path d="M48 64C48 61 52 56 52 56C52 56 56 61 56 64C56 66.2 54.2 68 52 68C49.8 68 48 66.2 48 64Z" fill="#0284C7"/>
                        <path d="M38 74C38 72 41 68 41 68C41 68 44 72 44 74C44 75.7 42.7 77 41 77C39.3 77 38 75.7 38 74Z" fill="#38BDF8"/>
                    </svg>
                </div>
            </div>

            <!-- Big Status Code & Headline -->
            <div class="relative mb-3">
                <span class="text-6xl sm:text-7xl md:text-8xl font-black text-slate-100 select-none tracking-tight block">404</span>
                <h1 class="text-2xl sm:text-3xl md:text-4xl font-extrabold text-slate-900 tracking-tight -mt-6 sm:-mt-8 relative">
                    Jalur Tautan Terputus atau Halaman Telah Dipindahkan
                </h1>
            </div>

            <!-- Explanatory Copy (No Em Dash, Calm, Informative) -->
            <p class="text-sm sm:text-base text-slate-600 max-w-2xl mx-auto leading-relaxed mb-8">
                Halaman yang Anda tuju tidak dapat kami temukan. Kemungkinan alamat tautan salah ketik, telah kami perbarui, atau telah dialihkan. Seluruh armada teknisi pelancar saluran air Drainusantara tetap bertugas normal dan siap membantu Anda.
            </p>

            <!-- Action Buttons: Accessible & Clear Touch Targets -->
            <div class="flex flex-col sm:flex-row items-center justify-center gap-3 sm:gap-4 max-w-lg mx-auto">
                <a href="{{ route('home') }}" 
                   class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-6 py-3.5 rounded-lg bg-sky-700 hover:bg-sky-800 text-white font-bold text-sm sm:text-base transition-colors shadow-xs focus-visible:outline-hidden focus-visible:ring-2 focus-visible:ring-sky-600">
                    <svg class="w-5 h-5 text-sky-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
                    <span>Hubungi Teknisi via WA</span>
                </a>
            </div>

            <!-- Helpful Navigation Alternatives (Real Existing Services) -->
            <div class="mt-12 pt-8 border-t border-slate-100 text-left">
                <div class="flex items-center justify-between mb-4">
                    <span class="text-xs font-bold uppercase tracking-wider text-slate-500">
                        Pencarian Cepat Solusi Masalah Saluran Air
                    </span>
                    <a href="{{ route('home') }}" class="text-xs font-semibold text-sky-700 hover:text-sky-800">
                        Lihat Beranda
                    </a>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3">
                    @foreach($popularServices as $service)
                        <a href="{{ $service['url'] }}" 
                           class="p-3.5 rounded-xl border border-slate-200/90 bg-slate-50/50 hover:bg-sky-50/40 hover:border-sky-200 transition-colors group flex flex-col justify-between">
                            <div>
                                <div class="flex items-center justify-between gap-2 mb-1.5">
                                    <span class="text-xs font-bold text-slate-900 group-hover:text-sky-700 transition-colors">
                                        {{ $service['title'] }}
                                    </span>
                                    <span class="text-[10px] font-semibold text-sky-700 bg-sky-100/60 px-2 py-0.5 rounded-md">
                                        {{ $service['tag'] }}
                                    </span>
                                </div>
                                <p class="text-xs text-slate-500 leading-relaxed">
                                    {{ $service['desc'] }}
                                </p>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>

        </div>

        <!-- Micro-Trust Footer Note -->
        <div class="mt-6 text-center text-xs text-slate-500">
            Butuh jadwal kunjungan cepat? Posko teknisi Drainusantara siaga melayani wilayah Jakarta, Bogor, Depok, Tangerang, Bekasi, Semarang, dan Bandar Lampung.
        </div>

    </div>
</div>
@endsection
