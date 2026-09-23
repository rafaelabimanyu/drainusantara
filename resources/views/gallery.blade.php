@extends('layouts.app')

@section('content')
@php
    $whatsappNumber = config('app.whatsapp_number', '6281234567890');
    $generalWaUrl = "https://wa.me/{$whatsappNumber}?text=" . urlencode("Halo Drainusantara, saya ingin konsultasi penanganan saluran pipa mampet.");
@endphp

<div>
    <!-- Hero Banner -->
    <section class="relative bg-slate-50 border-b border-slate-200 pt-8 pb-12 lg:pt-12 lg:pb-16 overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center fade-up">
            <!-- Breadcrumb -->
            <nav class="flex items-center justify-center gap-2 text-xs text-slate-500 mb-6 font-medium" aria-label="Breadcrumb">
                <a href="{{ url('/') }}" class="hover:text-sky-700 transition-colors flex items-center gap-1.5">
                    <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                    </svg>
                    <span>Beranda</span>
                </a>
                <span class="text-slate-300">/</span>
                <span class="text-sky-700 font-bold">Galeri Dokumentasi</span>
            </nav>

            <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-white border border-slate-200 text-slate-800 text-xs font-bold rounded-full uppercase tracking-wider mb-3 shadow-2xs">
                DOKUMENTASI TEKNIS LAPANGAN
            </span>
            <h1 class="text-3xl sm:text-4xl md:text-5xl font-extrabold text-slate-900 tracking-tight max-w-3xl mx-auto leading-tight">
                Galeri Hasil Pengerjaan <span class="text-sky-700">Drainusantara</span>
            </h1>
            <p class="mt-3 text-slate-600 text-sm sm:text-base max-w-2xl mx-auto leading-relaxed">
                Bukti nyata dokumentasi foto sebelum & sesudah tim teknisi melancarkan saluran mampet menggunakan mesin rooter spiral baja dan kamera endoskopik CCTV 30 meter.
            </p>
        </div>
    </section>

    <!-- Gallery Grid Section -->
    <section class="py-14 sm:py-20 bg-white border-b border-slate-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 lg:gap-8">
                @forelse($galleries as $item)
                <div class="bg-white rounded-2xl border border-slate-200/90 overflow-hidden shadow-sm hover:shadow-md hover:border-sky-300 transition-all flex flex-col group fade-up delay-{{ min($loop->iteration * 100, 300) }}">
                    <!-- Before / After Photos -->
                    <div class="relative bg-slate-900 overflow-hidden border-b border-slate-100">
                        @if($item->before_image && $item->after_image)
                            <div class="grid grid-cols-2 gap-1 p-1 bg-slate-900">
                                <div class="relative group/img overflow-hidden">
                                    <img src="{{ $item->before_image }}" alt="Sebelum - {{ $item->title }}" width="400" height="250" loading="lazy" decoding="async" class="w-full h-48 sm:h-56 object-cover transform group-hover/img:scale-105 transition duration-300">
                                    <span class="absolute top-2.5 left-2.5 bg-red-600 text-white text-[10px] font-bold px-2 py-0.5 rounded-md shadow-xs">
                                        SEBELUM (MAMPET)
                                    </span>
                                </div>
                                <div class="relative group/img overflow-hidden">
                                    <img src="{{ $item->after_image }}" alt="Sesudah - {{ $item->title }}" width="400" height="250" loading="lazy" decoding="async" class="w-full h-48 sm:h-56 object-cover transform group-hover/img:scale-105 transition duration-300">
                                    <span class="absolute top-2.5 right-2.5 bg-emerald-600 text-white text-[10px] font-bold px-2 py-0.5 rounded-md shadow-xs">
                                        SESUDAH (PLONG)
                                    </span>
                                </div>
                            </div>
                        @elseif($item->image)
                            <img src="{{ $item->image }}" alt="{{ $item->title }}" width="800" height="450" loading="lazy" decoding="async" class="w-full h-64 object-cover transform group-hover:scale-105 transition duration-300">
                        @else
                            <div class="w-full h-56 bg-slate-100 text-xs flex items-center justify-center text-slate-400 font-medium">
                                Dokumentasi Lapangan Drainusantara
                            </div>
                        @endif
                    </div>

                    <!-- Content Details -->
                    <div class="p-6 flex-1 flex flex-col justify-between">
                        <div>
                            <div class="flex items-center justify-between gap-2 mb-2.5">
                                <span class="px-2.5 py-0.5 text-xs font-bold bg-sky-50 text-sky-700 border border-sky-200 rounded-full">
                                    {{ $item->service ? $item->service->name : 'Plumbing Spesialis' }}
                                </span>
                                <span class="text-xs font-bold text-emerald-700 flex items-center gap-1">
                                    ✓ 100% Tanpa Bongkar
                                </span>
                            </div>

                            <h3 class="text-xl font-bold text-slate-900 group-hover:text-sky-700 transition-colors leading-snug tracking-tight">
                                {{ $item->title }}
                            </h3>

                            <p class="mt-2.5 text-slate-600 text-sm leading-relaxed">
                                {{ $item->description }}
                            </p>
                        </div>

                        <!-- CTA WhatsApp Action -->
                        @php
                            $waMessage = urlencode("Halo Teknisi Drainusantara, saya tertarik dengan pengerjaan '{$item->title}'. Saluran pipa saya juga mengalami masalah serupa, mohon info estimasi biaya dan jadwal kunjungan.");
                            $waUrl = "https://wa.me/{$whatsappNumber}?text={$waMessage}";
                        @endphp
                        <div class="mt-6 pt-4 border-t border-slate-100 flex items-center justify-between gap-4">
                            <span class="text-xs bg-amber-50 text-amber-900 px-2.5 py-1 rounded-full border border-amber-200 font-bold">
                                Garansi 30 Hari
                            </span>
                            <a href="{{ $waUrl }}" target="_blank" rel="noopener noreferrer" 
                               class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs shadow-xs transition-all">
                                <span>Pesan Layanan Serupa &rarr;</span>
                            </a>
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-span-2 py-16 text-center text-slate-500">
                    Dokumentasi galeri sedang dipersiapkan.
                </div>
                @endforelse
            </div>
        </div>
    </section>

    <!-- Consultation CTA Section -->
    <section class="py-14 lg:py-20 bg-slate-900 text-white">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center fade-up">
            <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-slate-800 border border-slate-700 text-sky-400 text-xs font-bold rounded-full uppercase tracking-wider mb-3">
                KONSULTASI GRATIS
            </span>
            <h2 class="text-3xl sm:text-4xl font-extrabold text-white tracking-tight">Saluran Pipa Rumah Anda Sedang Mampet?</h2>
            <p class="mt-3 text-slate-400 text-sm sm:text-base max-w-xl mx-auto leading-relaxed">
                Hindari risiko menuang soda api yang dapat merusak instalasi pipa PVC. Hubungi teknisi profesional Drainusantara sekarang juga!
            </p>
            <div class="mt-8 flex flex-col sm:flex-row items-center justify-center gap-4">
                <a href="{{ $generalWaUrl }}" 
                   target="_blank" rel="noopener noreferrer"
                   class="inline-flex items-center gap-2 px-8 py-4 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-sm shadow-md transition-all">
                    <span>Hubungi Teknisi via WhatsApp (Gratis Konsultasi)</span>
                    <span class="text-base">&rarr;</span>
                </a>
            </div>
        </div>
    </section>
</div>
@endsection
